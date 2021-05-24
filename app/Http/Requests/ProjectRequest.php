<?php

namespace App\Http\Requests;

use App\Rules\FacebookUrlCheckRule;
use App\Rules\YoutubeUrlCheckRule;
use Illuminate\Foundation\Http\FormRequest;


class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'projectName' =>  filter_var($this->projectName, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectDescription' =>  filter_var($this->projectDescription, FILTER_SANITIZE_SPECIAL_CHARS),
            'leadsGoal' =>  filter_var($this->whatsappGoal, FILTER_SANITIZE_SPECIAL_CHARS),
            'whatsappGoal' =>  filter_var($this->whatsappGoal, FILTER_SANITIZE_SPECIAL_CHARS),
            'telegramGoal' =>  filter_var($this->telegramGoal, FILTER_SANITIZE_SPECIAL_CHARS),
            'revenueGoalMin' =>  filter_var($this->revenueGoalMin, FILTER_SANITIZE_SPECIAL_CHARS),
            'revenueGoal' =>  filter_var($this->revenueGoal, FILTER_SANITIZE_SPECIAL_CHARS),
            'revenueGoalMax' =>  filter_var($this->revenueGoalMax, FILTER_SANITIZE_SPECIAL_CHARS),
            'from_date' =>  filter_var($this->from_date, FILTER_SANITIZE_SPECIAL_CHARS),
            'cart_date' =>  filter_var($this->cart_date, FILTER_SANITIZE_SPECIAL_CHARS),
            'to_date' =>  filter_var($this->to_date, FILTER_SANITIZE_SPECIAL_CHARS),
            'niche' =>  filter_var($this->niche, FILTER_SANITIZE_SPECIAL_CHARS),
            'sub_niche' =>  filter_var($this->sub_niche, FILTER_SANITIZE_SPECIAL_CHARS),
            'type' =>  filter_var($this->type, FILTER_SANITIZE_SPECIAL_CHARS),
            'instagram' =>  filter_var(isset($this->instagram) ? (str_starts_with($this->instagram, '@') ? $this->instagram : "@{$this->instagram}") : null, FILTER_SANITIZE_SPECIAL_CHARS),
            'facebook' =>  filter_var($this->facebook, FILTER_SANITIZE_SPECIAL_CHARS),
            'youtube' =>  filter_var($this->youtube, FILTER_SANITIZE_SPECIAL_CHARS),
            'avatar' =>  filter_var($this->avatar, FILTER_SANITIZE_SPECIAL_CHARS),
            'transformation' =>  filter_var($this->transformation, FILTER_SANITIZE_SPECIAL_CHARS),
            'strengths' =>  filter_var($this->strengths, FILTER_SANITIZE_SPECIAL_CHARS),
            'weaknesses' =>  filter_var($this->weaknesses, FILTER_SANITIZE_SPECIAL_CHARS),
            'opportunities' =>  filter_var($this->opportunities, FILTER_SANITIZE_SPECIAL_CHARS),
            'threats' =>  filter_var($this->threats, FILTER_SANITIZE_SPECIAL_CHARS),
            'instagram_followers_before' =>  filter_var($this->instagram_followers_before, FILTER_SANITIZE_SPECIAL_CHARS),
            'instagram_followers_after' =>  filter_var($this->instagram_followers_after, FILTER_SANITIZE_SPECIAL_CHARS),
            'facebook_fans_before' =>  filter_var($this->facebook_fans_before, FILTER_SANITIZE_SPECIAL_CHARS),
            'facebook_fans_after' =>  filter_var($this->facebook_fans_after, FILTER_SANITIZE_SPECIAL_CHARS),
            'youtube_subscribers_before' =>  filter_var($this->youtube_subscribers_before, FILTER_SANITIZE_SPECIAL_CHARS),
            'youtube_subscribers_after' =>  filter_var($this->youtube_subscribers_after, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectTimeline' => filter_var($this->projectTimeline, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectOpportunities' => filter_var($this->projectOpportunities, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectAvatarInfo' => filter_var($this->projectAvatarInfo, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectCopy' => filter_var($this->projectCopy, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectEventName' => filter_var($this->projectEventName, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectPromises' => filter_var($this->projectPromises, FILTER_SANITIZE_SPECIAL_CHARS),
            'avatarObjections' => filter_var($this->avatarObjections, FILTER_SANITIZE_SPECIAL_CHARS),
            'avatarTrapsMyths' => filter_var($this->avatarTrapsMyths, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectDesign' => filter_var($this->projectDesign, FILTER_SANITIZE_SPECIAL_CHARS),
            'productQualities' => filter_var($this->productQualities, FILTER_SANITIZE_SPECIAL_CHARS),
            'productEfficiency' => filter_var($this->productEfficiency, FILTER_SANITIZE_SPECIAL_CHARS),
            'productUnique' => filter_var($this->productUnique, FILTER_SANITIZE_SPECIAL_CHARS),
            'productSteps' => filter_var($this->productSteps, FILTER_SANITIZE_SPECIAL_CHARS),
            'productWarranty' => filter_var($this->productWarranty, FILTER_SANITIZE_SPECIAL_CHARS),
            'offer_Unique' => filter_var($this->offer_Unique, FILTER_SANITIZE_SPECIAL_CHARS),
            'commonEnemy' => filter_var($this->commonEnemy, FILTER_SANITIZE_SPECIAL_CHARS),
            'productWho' => filter_var($this->productWho, FILTER_SANITIZE_SPECIAL_CHARS),
            'productRequirements' => filter_var($this->productRequirements, FILTER_SANITIZE_SPECIAL_CHARS),
            'nicheEvaluation' => filter_var($this->nicheEvaluation, FILTER_SANITIZE_SPECIAL_CHARS),
            'productEvaluation' => filter_var($this->productEvaluation, FILTER_SANITIZE_SPECIAL_CHARS),
            'offerEvaluation' => filter_var($this->offerEvaluation, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectStrategy' => filter_var($this->projectStrategy, FILTER_SANITIZE_SPECIAL_CHARS),
            'productAggregates' => filter_var($this->productAggregates, FILTER_SANITIZE_SPECIAL_CHARS),
            'offersDescription' => filter_var($this->offersDescription, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectStructure' => filter_var($this->projectStructure, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectLinks' => filter_var($this->projectLinks, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectDefinitions' => filter_var($this->projectDefinitions, FILTER_SANITIZE_SPECIAL_CHARS),
            'projectAdsCopy' => filter_var($this->projectAdsCopy, FILTER_SANITIZE_SPECIAL_CHARS),
            'comments' => filter_var($this->comments, FILTER_SANITIZE_SPECIAL_CHARS),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'projectName' => (!empty($this->request->all()['id']) ? 'required|min:3|string|unique:projects,name,' . $this->request->all()['id'] : 'required|min:3|string|unique:projects,name'),
            'projectDescription' => 'nullable|string|min:1',
            'leadsGoal' => 'nullable|integer',
            'whatsappGoal' => 'nullable|integer',
            'telegramGoal' => 'nullable|integer',
            'revenueGoalMin' => 'nullable|numeric|lt:revenueGoal|lt:revenueGoalMax',
            'revenueGoal' => 'nullable|numeric|gt:revenueGoalMin|lt:revenueGoalMax',
            'revenueGoalMax' => 'nullable|numeric|gt:revenueGoal|gt:revenueGoalMin',
            'acTags.*' => 'nullable|string|min:1',
            'hotmartProducts.*' => 'nullable|integer|min:0|alpha_dash',
            'fbCampaigns.*.id.*' => 'nullable|string|min:1',
            'fbCampaigns.*.kpi' => 'nullable|string|min:1',
            'fbCampaigns.*.target' => 'nullable|numeric|min:0',
            'from_date' => 'nullable|date',
            'cart_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'niche' => 'nullable|string|min:3',
            'sub_niche' => 'nullable|string|min:3',
            'type' => 'nullable|string|min:3',
            'instagram' => 'nullable|string|min:1|starts_with:@',
            'facebook' => ['nullable','url','starts_with:https://www','bail', new FacebookUrlCheckRule],
            'youtube' => ['nullable','url','starts_with:https://www','bail', new YoutubeUrlCheckRule],
            'avatar' => 'nullable|string|min:3',
            'transformation' => 'nullable|string|min:3',
            'strengths' => 'nullable|string|min:3',
            'weaknesses' => 'nullable|string|min:3',
            'opportunities' => 'nullable|string|min:3',
            'threats' => 'nullable|string|min:3',
            'instagram_followers_before' => 'nullable|integer',
            'instagram_followers_after' => 'nullable|integer',
            'facebook_fans_before' => 'nullable|integer',
            'facebook_fans_after' => 'nullable|integer',
            'youtube_subscribers_before' => 'nullable|integer',
            'youtube_subscribers_after' => 'nullable|integer',
            'projectTimeline' => 'nullable|string|min:3',
            'projectOpportunities' => 'nullable|string|min:3',
            'projectAvatarInfo' => 'nullable|string|min:3',
            'projectCopy' => 'nullable|string|min:3',
            'projectEventName' => 'nullable|string|min:3',
            'projectPromises' => 'nullable|string|min:3',
            'avatarObjections' => 'nullable|string|min:3',
            'avatarTrapsMyths' => 'nullable|string|min:3',
            'projectDesign' => 'nullable|string|min:3',
            'productQualities' => 'nullable|string|min:3',
            'productEfficiency' => 'nullable|string|min:3',
            'productUnique' => 'nullable|string|min:3',
            'productSteps' => 'nullable|string|min:3',
            'productWarranty' => 'nullable|string|min:3',
            'offer_Unique' => 'nullable|string|min:3',
            'commonEnemy' => 'nullable|string|min:3',
            'productWho' => 'nullable|string|min:3',
            'productRequirements' => 'nullable|string|min:3',
            'nicheEvaluation' => 'nullable|numeric|min:0|max:10',
            'productEvaluation' => 'nullable|numeric|min:0|max:10',
            'offerEvaluation' => 'nullable|numeric|min:0|max:10',
            'projectStrategy' => 'nullable|string|min:3',
            'productAggregates' => 'nullable|string|min:3',
            'offersDescription' => 'nullable|string|min:3',
            'projectStructure' => 'nullable|string|min:3',
            'projectLinks' => 'nullable|string|min:3',
            'projectDefinitions' => 'nullable|string|min:3',
            'projectAdsCopy' => 'nullable|string|min:3',
            'comments' => 'nullable|string|min:3',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'role_id' => 'role',
        ];
    }
}
