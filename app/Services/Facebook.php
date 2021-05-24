<?php


namespace App\Services;

use App\Models\Account;
use App\Models\Integration;
use App\Mail\SendEmail;
use App\Notifications\TokenFacebookExpired;
use App\Notifications\TokenFacebookExpiring;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use stdClass;


class Facebook
{
    /**
     * @param $fbToken
     * @return mixed
     */
    public function getAccessTokenInfo($fbToken)
    {
        $params = 'oauth/access_token_info?client_id=' . env('FACEBOOK_CLIENT_ID') . '&access_token=' . $fbToken;
        $response = Http::retry(3, 1000)->get('https://graph.facebook.com/v10.0/' . $params);
        return json_decode($response->body());
    }

    /**
     * @param $fbToken
     * @param string $params
     * @return mixed|null
     */
    public function getFbData($fbToken, string $params)
    {
        $response = Http::retry(3,
            1000)->withToken($fbToken)->get('https://graph.facebook.com/v10.0/' . $params);

        if (!isset($response)) {
            return null;
        }

        return json_decode($response->body());
    }

    /**
     * @param $fbObjectId
     * @param $fbToken
     * @param $fields
     * @param $filtering
     * @param null $before
     * @param null $after
     * @return mixed|null
     */
    public function getFbCampaigns(
        $fbObjectId,
        $fbToken,
        $fields,
        $filtering,
        $before = null,
        $after = null
    ) {
        $params = $fbObjectId . '/campaigns?fields='
            . $fields
            . ($filtering ? '&filtering=' . $filtering : null)
            . ($before ? '&before=' . $before : null)
            . ($after ? '&after=' . $after : null)
            . "&limit=25";
        return self::getFbData($fbToken, $params);
    }

    /**
     * @param $fbAdAccount
     * @param $fbToken
     * @param $fields
     * @param null $before
     * @param null $after
     * @return mixed|null
     */
    public function getFbInsights(
        $fbAdAccount,
        $fbToken,
        $fields,
        $before = null,
        $after = null
    ) {
        $params = $fbAdAccount . '/customconversions?fields='
            . $fields
            . ($before ? '&before=' . $before : null)
            . ($after ? '&after=' . $after : null)
            . "&limit=25";
        return self::getFbData($fbToken, $params);
    }

    /**
     * @param $fbObjectId
     * @param $fbToken
     * @param $fields
     * @param $filtering
     * @param int $timeIncrement
     * @param $level
     * @param $datePreset
     * @param int $defaultSummary
     * @param int $limit
     * @param $before
     * @param $after
     * @param null $timeRange
     * @return mixed|null
     */
    public function getFbObjectInsights(
        $fbObjectId,
        $fbToken,
        $fields,
        $filtering,
        $timeIncrement = 1,
        $level,
        $datePreset,
        $defaultSummary = 1,
        $limit = 100,
        $before,
        $after,
        $timeRange = null
    ) {
        $params = $fbObjectId . '/insights?fields=' . $fields
            . ($filtering ? '&filtering=' . $filtering : null)
            . '&time_increment=' . $timeIncrement
            . ($level ? '&level=' . $level : null)
            . ($datePreset ? '&date_preset=' . $datePreset : null)
            . '&default_summary=' . $defaultSummary
            . '&limit=' . $limit
            . ($before ? '&before=' . $before : null)
            . ($after ? '&after=' . $after : null)
            . ($timeRange ? '&time_range=' . $timeRange : null);

        return self::getFbData($fbToken, $params);
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getIgAccountByUsername($user)
    {
//        $url = 'https://www.instagram.com/web/search/topsearch/?query=' . $user ;
//        $url = 'https://www.instagram.com/' . $user . '?__a=1' ;
        $url = 'https://hook.integromat.com/bpl15ex0l0d3cfe4bw1hupi5lqsy4oqe/';

        $response = Http::retry(3, 1000)->get($url, ['user' => $user]);

        return json_decode($response->body());
    }

}
