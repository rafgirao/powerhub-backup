<?php


namespace App\Services;

use App\Models\Integration;
use Illuminate\Support\Facades\Http;


class ActiveCampaign
{

    /**
     * @param $act
     * @param string $params
     * @return mixed|null
     */
    private function getAcData($act, string $params)
    {
        $acCredentials = (new Integration)->acCredentials($act);

        if (empty($acCredentials->acToken) or empty($acCredentials->acUrl)) {
            return null;
        }

        $response = Http::retry(3,
            200)->withHeaders(['Api-Token' => $acCredentials->acToken])->get($acCredentials->acUrl . '/api/3/' . $params);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /**
     * @param $act
     * @param string $slug
     * @param array $params
     * @return mixed|null
     */
    private function postAcData($act, string $slug, array $params)
    {
        $acCredentials = (new Integration)->acCredentials($act);

        if (empty($acCredentials->acToken) or empty($acCredentials->acUrl)) {
            return null;
        }

        $response = Http::retry(3,
            200)->withHeaders(['Api-Token' => $acCredentials->acToken])->post($acCredentials->acUrl . '/api/3/' . $slug , $params);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /*
     * Buscas de Lead
     */

    /**
     * @param $act
     * @param int $limit
     * @param int $offset
     * @param int $status
     * @param null $updatedAfter
     * @param null $updatedBefore
     * @param null $createdAfter
     * @param null $createdBefore
     * @param null $tagId
     * @param null $listId
     * @param null $ids
     * @param null $emailLike
     * @param null $search
     * @return mixed|null
     */
    public function getAcLeadsData(
        $act,
        $limit = 100,
        $offset = 0,
        $status = -1,
        $updatedAfter = null,
        $updatedBefore = null,
        $createdAfter = null,
        $createdBefore = null,
        $tagId = null,
        $listId = null,
        $ids = null,
        $emailLike = null,
        $search = null
    ) {
        $params = 'contacts?limit=' . $limit . '&offset=' . $offset
            . ($status ? '&status=' . $status : '')
            . ($updatedAfter ? '&filters[updated_after]=' . $updatedAfter : '')
            . ($updatedBefore ? '&filters[updated_before]=' . $updatedBefore : '')
            . ($createdAfter ? '&filters[created_after]=' . $createdAfter : '')
            . ($createdBefore ? '&filters[created_before]=' . $createdBefore : '')
            . ($tagId ? '&tagid=' . $tagId : '')
            . ($listId ? '&listid=' . $listId : '')
            . ($ids ? '&ids=' . $ids : '')
            . ($emailLike ? '&email_like=' . $emailLike : '')
            . ($search ? '&search=' . $search : '');
        $acLeadsData = self::getAcData($act, $params);

        if (!$acLeadsData) {
            return null;
        }
        return $acLeadsData;
    }

    /**
     * @param $act
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsCreatedLastWeek($act, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?&filters[created_after]=' . (date("Ymd",
                    time()) - 8) . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsUpdatedYesterday($act, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?&filters[updated_after]=' . (date("Ymd",
                    time()) - 1) . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsUpdatedToday($act, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?&filters[updated_after]=' . date("Ymd",
                time()) . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsByTagId($act, $id, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?tagid=' . $id . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsByListId($act, $id, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?listid=' . $id . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $id
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsByLeadId($act, $id, $status = null)
    {
        $params = 'contacts?ids=' . $id . '&include=contactTags.tag,fieldValues.field' . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $email
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsByEmail($act, $email, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?email_like=' . $email . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $search
     * @param int $limit
     * @param int $offset
     * @param null $status
     * @return mixed|null
     */
    public function getAcLeadsBySearch($act, $search, int $limit = 20, int $offset = 0, $status = null)
    {
        $params = 'contacts?search=' . $search . '&limit=' . $limit . '&offset=' . $offset . ($status ? '&status=' . $status : null);
        return self::getAcData($act, $params);
    }

    /*
     *  Buscas de Custom Fields
     */

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @return mixed|null
     */
    public function getAcFieldValuesByLeadId($act, $id, int $limit = 20, int $offset = 0)
    {
        $params = 'contacts/' . $id . '/fieldValues?limit=' . $limit . '&offset=' . $offset;
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @return mixed|null
     */
    public function getAcFieldValuesByFieldId($act, $id, int $limit = 20, int $offset = 0)
    {
        $params = 'fields/' . $id . '?limit=' . $limit . '&offset=' . $offset;
        return self::getAcData($act, $params);
    }

    /*
     * Buscas de Tags
     */

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @return mixed|null
     */
    public function getAcContactTagsByLeadId($act, $id, int $limit = 20, int $offset = 0)
    {
        $params = 'contacts/' . $id . '/contactTags?limit=' . $limit . '&offset=' . $offset;
        return self::getAcData($act, $params)->contactTags;
    }

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @return mixed|null
     */
    public function getAcContactTags($act, $id, int $limit = 20, int $offset = 0)
    {
        $params = '/contactTags?limit=' . $limit . '&offset=' . $offset;
        return self::getAcData($act, $params)->contactTags;
    }

    /**
     * @param $act
     * @param $id
     * @param int $limit
     * @param int $offset
     * @return mixed|null
     */
    public function getAcTagByTagId($act, $id, int $limit = 20, int $offset = 0)
    {
        $params = 'tags/' . $id . '?limit=' . $limit . '&offset=' . $offset;
        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param int $limit
     * @param int $offset
     * @return array|null
     */
    public function getAcTags($act, int $limit = 100, int $offset = 0)
    {
        $params = 'tags?limit=' . $limit . '&offset=' . $offset;
        $response = self::getAcData($act, $params);
        $total = $response->meta->total ?? 0;

        for ($offset = 0; $offset < $total; $offset = $offset + 100) {
            $params = 'tags?limit=' . $limit . '&offset=' . $offset;
            $tags = (isset($tags) ? array_merge($tags, self::getAcData($act, $params)->tags) : self::getAcData($act,
                $params)->tags);
        }
        return $tags ?? null;
    }

    /**
     * @param $act
     * @param $tagName
     * @return mixed|null
     */
    public function getAcTagsDataByTagName($act, $tagName)
    {
        $params = 'tags?search=' . $tagName;

        return self::getAcData($act, $params);
    }

    /**
     * @param $act
     * @param $contactId
     * @return string
     */
    public function getAllTagsIdByContactId($act, $contactId): string
    {
        $tags = self::getAcContactTagsByLeadId($act, $contactId)->contactTags;
        foreach ($tags as $key => $value) {
            $tag[] = self::getAcTagByTagId($act, $tags[$key]->tag)->tag->tag;
        };
        $tags = implode(", ", $tag);
        return $tags;
    }

    /**
     * @param $act
     * @param int $limit
     * @param int $offset
     * @return array|null
     */
    public function getAllCampaigns($act, int $limit = 100, int $offset = 0): ?array
    {
        $params = 'campaigns?orders[sdate]=ASC&limit=' . $limit . '&offset=' . $offset;
        $response = self::getAcData($act, $params);
        $total = $response->meta->total ?? 0;

        for ($offset = 0; $offset < $total; $offset = $offset + 100) {
            $params = 'campaigns?orders[sdate]=DESC&limit=' . $limit . '&offset=' . $offset;
            $campaigns = (isset($campaigns) ? array_merge($campaigns,
                self::getAcData($act, $params)->campaigns) : self::getAcData($act, $params)->campaigns);
        }
        return $campaigns ?? null;
    }

    /**
     * @param $act
     * @param $contact
     * @param $tag
     * @return mixed|null
     */
    public function addContactTag($act, $contact, $tag)
    {
        $slug = 'contactTags';
        $params = [
            'contactTag' => [
                'contact' => $contact,
                'tag' => $tag,
            ]
        ];
        return self::postAcData($act, $slug, $params);
    }

    /**
     * @param $act
     * @param $tagName
     * @return mixed
     */
    public function createTag($act, $tagName)
    {
        $tags = $this->getAcTagsDataByTagName($act, $tagName)->tags;

        foreach ($tags as $tag) {
            if ($tag->tag === $tagName) {
                $tagId = $tag->id;
            }
        }

        if (isset($tagId)) {
            return $this->getAcTagByTagId($act, $tagId)->tag;
        }

        $slug = 'tags';
        $params = [
            'tag' => [
                'tag' => $tagName,
                'tagType' => 'contact',
                'description' => 'Created by PowerHub',
            ]
        ];

        return $this->postAcData($act, $slug, $params)->tag;
    }

    public function getDeals($act, $limit = 100, $offset = 0, $title, $stage, $group, $status, $owner, $search)
    {
        $params = 'deals?limit=' . $limit . '&offset=' . $offset
            . ($title ? '&filters[title]=' . $title : '')
            . ($stage ? '&filters[stage]=' . $stage : '')
            . ($group ? '&filters[group]=' . $group : '')
            . ($status ? '&filters[status]=' . $status : '')
            . ($owner ? '&filters[owner]=' . $owner : '')
            . ($search ? '&filters[search]=' . $search : '');

        return self::getAcData($act, $params);
    }

    public function getDealStages($act, $limit = 100, $offset = 0, $title, $group)
    {
        $params = 'dealStages?limit=' . $limit . '&offset=' . $offset
            . ($title ? '&filters[title]=' . $title : '')
            . ($group ? '&filters[d_groupid]=' . $group : '');

        return self::getAcData($act, $params);
    }

}
