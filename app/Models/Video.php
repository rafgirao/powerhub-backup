<?php

namespace App\Models;

use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Video extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'videos';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'account',
        'url',
        'description',
        'views',
    ];

    /**
     * @return BelongsTo
     */
    public function getAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account', 'id');
    }

    /**
     * @return MorphMany
     */
    public function getProjectDetByKey(): MorphMany
    {
        return $this->morphMany(ProjectDet::class, 'key');
    }

    /**
     * @param array $projectsDetVideos
     * @param $act
     * @return null
     */
    public static function getVideosInfo(array $projectsDetVideos, $act)
    {
        return (isset($projectsDetVideos) and isset($act)) ? Video::
        join('projects_det', 'videos.id', '=', 'projects_det.key_id')
            ->select('projects_det.id', 'videos.description', 'videos.url', 'videos.views', 'projects_det.target')
            ->where('projects_det.account', $act)
            ->where('videos.account', $act)
            ->whereIn('videos.id', $projectsDetVideos)
            ->orderBy('videos.id', 'ASC')
            ->withoutGlobalScopes()->get() : null;
    }

}
