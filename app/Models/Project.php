<?php

namespace App\Models;

use App\Services\Helper;
use App\Traits\AccountTrait;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Webpatser\Uuid\Uuid;


class Project extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string[]
     */
    protected $appends = ['npo_evaluation'];

    /**
     * @var string
     */
    protected $table = 'projects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'uuid',
        'account',
        'name',
        'description',
        'leads_goal',
        'whatsapp_goal',
        'telegram_goal',
        'revenue_goal_min',
        'revenue_goal',
        'revenue_goal_max',
        'start_at',
        'cart_at',
        'end_at',
        'status',
        'niche',
        'sub_niche',
        'type',
        'instagram',
        'facebook',
        'youtube',
        'avatar',
        'transformation',
        'strengths',
        'weaknesses',
        'opportunities',
        'threats',
        'instagram_followers_before',
        'instagram_followers_after',
        'facebook_fans_before',
        'facebook_fans_after',
        'youtube_subscribers_before',
        'youtube_subscribers_after',
        'comments',
        'cp_timeline',
        'cp_opportunities',
        'cp_avatar_pains_dreams',
        'cp_copy',
        'cp_event_name',
        'cp_event_promises',
        'cp_avatar_objections',
        'cp_avatar_traps_myths',
        'cp_design_launch_line',
        'cp_product_qualities',
        'cp_product_efficiency',
        'cp_product_unique',
        'cp_product_steps',
        'cp_product_warranty',
        'cp_offer_unique',
        'cp_common_enemy',
        'cp_who',
        'cp_requirements',
        'cp_niche',
        'cp_product',
        'cp_offer',
        'cp_strategy',
        'cp_aggregates',
        'cp_offers_description',
        'cp_structure',
        'cp_links',
        'cp_definitions',
        'cp_ads_copy',
        'currency',
    ];

    /**
     *
     */
    public static function booted()
    {
        self::creating(function ($model) {
            $model->uuid = Uuid::generate();
        });
    }

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
    public function getLinks(): HasMany
    {
        return $this->hasMany(Link::class, 'project', 'id');
    }

    /**
     * @return HasMany
     */
    public function getProjectsDet(): HasMany
    {
        return $this->hasMany(ProjectDet::class, 'project', 'id');
    }

    /**
     * @return float|int
     */
    public function getNpoEvaluationAttribute()
    {
        return round(($this->cp_niche + $this->cp_product + $this->cp_offer) / 3 * 100) / 100;
    }

    /**
     *
     * @return array
     */
    public function getProjectParameters(): array
    {
        (new Helper)->getAccountInfo();
        $act = session()->get('account')->id;

        $integrationTag = (new Integration)->where('account', $act)->where('provider_name', 'Active Campaign')->first();

        $tags = (new Tag)->where('account', $act)->where('integration',
            $integrationTag->id ?? null)->get()->sortBy('latest');

        $integrationProduct = (new Integration)->where('account', $act)->where('provider_name', 'Hotmart')->first();

        $products = (new Product)->where('account', $act)->where('integration',
            $integrationProduct->id ?? null)->where('status', 'ACTIVE')->get()->sortBy('latest');

        $kpis = Insight::with(['getIntegrationDet'])->where('account', $act)->where('name', '<>', null)->where('name',
            '<>', 'spend')->get()->keyBy('br_name');

        $fbAdAccounts = IntegrationDet::with('getCampaigns')
            ->where('account', $act)
            ->where('key', 'fbAdAccount')
            ->where('status',
                1)->get();

        $fbCampaigns = null;
        foreach ($fbAdAccounts as $key => $singleFbAccount) {
            if ($key === 0) {
                $fbCampaigns = collect($singleFbAccount->getCampaigns);
            }

            $fbCampaigns = isset($fbCampaigns) ? collect($fbCampaigns)->merge($singleFbAccount->getCampaigns): null;
        }

        $fbCampaigns = ($fbCampaigns !== null) ? $fbCampaigns->unique() : null;

        $videos = (new Video)->where('account', $act)->get()->sortBy('latest');

        return array($tags, $products, $kpis, $fbCampaigns, $videos);
    }

    /**
     * @param $project
     * @return array
     */
    public function getOldProjectParameters($project): array
    {
        $editTags = ProjectDet::where('project', $project->id)->where('key_type', 'App\Models\Tag')->get();
        $editProducts = ProjectDet::where('project', $project->id)->where('key_type', 'App\Models\Product')->get();
        $oldFbCampaigns = ProjectDet::where('project', $project->id)->where('key_type', 'App\Models\Campaign')->with('keyable')->get();
        $oldVideos = ProjectDet::where('project', $project->id)->where('key_type', 'App\Models\Video')->get();
        $oldProjectsDet = $oldFbCampaigns->groupBy('kpi_id');
        $videosProjectDet = ProjectDet::where('project', $project->id)->where('key_type', 'App\Models\Video')->get();

        foreach ($editTags as $oldTag) {
            $oldTags[] = $oldTag->key_id;
        }
        $oldTags = $oldTags ?? null;

        foreach ($editProducts as $oldProduct) {
            $oldProducts[] = $oldProduct->key_id;
        }

        $oldProducts = $oldProducts ?? null;

        return array(
            $project,
            $oldFbCampaigns,
            $oldVideos,
            $videosProjectDet,
            $oldTags,
            $oldProducts,
            $oldProjectsDet
        );
    }

    /**
     * @param $request
     * @param null $id
     * @return Project|Model|null
     * @throws Exception
     */
    public function createOrUpdateProject($request, $id = null)
    {
        $dataIndex = [
            'id' => $id,
            'account' => session()->get('account')->id,
        ];

        $dataToUpdate = [
            'name' => $request->projectName,
            'description' => $request->projectDescription,
            'leads_goal' => $request->leadsGoal,
            'whatsapp_goal' => $request->whatsappGoal,
            'telegram_goal' => $request->telegramGoal,
            'revenue_goal_min' => $request->revenueGoalMin,
            'revenue_goal' => $request->revenueGoal,
            'revenue_goal_max' => $request->revenueGoalMax,
            'start_at' => $request->from_date,
            'cart_at' => $request->cart_date,
            'end_at' => $request->to_date,
            'status' => 1,
            'niche' => $request->niche,
            'sub_niche' => $request->subNiche,
            'type' => $request->type,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,
            'avatar' => $request->avatar,
            'transformation' => $request->transformation,
            'strengths' => $request->strengths,
            'weaknesses' => $request->weaknesses,
            'opportunities' => $request->opportunities,
            'threats' => $request->threats,
            'instagram_followers_before' => $request->instagram_followers_before,
            'instagram_followers_after' => $request->instagram_followers_after,
            'facebook_fans_before' => $request->facebook_fans_before,
            'facebook_fans_after' => $request->facebook_fans_after,
            'youtube_subscribers_before' => $request->youtube_subscribers_before,
            'youtube_subscribers_after' => $request->youtube_subscribers_after,
            'cp_timeline' => $request->projectTimeline,
            'cp_opportunities' => $request->projectOpportunities,
            'cp_avatar_pains_dreams' => $request->projectAvatarInfo,
            'cp_copy' => $request->projectCopy,
            'cp_event_name' => $request->projectEventName,
            'cp_event_promises' => $request->projectPromises,
            'cp_avatar_objections' => $request->avatarObjections,
            'cp_avatar_traps_myths' => $request->avatarTrapsMyths,
            'cp_design_launch_line' => $request->projectDesign,
            'cp_product_qualities' => $request->productQualities,
            'cp_product_efficiency' => $request->productEfficiency,
            'cp_product_unique' => $request->productUnique,
            'cp_product_steps' => $request->productSteps,
            'cp_product_warranty' => $request->productWarranty,
            'cp_offer_unique' => $request->offer_Unique,
            'cp_common_enemy' => $request->commonEnemy,
            'cp_who' => $request->productWho,
            'cp_requirements' => $request->productRequirements,
            'cp_niche' => $request->nicheEvaluation,
            'cp_product' => $request->productEvaluation,
            'cp_offer' => $request->offerEvaluation,
            'cp_strategy' => $request->projectStrategy,
            'cp_aggregates' => $request->productAggregates,
            'cp_offers_description' => $request->offersDescription,
            'cp_structure' => $request->projectStructure,
            'cp_links' => $request->projectLinks,
            'cp_definitions' => $request->projectDefinitions,
            'cp_ads_copy' => $request->projectAdsCopy,
            'comments' => $request->comments,
        ];

        if ($id === null) {
            unset($dataIndex['id']);
            unset($dataToUpdate['name']);
            $dataIndex['name'] = $request->projectName;
        }

        foreach ($dataToUpdate as $key => $data){
            if (!$data) {
                unset($dataToUpdate[$key]);
            }
        }

        $project = $this->updateOrCreate(
            $dataIndex,
            $dataToUpdate
        );

        (new Helper)->projectMessageFlash($project);
        (new ProjectDet)->createOrUpdateProjectDet($project, $request, $id);

        return $project ?? null;
    }

    /**
     * @param Project $project
     * @return array
     */
    public function projectViewData(Project $project): array
    {
        list($tags, $products, $kpis, $fbCampaigns, $videos) = (new Project)->getProjectParameters();
        list($project, $oldFbCampaigns, $oldVideos, $videosProjectDet, $oldTags, $oldProducts, $oldProjectsDet) = (new Project)->getOldProjectParameters($project);

        return [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
            'project' => ($project ?? null),
            'tags' => ($tags ?? null),
            'products' => ($products ?? null),
            'fbCampaigns' => ($fbCampaigns ?? null),
            'videos' => ($videos ?? null),
            'kpis' => ($kpis ?? null),
            'oldTags' => ($oldTags ?? null),
            'oldProducts' => ($oldProducts ?? null),
            'oldFbCampaigns' => ($oldFbCampaigns ?? null),
            'oldVideos' => ($oldVideos ?? null),
            'videosProjectDet' => ($videosProjectDet ?? null),
            'oldProjectsDet' => ($oldProjectsDet ?? null),
        ];
    }
}
