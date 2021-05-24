<?php

namespace App\Models;

use App\Services\EmailVerifier;
use App\Services\Helper;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use App\Services\Hotmart;
use App\Services\ActiveCampaign;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;


class Lead extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'account',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'country',
        'zipcode',
        'address',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
    ];

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class,'account', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function salesLeadProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sales', 'lead', 'product')
            ->using('App\Sale')
            ->withPivot(
                'transaction',
                'commission',
                'commission_currency',
                'price',
                'price_currency',
                'payment_type',
                'payment_method',
                'payment_mode',
                'recurrence_number',
                'warranty_refund',
                'installments_number',
                'affiliate',
                'payment_engine',
                'sales_nature',
                'coupon_code',
                'offer',
                'status',
                'purchase_date',
                'confirmation_date',
            )
            ->as('mysale')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function getTags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'lead_tag', 'lead', 'tag');
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $dateType
     */
    public function acLeads($act, $datePreset, $dateType)
    {
        $response = $this->getAcLeads($act, $datePreset, $dateType, 1);
        $total = $response->meta->total ?? 0;

        for ($offset = 0; $offset < $total; $offset = $offset + 100) {
            $leads = $this->getAcLeads($act, $datePreset,$dateType, 100, $offset, 1)->contacts;
            foreach ($leads as $lead) {

                $this->acLeadsUpdateOrCreate($act, $lead);
            }
        }
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $dateType
     * @param int $limit
     * @param int $offset
     * @param int $status
     * @return mixed
     */
    public function getAcLeads($act, $datePreset, $dateType, $limit = 100, $offset = 0, $status = 1)
    {
        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);

        list($updatedAfter, $updatedBefore, $createdAfter, $createdBefore) = (new Helper)->dateType($dateType, $startDate,
            $endDate);

        return (new ActiveCampaign)->getAcLeadsData($act, $limit, $offset, $status,$updatedAfter, $updatedBefore,$createdAfter, $createdBefore);
    }

    /**
     * @param $leads
     * @param $key
     * @param $act
     * @return mixed
     */
    protected function acLeadsUpdateOrCreate($act, $lead)
    {
        return $this->updateOrCreate(
            ['email' => $lead->email, 'account' => $act],
            [
                'first_name' => $lead->firstName,
                'last_name' => $lead->lastName,
                'phone_number' => $lead->phone,
            ]
        );
    }

    /**
     * @param $act
     * @param $datePreset
     */
    public function hotmartLeads($act, $datePreset)
    {
        list($startDate, $endDate) = (new Helper)->datePreset($datePreset);

        $response = (new Hotmart)->getHotmartSalesHistory($act, $startDate, $endDate);

        $total = ($response->size ?? 0) / 1000;

        for ($page = 1; $page < $total + 1; $page = $page + 1) {
            $leads = (new Hotmart)->getHotmartSalesHistory($act, $startDate, $endDate, null, 1000, $page);
            if (isset($leads->data)){
                foreach ($leads->data as $lead) {
                    $this->prepareHotmartLeads($act, $lead );
                }
            }
        }
    }

    /**
     * @param $act
     * @param $lead
     * @return Lead|Model|null
     */
    protected function prepareHotmartLeads($act, $lead)
    {
        $email = ($lead->buyer->email ?? 'notavailable@powerhub.app');
        $account = $act;
        $first_name = Str::of($lead->buyer->name ?? 'Not Available')->before(' ');
        $last_name = Str::of($lead->buyer->name ?? 'Not Available')->after(' ');
        $phone_number = ($lead->buyer->dddPhone ?? null) . ($lead->buyer->phone ?? null);
        $country = $lead->buyer->address->country ?? null;
        $zipcode = $lead->buyer->address->zipCode ?? null;
        $address = $lead->buyer->address->address ?? null;
        $number = $lead->buyer->address->number ?? null;
        $complement = $lead->buyer->address->complement ?? null;
        $neighborhood = $lead->buyer->address->neighborhood ?? null;
        $state = $lead->buyer->address->state ?? null;
        $city = $lead->buyer->address->city ?? null;

        return $this->updateOrCreateHotmartLeads($email, $account, $first_name, $last_name, $phone_number, $country,
            $zipcode, $address, $number, $complement, $neighborhood, $state, $city);
    }

    /**
     * @param $act
     * @param $data
     * @return mixed|null
     */
    public function prepareWebhookHotmartLeads($act, $data)
    {
        $email = $data['payload']['email'] ?? ($data['payload']['buyerVO']['email'] ?? 'notavailable@powerhub.app');
        $account = $act;
        $first_name = $data['payload']['first_name'] ?? Str::of($data['payload']['buyerVO']['name'] ?? 'Not Available')->before(' ');
        $last_name = $data['payload']['last_name'] ?? Str::of($data['payload']['buyerVO']['name'] ?? 'Not Available')->after(' ');
        $phone_number = $data['payload']['buyerVO']['phone'] ?? ($data['payload']['phone_local_code'] ?? null) . ($data['payload']['phone_number'] ?? null);
        $country = $data['payload']['address_country'] ?? null;
        $zipcode = $data['payload']['address_zip_code'] ?? null;
        $address = $data['payload']['address'] ?? null;
        $number = $data['payload']['address_number'] ?? null;
        $complement = $data['payload']['address_comp'] ?? null;
        $neighborhood = $data['payload']['address_district'] ?? null;
        $state = $data['payload']['address_state'] ?? null;
        $city = $data['payload']['address_city'] ?? null;

        return $this->updateOrCreateHotmartLeads($email, $account, $first_name, $last_name, $phone_number, $country,
            $zipcode, $address, $number, $complement, $neighborhood, $state, $city);
    }

    /**
     * @param string $email
     * @param $account
     * @param string $first_name
     * @param string $last_name
     * @param string $phone_number
     * @param $country
     * @param $zipcode
     * @param $address
     * @param $number
     * @param $complement
     * @param $neighborhood
     * @param $state
     * @param $city
     * @return Lead|Model|null
     */
    public function updateOrCreateHotmartLeads(
        string $email,
        $account,
        string $first_name,
        string $last_name,
        string $phone_number,
        $country,
        $zipcode,
        $address,
        $number,
        $complement,
        $neighborhood,
        $state,
        $city
    ) {
        if (!$email){
            return null;
        }

        $dataToUpdate = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'country' => $country,
            'zipcode' => $zipcode,
            'address' => $address,
            'number' => $number,
            'complement' => $complement,
            'neighborhood' => $neighborhood,
            'state' => $state,
            'city' => $city,
        ];

        foreach ($dataToUpdate as $key => $data){
            if (!$data) {
                unset($dataToUpdate[$key]);
            }
        }

        return $this->updateOrCreate(
            [
                'email' => $email,
                'account' => $account,
            ],
            $dataToUpdate
        );
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $dateType
     * @return mixed
     */
    public function addAcInvalidContactTag($act, $datePreset, $dateType)
    {
        $tag = (new ActiveCampaign)->createTag($act, 'PowerHub-Email-Invalid');

        $response = $this->getAcLeads($act, $datePreset, $dateType, 1);
        $total = $response->meta->total ?? 0;

        for ($offset = 0; $offset < $total; $offset = $offset + 100) {
            $leads = $this->getAcLeads($act, $datePreset,$dateType, 100, $offset, 1)->contacts;

            foreach ($leads as $lead) {
                $emailVerifier = (new EmailVerifier)->singleEmailValidator($lead->email);

                if ($emailVerifier === false){

                    (new ActiveCampaign)->addContactTag($act, $lead->id, $tag->id);
                }

            }
        }

        return $tag;
    }
}
