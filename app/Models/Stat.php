<?php

namespace App\Models;

use App\Services\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AccountTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use stdClass;


class Stat extends Model
{
    use Notifiable, HasRoles, HasFactory, AccountTrait;

    /**
     * @var string
     */
    protected $table = 'stats';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'account',
        'stat',
        'currency',
        'label',
        'value',
        'date_preset',
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
     * @param $act
     * @param $datePreset
     * @param $currency
     * @return stdClass
     */
    public function dashStats($act, $datePreset, $currency): stdClass
    {
        $stats = new stdClass();
        $datePresetBefore = $datePreset . " Before";
        $stats->currency = $currency ?? 0;
        $stats->currencies = (new Helper)->listCurrencies($act);
        $stats->datePreset = $datePreset ?? 0;
        $stats->datePresets = self::datePresetStats($act);

        $leadsCount = self::getDashStats($act, $datePreset, null, 'leadsCount');
        $leadsCountBefore = self::getDashStats($act, $datePresetBefore, null, 'leadsCount');
        $salesCount = self::getDashStats($act, $datePreset, $currency, 'salesCount');
        $salesCountBefore = self::getDashStats($act, $datePresetBefore, $currency, 'salesCount');
        $salesValue = self::getDashStats($act, $datePreset, $currency, 'salesValue');
        $salesValueBefore = self::getDashStats($act, $datePresetBefore, $currency, 'salesValue');
        $trafficValue = self::getDashStats($act, $datePreset, $currency, 'trafficValue');
        $trafficValueBefore = self::getDashStats($act, $datePresetBefore, $currency, 'trafficValue');
        $chartSalesLabels = self::getDashStats($act, $datePreset, $currency, 'chartSalesSum');
        $chartSalesSum = self::getDashStats($act, $datePreset, $currency, 'chartSalesSum');
        $chartSalesCount = self::getDashStats($act, $datePreset, $currency, 'chartSalesCount');

        $stats->leadsCount = $leadsCount->value ?? 0;
        $stats->leadsCountBefore = $leadsCountBefore->value ?? 0;
        $stats->salesCount = $salesCount->value ?? 0;
        $stats->salesCountBefore = $salesCountBefore->value ?? 0;
        $stats->salesValue = $salesValue->value ?? 0;
        $stats->salesValueBefore = $salesValueBefore->value ?? 0;
        $stats->trafficValue = $trafficValue->value ?? 0;
        $stats->trafficValueBefore = $trafficValueBefore->value ?? 0;
        $stats->chartSalesLabels = $chartSalesLabels->label ?? 0;
        $stats->chartSalesSum = $chartSalesSum->value ?? 0;
        $stats->chartSalesCount = $chartSalesCount->value ?? 0;

        return $stats;
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $currency
     * @param $stat
     * @return mixed
     */
    public function getDashStats($act, $datePreset, $currency, $stat)
    {
        return self::where('account', $act)
            ->where('date_preset', $datePreset)
            ->where('stat', $stat)
            ->when($currency, function ($query, $currency) {
                return $query->where('currency', $currency);
            })
            ->first();
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     */
    public function leadsStats($act, $datePreset, $stat)
    {
        $leadsStats = (new Lead)->getAcLeads($act, $datePreset, 'createdAt') ?: null;
        if (isset($leadsStats->meta->total)) {
            self::statsUpdateOrCreate($act, $stat, null, null, $leadsStats->meta->total, $datePreset);
        }
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     */
    public function salesStats($act, $datePreset, $stat)
    {

        $salesStats = (new Sale)->getSalesStats($act, $datePreset, $stat);

        if ($salesStats !== null) {
            foreach ($salesStats as $salesStat) {
                self::statsUpdateOrCreate($act, $stat, $salesStat->currency, null, $salesStat->value, $datePreset);
            }
        }
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     */
    public function trafficStats($act, $datePreset, $stat)
    {
        $trafficStats = (new CampaignInsight)->getTrafficStats($act, $datePreset, $stat);

        if ($trafficStats !== null) {
            foreach ($trafficStats as $trafficStat) {
                self::statsUpdateOrCreate($act, $stat, $trafficStat->currency, null, $trafficStat->value, $datePreset);
            }
        }
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     * @return null
     */
    public function chartSalesSumStats($act, $datePreset, $stat)
    {
        $chartStats = (new Sale)->getChartSumValues($act, $datePreset);

        if (!isset($chartStats)) {
            return null;
        }

        foreach ($chartStats as $currency => $chartStat) {
            $records = new stdClass();
            $records->label = (new Helper)->getChartLabel($chartStat);
            $records->value = (new Helper)->getChartValue($chartStat);

            self::statsUpdateOrCreate($act, $stat, $currency, $records->label, $records->value, $datePreset);
        }
    }

    /**
     * @param $act
     * @param $datePreset
     * @param $stat
     */
    public function chartSalesCountStats($act, $datePreset, $stat)
    {
        $chartStats = (new Sale)->getChartCountValues($act, $datePreset);

        if (isset($chartStats)) {
            foreach ($chartStats as $currency => $chartStat) {
                $records = new stdClass();
                $records->label = (new Helper)->getChartLabel($chartStat);
                $records->value = (new Helper)->getChartValue($chartStat);

                self::statsUpdateOrCreate($act, $stat, $currency, $records->label, $records->value, $datePreset);
            }
        }
    }


    /**
     * @param $act
     * @param $stat
     * @param $currency
     * @param $datePreset
     * @param $value
     * @return mixed
     */
    protected function statsUpdateOrCreate($act, $stat, $currency = null, $label = null, $value, $datePreset)
    {
        return self::updateOrCreate(
            [
                'account' => $act,
                'stat' => $stat,
                'currency' => $currency,
                'date_preset' => $datePreset,
            ],
            [
                'label' => $label,
                'value' => $value,
            ]
        );
    }

    /**
     * @param $act
     * @return mixed
     */
    public function datePresetStats($act)
    {
        return self::where('account', $act)
            ->where('date_preset', 'not like', "%Before%")
            ->distinct()
            ->pluck('date_preset');
    }

}
