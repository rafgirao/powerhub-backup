<?php

namespace App\Models;

use App\Services\Helper;
use App\Traits\AccountTrait;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class ProjectDet extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'projects_det';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'account',
        'project',
        'key_type',
        'key_id',
        'kpi_type',
        'kpi_id',
        'target',
        'expected_value',
        'realized_value',
    ];

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return MorphTo
     */
    public function keyable(): MorphTo
    {
        return $this->morphTo('key');
    }

    /**
     * @return MorphTo
     */
    public function kpiable(): MorphTo
    {
        return $this->morphTo('kpi');
    }

    /**
     * @return mixed
     */
    public function video()
    {
        return Video::where('id', $this->key_id)->first();
    }

    /**
     *
     */
    public function getProjects()
    {
        return $this->belongsTo(Project::class, 'project', 'id');
    }

    /**
     * @param $value
     */
    public function setKpiAttribute($value)
    {
        if ($value === 'Alcance (Evento Padrão)') {
            $this->attributes['kpi'] = 'REACH';
        } elseif ($value === 'Impressões (Evento Padrão)') {
            $this->attributes['kpi'] = 'IMPRESSIONS';
        } elseif ($value === 'Clique (Evento Padrão)') {
            $this->attributes['kpi'] = 'CLICKS';
        } elseif ($value === 'Compra (Evento Padrão)') {
            $this->attributes['kpi'] = 'PURCHASE';
        } elseif ($value === 'Viu Página (Evento Padrão)') {
            $this->attributes['kpi'] = 'PAGE_VIEW';
        } elseif ($value === 'Comentário (Evento Padrão)') {
            $this->attributes['kpi'] = 'COMMENT';
        } elseif ($value === 'Salvamento (Evento Padrão)') {
            $this->attributes['kpi'] = 'POST_SAVE';
        } elseif ($value === 'Reação (Evento Padrão)') {
            $this->attributes['kpi'] = 'POST_REACTION';
        } elseif ($value === 'Engajamento (Evento Padrão)') {
            $this->attributes['kpi'] = 'POST_ENGAGEMENT';
        } elseif ($value === 'Post (Evento Padrão)') {
            $this->attributes['kpi'] = 'POST';
        } elseif ($value === 'Engajamento na Página (Evento Padrão)') {
            $this->attributes['kpi'] = 'PAGE_ENGAGEMENT';
        } elseif ($value === 'Clique no link (Evento Padrão)') {
            $this->attributes['kpi'] = 'LINK_CLICK';
        } elseif ($value === 'Checkout Iniciado (Evento Padrão)') {
            $this->attributes['kpi'] = 'INITIATED_CHECKOUT';
        } elseif ($value === 'Lead (Evento Padrão)') {
            $this->attributes['kpi'] = 'LEAD';
        } elseif ($value === 'Viu Conteúdo (Evento Padrão)') {
            $this->attributes['kpi'] = 'CONTENT_VIEW';
        } elseif ($value === 'Viu Vídeo (Evento Padrão)') {
            $this->attributes['kpi'] = 'VIDEO_VIEW';
        } elseif ($value === 'Cadastro Completo (Evento Padrão)') {
            $this->attributes['kpi'] = 'COMPLETE_REGISTRATION';
        } elseif ($value === 'Curtida (Evento Padrão)') {
            $this->attributes['kpi'] = 'LIKE';
        } elseif ($value === 'Lista de Desejos (Evento Padrão)') {
            $this->attributes['kpi'] = 'ADD_TO_WISHLIST';
        } elseif ($value === 'Viu Foto (Evento Padrão)') {
            $this->attributes['kpi'] = 'PHOTO_VIEW';
        } elseif ($value === 'Adicionar ao Carrinho') {
            $this->attributes['kpi'] = 'ADD_TO_CART';
        } else {
            $this->attributes['kpi'] = $value;
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function getKpiAttribute($value): string
    {
        if ($value === 'REACH') {
            return 'Alcance (Evento Padrão)';
        } elseif ($value === 'IMPRESSIONS') {
            return 'Impressões (Evento Padrão)';
        } elseif ($value === 'CLICKS') {
            return 'Clique (Evento Padrão)';
        } elseif ($value === 'PURCHASE') {
            return 'Compra (Evento Padrão)';
        } elseif ($value === 'PAGE_VIEW') {
            return 'Viu Página (Evento Padrão)';
        } elseif ($value === 'COMMENT') {
            return 'Comentário (Evento Padrão)';
        } elseif ($value === 'POST_SAVE') {
            return 'Salvamento (Evento Padrão)';
        } elseif ($value === 'POST_REACTION') {
            return 'Reação (Evento Padrão)';
        } elseif ($value === 'POST_ENGAGEMENT') {
            return 'Engajamento (Evento Padrão)';
        } elseif ($value === 'POST') {
            return 'Post (Evento Padrão)';
        } elseif ($value === 'PAGE_ENGAGEMENT') {
            return 'Engajamento na Página (Evento Padrão)';
        } elseif ($value === 'LINK_CLICK') {
            return 'Clique no link (Evento Padrão)';
        } elseif ($value === 'INITIATED_CHECKOUT') {
            return 'Checkout Iniciado (Evento Padrão)';
        } elseif ($value === 'LEAD') {
            return 'Lead (Evento Padrão)';
        } elseif ($value === 'CONTENT_VIEW') {
            return 'Viu Conteúdo (Evento Padrão)';
        } elseif ($value === 'VIDEO_VIEW') {
            return 'Viu Vídeo (Evento Padrão)';
        } elseif ($value === 'COMPLETE_REGISTRATION') {
            return 'Cadastro Completo (Evento Padrão)';
        } elseif ($value === 'LIKE') {
            return 'Curtida (Evento Padrão)';
        } elseif ($value === 'ADD_TO_WISHLIST') {
            return 'Lista de Desejos (Evento Padrão)';
        } elseif ($value === 'PHOTO_VIEW') {
            return 'Viu Foto (Evento Padrão)';
        } elseif ($value === 'ADD_TO_CART') {
            return 'Adicionar ao Carrinho';
        } else {
            return $value;
        }
    }

    /**
     * @param $project
     * @param $request
     * @param null $id
     * @return bool|Model|mixed|null
     * @throws Exception
     */
    public function createOrUpdateProjectDet($project, $request, $id = null)
    {
        if (in_array('acTags', $request->fieldsUpdate)) {

            ProjectDet::where('project', $project->id)->where('key_type', 'App\Tag')->delete();

            if (isset($request->acTags)) {

                foreach ($request->acTags as $id) {

                    $tag = Tag::find($id);
                    $projectDet = $tag->getProjectDetByKey()->create(
                        [
                            'account' => session()->get('account')->id,
                            'project' => $project->id,
                            'kpi' => null,
                        ]
                    );
                }
                (new Helper)->projectMessageFlash($project, $projectDet);
            }
        }

        if (in_array('hotmartProducts', $request->fieldsUpdate)) {

            ProjectDet::where('project', $project->id)->where('key_type', 'App\Models\Product')->delete();

            if (isset($request->hotmartProducts)) {

                foreach ($request->hotmartProducts as $id) {

                    $product = Product::find($id);
                    $projectDet = $product->getProjectDetByKey()->create(
                        [
                            'account' => session()->get('account')->id,
                            'project' => $project->id,
                            'kpi' => null,
                        ]
                    );
                }
                (new Helper)->projectMessageFlash($project, $projectDet);
            }
        }

        if (in_array('fbCampaigns', $request->fieldsUpdate)) {

            ProjectDet::where('project', $project->id)->where('key_type', 'App\Campaign')->delete();

            if (isset($request->fbCampaigns)) {

                foreach ($request->fbCampaigns as $fbCampaign) {

                    if ($fbCampaign['id']) {

                        $fbInsight = Insight::find($fbCampaign['kpi']);

                        foreach ($fbCampaign['id'] as $id) {
                            $fbCampaignDet = Campaign::find($id);

                            $projectDet = $fbCampaignDet->getProjectDetByKey()->create(
                                [
                                    'account' => session()->get('account')->id,
                                    'project' => $project->id,
                                    'kpi_type' => 'App\Insight',
                                    'kpi_id' => $fbCampaign['kpi'] ?? null,
                                    'target' => $fbCampaign['target'] ?? null
                                ]
                            );
                        }
                    }
                }
                (new Helper)->projectMessageFlash($project, $projectDet);
            }
        }

        if (in_array('videos', $request->fieldsUpdate)) {

            ProjectDet::where('project', $project->id)->where('key_type', 'App\Video')->delete();

            if (isset($request->videos)) {

                foreach ($request->videos as $video) {

                    $videoDet = Video::updateOrCreate(
                        [
                            'account' => session()->get('account')->id,
                            'url' => $video['url'] ?? null,
                        ],
                        [
                            'description' => $video['description'],
                            'views' => $video['views'] ?? null
                        ]
                    );

                    $projectDet = $videoDet->getProjectDetByKey()->create(
                        [
                            'account' => session()->get('account')->id,
                            'project' => $project->id,
                            'target' => $video['target'] ?? null
                        ]
                    );
                }
                (new Helper)->projectMessageFlash($project, $projectDet);
            }
        }

        if (in_array('sheet', $request->fieldsUpdate)) {

            ProjectDet::where('project', $project->id)->where('key_type', 'App\Sheet')->delete();

            if (isset($request->sheet)) {

                $projectDet = $request->sheet->getProjectDetByKey()->create(
                    [
                        'account' => session()->get('account')->id,
                        'project' => $project->id,
                        'kpi' => null,
                    ]
                );
//                (new Helper)->projectMessageFlash($project, $projectDet);
            }
        }

        return $projectDet ?? null;
    }
}
