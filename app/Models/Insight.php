<?php

namespace App\Models;

use App\Services\Facebook;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Insight extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string[]
     */
    protected $appends = ['br_name'];

    /**
     * @var string
     */
    protected $table = 'insights';

    /**
     * @var string[]
     */
    protected $fillable = [
        'account',
        'integration_det',
        'provider_insight',
        'type',
        'name',
    ];

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function getIntegrationDet(): BelongsTo
    {
        return $this->belongsTo(IntegrationDet::class, 'integration_det', 'id');
    }

    /**
     * @return HasMany
     */
    public function getCampaignsInsight(): HasMany
    {
        return $this->hasMany(CampaignInsight::class, 'insight', 'id');
    }

    /**
     * @return MorphMany
     */
    public function getProjectDetByKpi(): MorphMany
    {
        return $this->morphMany(ProjectDet::class, 'kpi');
    }

    /**
     * @param $act
     */
    public function listFbAdAccounts($act)
    {
        $fbCredentials = (new Integration)->fbCredentials($act);

        if (!empty($fbCredentials->fbAdAccounts)) {
            foreach ($fbCredentials->fbAdAccounts as $fbCredential) {
                if ($fbCredential->status == 1) {
                    (new Insight)->fbInsights($act, $fbCredential->value, $fbCredentials->fbToken);
                }
            }
        }
    }

    /**
     * @param $act
     * @param $fbAdAccount
     * @param $fbToken
     */
    public function fbInsights($act, $fbAdAccount, $fbToken)
    {
        $integrationDet = IntegrationDet::where('account', $act)->where('value', $fbAdAccount)->first()->id;
        $total = 25;
        $after = null;

        while ($total >= 25) {
            $insights = self::getFbInsights($fbAdAccount, $fbToken, null, $after);
            $total = isset($insights->data) ? count($insights->data) : 0;

            $after = (isset($insights->paging) ?
                (isset($insights->paging->cursors) ?
                    ($insights->paging->cursors->after ?? null) :
                    null)
                : null);

            if (isset($insights->data)) {
                foreach ($insights->data as $insight) {
                    self::fbInsightsUpdateOrCreate($act, $integrationDet, $insight);
                }
            }
        }
    }

    /**
     * @param $fbAdAccount
     * @param $fbToken
     * @param $before
     * @param $after
     * @return mixed|null
     */
    public function getFbInsights($fbAdAccount, $fbToken, $before, $after)
    {
        $fields = 'id,name,custom_event_type,account_id';
        return (new Facebook)->getFbInsights($fbAdAccount, $fbToken, $fields, $before, $after);
    }

    /**
     * @param $act
     * @param $integrationDet
     * @param $insight
     * @return Insight|Model
     */
    public function fbInsightsUpdateOrCreate($act, $integrationDet, $insight)
    {
        return self::UpdateOrCreate(
            [
                'account' => $act,
                'integration_det' => $integrationDet,
                'provider_insight' => (isset($insight->id) ? 'offsite_conversion.custom.' . $insight->id : $insight),
            ],
            [
                'type' => $insight->custom_event_type ?? self::setInsightField($insight),
                'name' => $insight->name ?? (isset($insight->id) ? 'offsite_conversion.custom.' . $insight->id : $insight),
            ]
        );
    }

    /**
     * @param $value
     * @return string|null
     */
    public function setInsightField($value): ?string
    {
        if (str_contains($value, 'reach')) {
            return 'REACH';
        } elseif (str_contains($value, 'impressions')) {
            return 'IMPRESSIONS';
        } elseif (str_contains($value, 'clicks')) {
            return 'CLICKS';
        } elseif (str_contains($value, 'spend')) {
            return 'SPEND';
        } elseif (str_contains($value, 'purchase')) {
            return 'PURCHASE';
        } elseif (str_contains($value, 'page_view')) {
            return 'PAGE_VIEW';
        } elseif (str_contains($value, 'comment')) {
            return 'COMMENT';
        } elseif (str_contains($value, 'post_save')) {
            return 'POST_SAVE';
        } elseif (str_contains($value, 'post_reaction')) {
            return 'POST_REACTION';
        } elseif (str_contains($value, 'post_engagement')) {
            return 'POST_ENGAGEMENT';
        } elseif ($value === 'post') {
            return 'POST';
        } elseif (str_contains($value, 'page_engagement')) {
            return 'PAGE_ENGAGEMENT';
        } elseif (str_contains($value, 'link_click')) {
            return 'LINK_CLICK';
        } elseif (str_contains($value, 'checkout')) {
            return 'INITIATED_CHECKOUT';
        } elseif (str_contains($value, 'lead')) {
            return 'LEAD';
        } elseif (str_contains($value, 'view_content')) {
            return 'CONTENT_VIEW';
        } elseif (str_contains($value, 'video_view')) {
            return 'VIDEO_VIEW';
        } elseif (str_contains($value, 'complete_registration')) {
            return 'COMPLETE_REGISTRATION';
        } elseif (str_contains($value, 'like')) {
            return 'LIKE';
        } elseif (str_contains($value, 'add_to_wishlist')) {
            return 'ADD_TO_WISHLIST';
        } elseif (str_contains($value, 'photo_view')) {
            return 'PHOTO_VIEW';
        } elseif (str_contains($value, 'add_to_cart')) {
            return 'ADD_TO_CART';
        } elseif (str_contains($value, 'add_payment_info')) {
            return 'ADD_PAYMENT_INFO';
        } elseif (str_contains($value, 'fb_pixel_custom')) {
            return 'PIXEL_CUSTOM';
        } else {
            return null;
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function getTypeAttribute(): string
    {
        if (str_contains($this->name, 'REACH')) {
            return 'Alcance (Evento Padrão)';
        } elseif (str_contains($this->name, 'IMPRESSIONS')) {
            return 'Impressões (Evento Padrão)';
        } elseif (str_contains($this->name, 'CLICKS')) {
            return 'Clique (Evento Padrão)';
        } elseif (str_contains($this->name, 'PURCHASE')) {
            return 'Compra (Evento Padrão)';
        } elseif (str_contains($this->name, 'PAGE_VIEW')) {
            return 'Viu Página (Evento Padrão)';
        } elseif (str_contains($this->name, 'COMMENT')) {
            return 'Comentário (Evento Padrão)';
        } elseif (str_contains($this->name, 'POST_SAVE')) {
            return 'Salvamento (Evento Padrão)';
        } elseif (str_contains($this->name, 'POST_REACTION')) {
            return 'Reação (Evento Padrão)';
        } elseif (str_contains($this->name, 'POST_ENGAGEMENT')) {
            return 'Engajamento (Evento Padrão)';
        } elseif ($this->name === 'POST') {
            return 'Post';
        } elseif (str_contains($this->name, 'PAGE_ENGAGEMENT')) {
            return 'Engajamento na Página (Evento Padrão)';
        } elseif (str_contains($this->name, 'LINK_CLICK')) {
            return 'Clique no link (Evento Padrão)';
        } elseif (str_contains($this->name, 'INITIATED_CHECKOUT')) {
            return 'Checkout Iniciado (Evento Padrão)';
        } elseif (str_contains($this->name, 'LEAD')) {
            return 'Lead (Evento Padrão)';
        } elseif (str_contains($this->name, 'CONTENT_VIEW')) {
            return 'Viu Conteúdo (Evento Padrão)';
        } elseif (str_contains($this->name, 'VIDEO_VIEW')) {
            return 'Viu Vídeo (Evento Padrão)';
        } elseif (str_contains($this->name, 'COMPLETE_REGISTRATION')) {
            return 'Cadastro Completo (Evento Padrão)';
        } elseif (str_contains($this->name, 'LIKE')) {
            return 'Curtida (Evento Padrão)';
        } elseif (str_contains($this->name, 'ADD_TO_WISHLIST')) {
            return 'Lista de Desejos (Evento Padrão)';
        } elseif (str_contains($this->name, 'PHOTO_VIEW')) {
            return 'Viu Foto (Evento Padrão)';
        } elseif (str_contains($this->name, 'ADD_TO_CART')) {
            return 'Adicionar ao Carrinho';
        } else {
            return $this->name;
        }
    }

    /**
     * @return string|null
     */
    public function getBrNameAttribute(): string
    {;
        if (str_contains($this->name, 'reach')) {
            return 'Alcance (Evento Padrão)';
        } elseif (str_contains($this->name, 'impressions')) {
            return 'Impressões (Evento Padrão)';
        } elseif (str_contains($this->name, 'clicks')) {
            return 'Clique (Evento Padrão)';
        } elseif (str_contains($this->name, 'purchase')) {
            return 'Compra (Evento Padrão)';
        } elseif (str_contains($this->name, 'page_view')) {
            return 'Viu Página (Evento Padrão)';
        } elseif (str_contains($this->name, 'comment')) {
            return 'Comentário (Evento Padrão)';
        } elseif (str_contains($this->name, 'post_save')) {
            return 'Salvamento (Evento Padrão)';
        } elseif (str_contains($this->name, 'post_reaction')) {
            return 'Reação (Evento Padrão)';
        } elseif (str_contains($this->name, 'post_engagement')) {
            return 'Engajamento (Evento Padrão)';
        } elseif ($this->name === 'post') {
            return 'Post';
        } elseif (str_contains($this->name, 'page_engagement')) {
            return 'Engajamento na Página (Evento Padrão)';
        } elseif (str_contains($this->name, 'link_click')) {
            return 'Clique no link (Evento Padrão)';
        } elseif (str_contains($this->name, 'checkout')) {
            return 'Checkout Iniciado (Evento Padrão)';
        } elseif (str_contains($this->name, 'lead')) {
            return 'Lead (Evento Padrão)';
        } elseif (str_contains($this->name, 'content_view')) {
            return 'Viu Conteúdo (Evento Padrão)';
        } elseif (str_contains($this->name, 'video_view')) {
            return 'Viu Vídeo (Evento Padrão)';
        } elseif (str_contains($this->name, 'complete_registration')) {
            return 'Cadastro Completo (Evento Padrão)';
        } elseif (str_contains($this->name, 'like')) {
            return 'Curtida (Evento Padrão)';
        } elseif (str_contains($this->name, 'add_to_wishlist')) {
            return 'Lista de Desejos (Evento Padrão)';
        } elseif (str_contains($this->name, 'PHOTO_VIEW')) {
            return 'Viu Foto (Evento Padrão)';
        } elseif (str_contains($this->name, 'add_to_cart')) {
            return 'Adicionar ao Carrinho';
        } else {
            return $this->name;
        }
    }
}
