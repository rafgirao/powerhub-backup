<?php

namespace App\Models;

use App\Http\Requests\IntegrationRequest;
use App\Services\Helper;
use App\Traits\AccountTrait;
use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;
use stdClass;


class Integration extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'integrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'account',
        'provider_name',
        'provider_type',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return HasMany
     */
    public function getIntegrationsDet(): HasMany
    {
        return $this->hasMany(IntegrationDet::class, 'integration', 'id');
    }

    /**
     * @param $act
     * @return stdClass
     */
    public function acCredentials($act): ?stdClass
    {
        $acIntegration = self::where('account', $act)->where('provider_name', 'Active Campaign')->first() !== null
            ? self::where('account', $act)->where('provider_name', 'Active Campaign')->first()
            : null;

        $acCredentials = new stdClass();
        $acCredentials->acUrl = ($acIntegration !== null
            ? ($acIntegration->getIntegrationsDet()->where('account', $act)->where('key',
                'acUrl')->first() !== null
                ? Crypt::decryptString($acIntegration->getIntegrationsDet()->where('account',
                    $act)->where('key', 'acUrl')->first()->value)
                : null)
            : null);
        $acCredentials->acToken = ($acIntegration !== null
            ? ($acIntegration->getIntegrationsDet()->where('account', $act)->where('key',
                'acToken')->first() !== null
                ? Crypt::decryptString($acIntegration->getIntegrationsDet()->where('account',
                    $act)->where('key', 'acToken')->first()->value)
                : null)
            : null);
        return $acCredentials;
    }

    /**
     * @param $act
     * @return stdClass
     */
    public function hotmartCredentials($act): ?stdClass
    {
        $hotmartIntegration = (self::where('account', $act)->where('provider_name', 'Hotmart')->first() !== null
            ? self::where('account', $act)->where('provider_name', 'Hotmart')->first()
            : null);

        $hotmartCredentials = new stdClass();

        $hotmartCredentials->clientId = ($hotmartIntegration !== null
            ? ($hotmartIntegration->getIntegrationsDet()->where('account', $act)->where('key',
                'clientId')->first() !== null
                ? Crypt::decryptString($hotmartIntegration->getIntegrationsDet()->where('account',
                    $act)->where('key', 'clientId')->first()->value)
                : null)
            : null);

        $hotmartCredentials->clientSecret = ($hotmartIntegration !== null
            ? ($hotmartIntegration->getIntegrationsDet()->where('account', $act)->where('key',
                'clientSecret')->first() !== null
                ? Crypt::decryptString($hotmartIntegration->getIntegrationsDet()->where('account',
                    $act)->where('key', 'clientSecret')->first()->value)
                : null)
            : null);

        $hotmartCredentials->basic = ($hotmartIntegration !== null
            ? ($hotmartIntegration->getIntegrationsDet()->where('account', $act)->where('key',
                'basic')->first() !== null
                ? Crypt::decryptString($hotmartIntegration->getIntegrationsDet()->where('account',
                    $act)->where('key', 'basic')->first()->value)
                : null)
            : null);

        return $hotmartCredentials;
    }

    /**
     * @param $act
     * @return stdClass
     */
    public function fbCredentials($act): ?stdClass
    {
        $fbIntegration = self::where('account', $act)
                ->where('provider_name', 'Facebook')
                ->where('status', '<>', 0)
                ->first();

        if ($fbIntegration === null) {
            return null;
        }

        $fbCredentials = new stdClass();

        $fbIntegrationDet = IntegrationDet::whereIntegration($fbIntegration->id)
                ->where('key', 'fbToken')
                ->where('status', '<>', 0)
                ->first() ?? null;

        if ($fbIntegrationDet === null) {
            return null;
        }

        if ($fbIntegrationDet->expires_in < Carbon::now()){
            $fbIntegration->status = 0;
            $fbIntegration->save();
            $fbIntegrationDet->status = 0;
            $fbIntegrationDet->save();
            return null;
        }

        $fbCredentials->fbToken = Crypt::decryptString($fbIntegrationDet->value);
        $fbCredentials->expiresIn = $fbIntegrationDet->expires_in;

        $fbAdAccounts = IntegrationDet::whereIntegration($fbIntegration->id)
                ->where('key', 'fbAdAccount')
                ->where('status', '<>', 0)
                ->get() ?? null;

        if ($fbAdAccounts !== null) {
            foreach ($fbAdAccounts as $index => $fbAdAccount) {

                $fbCredentials->fbAdAccounts[] = new stdClass();
                $fbCredentials->fbAdAccounts[$index]->key = $fbAdAccount['key'];
                $fbCredentials->fbAdAccounts[$index]->value = $fbAdAccount['value'];
                $fbCredentials->fbAdAccounts[$index]->description = $fbAdAccount['description'];
                $fbCredentials->fbAdAccounts[$index]->status = $fbAdAccount['status'];
            }
        }

        return $fbCredentials;
    }

    /**
     * @param Int $act
     * @return Model|HasMany|object|null
     */
    public function googleCredentials(Int $act)
    {
        $googleCredentials = self::where('account', $act)
                ->where('provider_name', 'Google')
                ->where('status', '<>', 0)
                ->first();

        if (!isset($googleCredentials)) {
            return null;
        }

        return $googleCredentials->getIntegrationsDet()
                ->where('account', $act)
                ->where('key','googleRefreshToken')
                ->where('status', '<>', 0)
                ->first() ?? null;
    }

    /**
     * @param $act
     * @param $validated
     * @return Integration|Model
     */
    public function createOrUpdateIntegration($act, $validated)
    {
        $providerName = [
            'Active Campaign',
            'Hotmart',
            'Eduzz',
            'Provi',
            'Facebook',
            'Google'
        ];

        if (in_array($validated['providerName'], $providerName)) {

            $integration = Integration::updateOrCreate(
                [
                    'account' => $act,
                    'provider_name' => $validated['providerName'],
                    'description' => $validated['description'],
                ],
                [
                    'provider_type' => $validated['providerType'],
                    'status' => 1,
                ]
            );
        } else {
            $integration = Integration::updateOrCreate(
                [
                    'account' => $act,
                    'provider_name' => $validated['providerName'],
                    'provider_type' => $validated['providerType'],
                    'description' => $validated['description'],
                    'status' => 1,
                ]
            );
        }

        if ($validated['providerName'] === 'Facebook') {
            $integrationDet = IntegrationDet::updateOrCreate(
                [
                    'account' => $act,
                    'integration' => $integration->id,
                    'key' => 'fbToken',
                ],
                [
                    'value' => Crypt::encryptString($validated['fbToken']),
                    'status' => 1,
                    'expires_in' => Carbon::now()->addSeconds($validated['expiresIn']),
                ]
            );

            (new Helper)->integrationMessageFlash($integrationDet, $integration);

            foreach ($validated['adAccounts'] as $key => $value) {
                if ($key !== '_token' and $key !== 'providerName' and $key !== 'providerType' and $key !== 'description' and $value !== null) {

                    $integrationDet = IntegrationDet::updateOrCreate(
                        [
                            'account' => $act,
                            'integration' => $integration->id,
                            'key' => 'fbAdAccount',
                            'value' => $value['fbAdAccountId'],
                            'timezone' => $value['fbAdAccountTimezone'],
                            'currency' => $value['fbAdAccountCurrency'],
                        ],
                        [
                            'description' => $value['description'],
                            'status' => (isset($value['checkbox']) and $value['checkbox'] === 'on' ? 1 : 0),
                        ]
                    );

                    if ($integrationDet->status === false) {
                        Campaign::where('integration_det', $integrationDet->id)->delete();
                        Insight::where('integration_det', $integrationDet->id)->delete();
                    }

                    (new Helper)->integrationMessageFlash($integrationDet, $integration);
                }
            }
        } elseif ($validated['providerName'] === 'Google') {
            $integrationDet = IntegrationDet::updateOrCreate(
                [
                    'account' => $act,
                    'integration' => $integration->id,
                    'key' => 'googleRefreshToken',
                ],
                [
                    'value' => Crypt::encryptString($validated['googleRefreshToken']),
                    'description' => session()->get('scope') ?? null,
                    'status' => 1,
//                        'expires_in' => Carbon::now()->addSeconds($request->expiresIn),
                ]
            );

//            (new Helper)->integrationMessageFlash($integrationDet, $integration);
        } else {
            foreach ($validated as $key => $value) {
                if ($key !== '_token' and $key !== 'providerName' and $key !== 'providerType' and $key !== 'description' and $value !== null) {
                    $integrationDet = IntegrationDet::updateOrCreate(
                        [
                            'account' => $act,
                            'integration' => $integration->id,
                            'key' => $key,
                        ],
                        [
                            'value' => Crypt::encryptString($value),
                            'status' => 1,
                        ]
                    );

                    (new Helper)->integrationMessageFlash($integrationDet, $integration);
                }
            }
        }

        return $integration;
    }
}
