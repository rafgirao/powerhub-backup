<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignInsight;
use App\Models\Insight;
use App\Models\IntegrationDet;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectDet;
use App\Models\Sale;
use App\Models\Tag;
use App\Models\Video;
use Exception;
use Google\GTrends;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use stdClass;


class Helper
{
    /**
     * @return Application|Factory|View|void
     */
    public function getAccountInfo()
    {
        if (auth()->check() === false) {
            return view('errors.403');
        }
        if (!session()->has('account')) {
            session(['account' => auth()->user()->accounts()->first()]);
        }
        if (!session()->has('accounts')) {
            session(['accounts' => auth()->user()->accounts()->get()]);
        }
        return;
    }

    /**
     * @return Application|Factory|View|void
     */
    public function userHasAccessToAccount($act)
    {
        (new Helper)->getAccountInfo();
        $accounts = session()->get('accounts');

        foreach ($accounts as $account) {
            if ($account->id == $act) {
                $userHasAccess = true;
            }
        }

        if (!isset($userHasAccess)) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return view('errors.403');
        }

        return;
    }

    /**
     * @param $act
     */
    public function isModelFromTheSameAccount($act)
    {
        if (isset(session()->get('account')->id) and session()->get('account')->id != $act) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            session()->flash('redirect');
        }
    }

    /**
     * @param Project $project
     */
    public function assignProjectCurrency(Project $project)
    {
        if (request('currency')) {
            $project->currency = request('currency');
        }
    }

    /**
     * @param $datePreset
     * @return array
     */
    public function datePreset($datePreset): array
    {
        if ($datePreset === 'Today') {
            $startDate = date('Y-m-d', strtotime("0 days"));
            $endDate = date('Y-m-d', strtotime("1 days"));
        } elseif ($datePreset === 'Today Before') {
            $startDate = date('Y-m-d', strtotime("-1 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Yesterday') {
            $startDate = date('Y-m-d', strtotime("-1 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Yesterday Before') {
            $startDate = date('Y-m-d', strtotime("-2 days"));
            $endDate = date('Y-m-d', strtotime("-1 days"));
        } elseif ($datePreset === 'Last 7 Days') {
            $startDate = date('Y-m-d', strtotime("-7 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 14 Days') {
            $startDate = date('Y-m-d', strtotime("-14 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 30 Days') {
            $startDate = date('Y-m-d', strtotime("-30 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 60 Days') {
            $startDate = date('Y-m-d', strtotime("-60 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 90 Days') {
            $startDate = date('Y-m-d', strtotime("-90 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 180 Days') {
            $startDate = date('Y-m-d', strtotime("-180 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 365 Days') {
            $startDate = date('Y-m-d', strtotime("-365 days"));
            $endDate = date('Y-m-d', strtotime("0 days"));
        } elseif ($datePreset === 'Last 7 Days Before') {
            $startDate = date('Y-m-d', strtotime("-14 days"));
            $endDate = date('Y-m-d', strtotime("-7 days"));
        } elseif ($datePreset === 'Last 14 Days Before') {
            $startDate = date('Y-m-d', strtotime("-30 days"));
            $endDate = date('Y-m-d', strtotime("-14 days"));
        } elseif ($datePreset === 'Last 30 Days Before') {
            $startDate = date('Y-m-d', strtotime("-60 days"));
            $endDate = date('Y-m-d', strtotime("-30 days"));
        } elseif ($datePreset === 'Last 60 Days Before') {
            $startDate = date('Y-m-d', strtotime("-120 days"));
            $endDate = date('Y-m-d', strtotime("-60 days"));
        } elseif ($datePreset === 'Last 90 Days Before') {
            $startDate = date('Y-m-d', strtotime("-180 days"));
            $endDate = date('Y-m-d', strtotime("-90 days"));
        } elseif ($datePreset === 'Last 180 Days Before') {
            $startDate = date('Y-m-d', strtotime("-365 days"));
            $endDate = date('Y-m-d', strtotime("-180 days"));
        } elseif ($datePreset === 'Last 365 Days Before') {
            $startDate = date('Y-m-d', strtotime("-730 days"));
            $endDate = date('Y-m-d', strtotime("-365 days"));
        } else {
            $startDate = date('Y-m-d', strtotime("-5000 days"));
            $endDate = date('Y-m-d', strtotime("1 days"));
        }
        return array($startDate, $endDate);
    }

    /**
     * @param $datePreset
     * @return int
     */
    public function datePresetTotal($datePreset)
    {
        if ($datePreset === 'Today') {
            return 7;
        } elseif ($datePreset === 'Yesterday') {
            return 7;
        } elseif ($datePreset === 'Last 7 Days') {
            return 7;
        } elseif ($datePreset === 'Last 14 Days') {
            return 14;
        } elseif ($datePreset === 'Last 30 Days') {
            return 30;
        } else {
            return 720;
        }
    }

    /**
     * @param $url
     * @param $header
     * @param $method
     * @return mixed
     */
    public function httpClientRequest($url, $header, $method)
    {
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_HTTPHEADER, $header);
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($request);
        curl_close($request);
        $result = json_decode($result);
        return $result;
    }

    /**
     * @param $integrationDet
     * @param $integration
     */
    public function integrationMessageFlash($integrationDet, $integration): void
    {
        if (!$integrationDet->wasRecentlyCreated && $integrationDet->wasChanged()) {
            // updateOrCreate performed an update
            session()->flash('success', "A integração {$integration->provider_name} foi atualizada com sucesso!");
        } elseif (!$integrationDet->wasRecentlyCreated && !$integrationDet->wasChanged() && !(session()->get('alert'))) {
            // updateOrCreate performed nothing, row did not change
            session()->flash('alert', "Nenhuma alteração foi realizada!");
        } else {
            if ($integrationDet->wasRecentlyCreated) {
                // updateOrCreate performed create
                session()->flash('success', "A integração {$integration->provider_name} foi criada com sucesso!");
            }
        }
    }

    /**
     * @param $link
     */
    public function linkMessageFlash($link): void
    {
        $url = '"'.substr($link->url, 0, 30).'..."';

        if (!$link->wasRecentlyCreated && $link->wasChanged()) {
            // performed an update
            session()->flash('success', "O link {$url} foi atualizado com sucesso!");
        } elseif (!$link->wasRecentlyCreated && !$link->wasChanged() && !(session()->get('alert'))) {
            // performed nothing, row did not change
            session()->flash('alert', "Nenhuma alteração foi realizada!");
        } else {
            if ($link->wasRecentlyCreated) {
                // performed create
                session()->flash('success', "O link {$url} foi criado com sucesso!");
            }
        }
    }

    /**
     * @param $project
     * @param null $projectDet
     */
    public function projectMessageFlash($project, $projectDet = null): void
    {
        if ($project->wasRecentlyCreated) {
            // updateOrCreate performed create
            session()->flash('success', "O projeto {$project->name} foi criado com sucesso!");
        } elseif (!$project->wasRecentlyCreated and ((!isset($projectDet) or $projectDet->wasRecentlyCreated) or $project->wasChanged())) {
            // updateOrCreate performed an update
            session()->flash('success', "O projeto {$project->name} foi atualizado com sucesso!");
        } elseif ((!$project->wasRecentlyCreated && !$project->wasChanged() && !(session()->get('alert'))) or !$projectDet->wasRecentlyCreated) {
            // updateOrCreate performed nothing, row did not change
            session()->flash('alert', "Nenhuma alteração foi realizada!");
        }
    }

    /**
     * @param $date
     * @param $day
     * @return false|string
     */
    public function addDays($date, $day)
    {
        $sum = strtotime(date("Y-m-d", strtotime("$date")) . " +$day days");
        return date('Y-m-d', $sum);
    }

    /**
     * @param $currency
     * @param $value
     * @return string|null
     */
    public function brFormatCurrency($currency, $value): ?string
    {
        if (empty($value)) {
            return null;
        }
        return $currency . " " . number_format($value, 2, ',', '.');
    }

    /**
     * @param $value
     * @return string|null
     */
    public function brFormat($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        return number_format($value, 2, ',', '.');
    }

    /**
     * @param $phoneNumber
     * @param $name
     * @param $messageBefore
     * @param $messageAfter
     * @return string
     */
    public function getWhatsUrl($phoneNumber, $name, $messageBefore, $messageAfter): string
    {
        $phoneNumber = filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT);
        $phoneNumber = str_replace(array('+', '-', ' '), '', $phoneNumber);
        $whatsUrl = url('https://wa.me/55') . $phoneNumber . "?text=" . $messageBefore . $name . $messageAfter;
        return ($whatsUrl);
    }

    /**
     * @param $phoneNumber
     * @return string
     */
    public function prepareBrPhoneNumber($phoneNumber): string
    {
        if (empty($phoneNumber)) {
            return '';
        }

        $phoneNumber = filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT);
        $phoneNumber = str_replace(array('+', '-', ' '), '', $phoneNumber);
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        //Se numero tem mais de 13 dígitos
        if (strlen($phoneNumber) > 13) {
            return '';
        }

        //Se numero tem 13 dígitos
        if (strlen($phoneNumber) == 13 and $phoneNumber[0] == 5 and $phoneNumber[1] == 5) {
            return $phoneNumber;
        }

        //Se numero tem 12 dígitos
        if (strlen($phoneNumber) == 12 and $phoneNumber[0] == 5 and $phoneNumber[1] == 5) {

            //Pega ddi+ddd e numero
            $ddd = substr($phoneNumber, 0, 4);
            $num = str_replace($ddd, '', $phoneNumber);

            //Verifica se é celular, se nao for retorno em branco
            if ($num[0] == 2 || $num[0] == 3) {
                return '';
            }

            //se for celular e so tem 8 dígitos, adiciona o 9
            if (strlen($num) == 8) {
                $num = "9{$num}";
            }

            return "{$ddd}{$num}";
        }

        //Se numero tem 11 dígitos nao faz nada
        if (strlen($phoneNumber) == 11) {
            return '55' . $phoneNumber;
        }

        //se numero tem 10 dígitos verifica
        if (strlen($phoneNumber) == 10) {

            //Pega ddd e numero
            $ddd = substr($phoneNumber, 0, 2);
            $num = str_replace($ddd, '', $phoneNumber);

            //Verifica se é celular, se nao for retorno em branco
            if ($num[0] == 2 || $num[0] == 3) {
                return '';
            }

            //se for celular e so tem 8 dígitos, adiciona o 9
            if (strlen($num) == 8) {
                $num = "9{$num}";
            }

            return "55{$ddd}{$num}";
        }

        return '';
    }

    /**
     * @param $text
     * @return string
     */
    public function clearSmsText($text): string
    {
        $text = filter_var($text, FILTER_SANITIZE_STRING);
        $text = strtr(utf8_decode($text), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        $text = substr($text, 0, 160);

        return ($text);
    }

    /**
     * @param $dateType
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function dateType($dateType, $startDate, $endDate): array
    {
        if ($dateType === 'updatedAt') {
            $updatedAfter = $startDate;
            $updatedBefore = $endDate;
            $createdAfter = null;
            $createdBefore = null;
        } elseif ($dateType === 'createdAt') {
            $updatedAfter = null;
            $updatedBefore = null;
            $createdAfter = $startDate;
            $createdBefore = $endDate;
        } elseif ($dateType === 'createdAt') {
            $updatedAfter = null;
            $updatedBefore = null;
            $createdAfter = $startDate;
            $createdBefore = $endDate;
        }

        return array($updatedAfter, $updatedBefore, $createdAfter, $createdBefore);
    }

    /**
     * @param $records
     * @return false|string|null
     */
    public function getChartLabel($records)
    {
        if ($records === null) {
            return null;
        }
        $result = '';
        foreach ($records as $record) {
            $result .= $record->label . "|";
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $records
     * @return false|string|null
     */
    public function getChartValue($records)
    {
        if ($records === null) {
            return null;
        }
        $result = '';
        foreach ($records as $record) {
            $result .= $record->value . "|";
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @return false|string|null
     */
    function getFunnelLabels($array)
    {
        if ($array === null) {
            return null;
        }
        $result = '';
        foreach ($array as $key => $value) {
            $conversion = ($key > 0 and $array[($key - 1)]->subscriber_count) ? ' (' . number_format(100 * $value->subscriber_count / $array[($key - 1)]->subscriber_count,
                    2, '.', '') . '%)' : '';
            $result .= substr($value->name, 0, 20) . '... ' . $value->subscriber_count . $conversion . "|";
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }

        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @return false|string|null
     */
    function getFunnelValues($array)
    {
        if ($array === null) {
            return null;
        }
        $result = '';
        foreach ($array as $value) {
            $result .= $value->subscriber_count . "|";
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }

        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @param $kpi
     * @return false|string
     */
    function getTrafficReportLabels($array, $kpi)
    {

        $result = '';
        foreach ($array as $value) {

            if ($value['id'] === $kpi->id) {
                $result .= $value['date'] . "|";
            }
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @param $kpi
     * @return false|string
     */
    function getTrafficReportValues($array, $kpi)
    {

        $result = '';
        foreach ($array as $value) {
            if ($value['id'] === $kpi->id) {
                $result .= $value['value'] . "|";
            }
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @param $kpi
     * @return false|string
     */
    function getTrafficReportInsightsSummary($array, $kpi)
    {
        $result = 0;
        foreach ($array as $value) {
            if ($value['id'] === $kpi->id) {
                $result = $value['value'] + (float)$result;
            }
        }

        return $result;
    }

    /**
     * @param $array
     * @param $kpi
     * @return false|string
     */
    function getTrafficReportSpendSummary($array, $kpi)
    {
        $result = 0;
        foreach ($array as $value) {
            if ($value['id'] === $kpi->id) {
                $result = $value['spend'] + (float)$result;
            }
        }
        return $result;
    }

    /**
     * @param $array
     * @param $kpi
     * @return false|string
     */
    function getTrafficReportSpend($array, $kpi)
    {
        $result = '';
        foreach ($array as $value) {
            if ($value['id'] === $kpi['id']) {
                $result .= $value['spend'] . "|";
            }
        }

        if (substr_count($result, '|') === 1) {

            return substr($result, 0, strlen($result));
        }

        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $target
     * @param $count
     * @return false|string
     */
    function getTrafficReportTarget($target, $count)
    {

        if (substr_count($count, '|') === 1) {
            $count = substr($count, 0, strlen($count) - 1);
        }

        $target = number_format($target, 2, '.', '');

        $result = str_repeat($target . "|", substr_count($count, '|') + 1);

        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $spend
     * @param $value
     * @return false|string
     */
    function getTrafficReportCpa($spend, $value)
    {
        if (substr_count($spend, '|') === 1) {
            $spend = substr($spend, 0, strlen($spend) - 1);
        }

        if (substr_count($value, '|') === 1) {
            $value = substr($value, 0, strlen($value) - 1);
        }

        $cpa['spend'] = explode('|', $spend);
        $cpa['value'] = explode('|', $value);


        foreach ($cpa['spend'] as $key => $spend) {
            if (isset($cpa['spend'][$key]) and isset($cpa['value'][$key])){
                $spend = (float)$cpa['spend'][$key] ?: null;
                $value = (float)$cpa['value'][$key] ?: null;

                if (isset($value) and $value != 0 and $value != null and $value != '') {
                    $cpaStats[$key] = number_format($spend / $value, 2, '.', '');
                }
            }
        }

        $result = '';
        foreach ($cpaStats as $cpaStat) {
            $result .= $cpaStat . "|";
        }

        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }

        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $act
     * @return mixed
     */
    public function listCurrencies($act)
    {
        $adCurrencies = IntegrationDet::where('account', $act)->where('status', 1)->distinct()->pluck('currency');
        $saleCurrencies = Sale::where('account', $act)->distinct()->pluck('commission_currency');
        return $adCurrencies->merge($saleCurrencies)->filter()->unique();
    }

    /**
     * @param $records
     * @return false|string|null
     */
    public function getProductReport($records)
    {
        if ($records === null) {
            return null;
        }
        $result = '';
        foreach ($records as $key => $record) {
            $result .= $record . "|";
        }
        return substr($result, 0, strlen($result));
    }

    /**
     * @param $array
     * @return false|string|null
     */
    function getVideoLabels($array)
    {
        if ($array === null) {
            return null;
        }

        $result = '';
        foreach ($array as $value) {
            $result .= substr($value->description, 0, 10) . "...|";
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @return false|string|null
     */
    function getVideoValues($array)
    {
        if ($array === null) {
            return null;
        }

        $result = '';
        foreach ($array as $value) {
            $result .= $value->views . "|";
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }
        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $array
     * @return false|string|null
     */
    function getVideoTarget($array)
    {
        if ($array === null) {
            return null;
        }

        $result = '';
        foreach ($array as $value) {
            $result .= $value->target . "|";
        }
        if (substr_count($result, '|') === 1) {
            return substr($result, 0, strlen($result));
        }

        return substr($result, 0, strlen($result) - 1);
    }

    /**
     * @param $url
     * @param $domain
     * @return bool
     */
    public static function UrlChecker($url, $domain): bool
    {
        $urlCheck = '/^(https?:\/\/)?(www\.)?' . $domain . '\/[a-zA-Z0-9(\.\?)?]/';

        if (preg_match($urlCheck, $url) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $project
     * @return array
     */
    public function getReportParameters($project): array
    {
        if ($project->currency) {
            session(['currency' => $project->currency]);
        }

        $act = $project->account;

        $projectsDet = ProjectDet::where('account', $act)->where('project', $project->id)->get();

        foreach ($projectsDet as $projectDet) {
            if ($projectDet->key_type === 'App\Models\Tag') {
                $projectsDetTags[] = $projectDet->key_id;
            }
            if ($projectDet->key_type === 'App\Models\Product') {
                $projectsDetProducts[] = $projectDet->key_id;
            }
            if ($projectDet->key_type === 'App\Models\Campaign') {
                $projectsDetCampaigns[] = $projectDet->key_id;

                $insight = $projectDet->kpiable;
                $projectTrafficKpis[] = $insight;

                $integrationDet = isset($insight) ? $insight->getAttributes()['integration_det'] : null;
                $projectsDetSpends[] = Insight::where('account', $act)
                    ->where('integration_det', $integrationDet)
                    ->where('name', 'spend')
                    ->first();
                $campaignId = Campaign::find($projectDet->key_id);
                $adAccounts[] = isset($campaignId) ? $campaignId->integration_det : null;
            }
            if ($projectDet->key_type === 'App\Models\Video') {
                $projectsDetVideos[] = $projectDet->key_id;
            }
        }

        if (isset($projectTrafficKpis)){
            $projectTrafficKpis = array_unique($projectTrafficKpis);
        }

        $videos = isset($projectsDetVideos) ? Video::getVideosInfo($projectsDetVideos, $act) : null;

        $videoStats['labels'] = (new Helper)->getVideoLabels($videos);
        $videoStats['views'] = (new Helper)->getVideoValues($videos);
        $videoStats['target'] = (new Helper)->getVideoTarget($videos);

        $currency = 'BRL';

        if (session()->has('currency')) {
            $currency = session()->get('currency');
        }

        $currencies = (new Helper)->listCurrencies($act);

//        Versão anterior das tags sem datas de aplicação. Deixar esse bloco de código até 30/Junho/2021 e se não der pau, pode apagar.
//        $tags = isset($projectsDetTags) ? Tag::where('account', $act)->whereIn('id',
//        $projectsDetTags)->orderByDesc('subscriber_count')->get() : null;

        $tags = isset($projectsDetTags) ?
            Tag::withoutGlobalScopes()
                ->where('tags.account', $act)
                ->whereIn('tags.id', $projectsDetTags)
                ->join('lead_tag', 'lead_tag.tag', '=', 'tags.id')
                ->whereBetween('lead_tag.provider_created_at', [$project->start_at, $project->end_at])
                ->groupBy('tags.subscriber_count')
                ->orderByDesc('tags.subscriber_count')
                ->get()
            : null;

        $tagStats = new stdClass();
        $tagStats->labels = (new Helper)->getFunnelLabels($tags);
        $tagStats->values = (new Helper)->getFunnelValues($tags);

        $sales = (isset($projectsDetProducts) and isset($project))
            ? Sale::getSaleSummary($projectsDetProducts,$project) : null;

        $salesDaily = (isset($projectsDetProducts) and isset($project))
            ? Sale::getSaleSummaryDaily($projectsDetProducts,$project) : null;

        $products = ($salesDaily !== null) ? $salesDaily->pluck('product')->unique() : null;

        $saleStats['Realizada']['sum'] = 0;
        $saleStats['Realizada']['count'] = 0;
        $saleStats['Boleto']['sum'] = 0;
        $saleStats['Boleto']['count'] = 0;
        $saleStats['Cancelada']['sum'] = 0;
        $saleStats['Cancelada']['count'] = 0;

        if (isset($sales)) {
            foreach ($sales as $sale) {
                if ($sale->getSaleStatusReport() === 'Realizada' and $sale->commission_currency === $currency) {
                    $saleStats['Realizada']['sum'] = $sale->sum + $saleStats['Realizada']['sum'];
                    $saleStats['Realizada']['count'] = $sale->count + $saleStats['Realizada']['count'];
                }
                if ($sale->getSaleStatusReport() === 'Boleto' and $sale->commission_currency === $currency) {
                    $saleStats['Boleto']['sum'] = $sale->sum + $saleStats['Boleto']['sum'];
                    $saleStats['Boleto']['count'] = $sale->count + $saleStats['Boleto']['count'];
                }
                if ($sale->getSaleStatusReport() === 'Cancelada' and $sale->commission_currency === $currency) {
                    $saleStats['Cancelada']['sum'] = $sale->sum + $saleStats['Cancelada']['sum'];
                    $saleStats['Cancelada']['count'] = $sale->count + $saleStats['Cancelada']['count'];
                }
            }
        }

        if (isset($salesDaily)) {
            foreach ($salesDaily as $saleDaily) {
                foreach ($products as $product) {
                    if ($saleDaily->getSaleStatusReport() === 'Realizada' and $saleDaily->commission_currency === $currency and $saleDaily->product === $product) {
                        $saleStatsDaily[$product]['Realizada']['date'][$saleDaily->date] = $saleDaily->date;
                        $saleStatsDaily[$product]['Realizada']['sum'][$saleDaily->date] = $saleDaily->sum;
                        $saleStatsDaily[$product]['Realizada']['count'][$saleDaily->date] = $saleDaily->count;
                    }
                    if ($saleDaily->getSaleStatusReport() === 'Boleto' and $saleDaily->commission_currency === $currency and $saleDaily->product === $product) {
                        $saleStatsDaily[$product]['Boleto']['date'][$saleDaily->date] = $saleDaily->date;
                        $saleStatsDaily[$product]['Boleto']['sum'][$saleDaily->date] = $saleDaily->sum;
                        $saleStatsDaily[$product]['Boleto']['count'][$saleDaily->date] = $saleDaily->count;
                    }
                    if ($saleDaily->getSaleStatusReport() === 'Cancelada' and $saleDaily->commission_currency === $currency and $saleDaily->product === $product) {
                        $saleStatsDaily[$product]['Cancelada']['date'][$saleDaily->date] = $saleDaily->date;
                        $saleStatsDaily[$product]['Cancelada']['sum'][$saleDaily->date] = $saleDaily->sum;
                        $saleStatsDaily[$product]['Cancelada']['count'][$saleDaily->date] = $saleDaily->count;
                    }
                }
            }
        }


        if (isset($adAccounts)) {

            $trafficStats = CampaignInsight::getTrafficSummaryFbCampaignsSum($act, $currency, $project->start_at,
                $project->end_at, $projectsDetCampaigns);

            $trafficStatsKpis = CampaignInsight::getTrafficSummaryFbCampaigns($act, $currency,
                $project->start_at, $project->end_at, $projectsDetCampaigns, $projectTrafficKpis);

            $trafficStatsSpends = CampaignInsight::getTrafficSummaryFbCampaigns($act, $currency,
                $project->start_at, $project->end_at, $projectsDetCampaigns, $projectsDetSpends);

            $trafficStatsDailyKpis = CampaignInsight::getTrafficSummaryFbCampaignsDaily($act, $currency,
                $project->start_at, $project->end_at, $projectsDetCampaigns, $projectTrafficKpis);

            $trafficStatsDailySpends = CampaignInsight::getTrafficSummaryFbCampaignsDaily($act, $currency,
                $project->start_at, $project->end_at, $projectsDetCampaigns, $projectsDetSpends);



            foreach ($trafficStatsDailyKpis as $key => $trafficStatsDailyKpi) {

                foreach ($trafficStatsDailySpends as $trafficStatsDailySpend) {
                    if ($trafficStatsDailyKpi->date === $trafficStatsDailySpend->date and $trafficStatsDailyKpi->campaign === $trafficStatsDailySpend->campaign) {
                        $trafficStatsDaily[$key] = $trafficStatsDailyKpi;
                        $trafficStatsDaily[$key]['spend'] = $trafficStatsDailySpend->value;
                    }
                }
            }

//            Código parece desnecessário. Deixar esse bloco de código até 30/Junho/2021 e se não der pau, pode apagar.
//            foreach ($trafficStatsKpis as $trafficStatsKpi) {
//                foreach ($trafficStatsSpends as $trafficStatsSpend) {
//                    if ($trafficStatsKpi->campaign === $trafficStatsSpend->campaign) {
//                        $trafficStatsInsight[$trafficStatsKpi->name]['value'] = $trafficStatsKpi->value;
//                        $trafficStatsInsight[$trafficStatsKpi->name]['spend'] = $trafficStatsSpend->value;
//                    }
//                }
//            }

            foreach ($saleStats as $key => $saleStat) {
                if ($key === 'Realizada') {
                    $roiStats = ($trafficStats !== 0) ? ($saleStat['sum'] - $trafficStats) / $trafficStats : 0;
                }
            }
        }

//            Código parece desnecessário. Deixar esse bloco de código até 30/Junho/2021 e se não der pau, pode apagar.
//        if (isset($projectTrafficKpis) and isset($adAccounts) and isset($trafficStatsDaily) and isset($trafficStatsInsight)) {
        if (isset($projectTrafficKpis) and isset($adAccounts) and isset($trafficStatsDaily)) {
            foreach ($projectTrafficKpis as $kpi) {

                $integrationDetKpi = IntegrationDet::find($kpi->integration_det);

                if ($kpi->name !== 'spend') {

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['labels'] =
                        (new Helper)->getTrafficReportLabels($trafficStatsDaily, $kpi);

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['values'] =
                        (new Helper)->getTrafficReportValues($trafficStatsDaily, $kpi);

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['spend'] =
                        (new Helper)->getTrafficReportSpend($trafficStatsDaily, $kpi);

                    $target = ProjectDet::where('account', $act)->where('project', $project->id)->where('kpi_id',
                        $kpi->id)->where('target', '<>', null)->first();

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['target'] =
                        (new Helper)->getTrafficReportTarget($target->target ??
                        null, $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['labels']);

                    if  ($trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['values'] !== null) {

                        $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['cpa'] =
                            (new Helper)->getTrafficReportCpa($trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['spend'],
                                $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['values']);
                    }

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['summaryValue'] =
                        (new Helper)->getTrafficReportInsightsSummary($trafficStatsDaily, $kpi);

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['summarySpend'] =
                        (new Helper)->getTrafficReportSpendSummary($trafficStatsDaily, $kpi);

                    $trafficChartStats[$integrationDetKpi->description . " - " . $kpi->br_name]['summaryTarget'] = $target->target;
                }
            }
        }

        $productCount = 0;

        if (isset($products)) {
            foreach ($products as $product) {
                if (isset($saleStatsDaily)) {
                    $productName = Product::find($product)->product_name;

                    $saleChartStats[$productName]['Realizada']['labels'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Realizada']['date'] ?? null);
                    $saleChartStats[$productName]['Realizada']['sum'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Realizada']['sum'] ?? null);
                    $saleChartStats[$productName]['Realizada']['count'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Realizada']['count'] ?? null);

                    $saleChartStats[$productName]['Boleto']['labels'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Boleto']['date'] ?? null);
                    $saleChartStats[$productName]['Boleto']['sum'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Boleto']['sum'] ?? null);
                    $saleChartStats[$productName]['Boleto']['count'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Boleto']['count'] ?? null);

                    $saleChartStats[$productName]['Cancelada']['labels'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Cancelada']['date'] ?? null);
                    $saleChartStats[$productName]['Cancelada']['sum'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Cancelada']['sum'] ?? null);
                    $saleChartStats[$productName]['Cancelada']['count'] = (new Helper)->getProductReport($saleStatsDaily[$product]['Cancelada']['count'] ?? null);

                    $productCount = $productCount + 3;
                }
            }
        }

        $stats = new stdClass();
        $stats->currency = $currency;
        $stats->currencies = $currencies;

        $trafficStats = $trafficStats ?? null;
        $roiStats = $roiStats ?? null;
        $trafficChartStats = $trafficChartStats ?? null;
        $saleChartStats = $saleChartStats ?? null;

        return array(
            $project,
            $videos,
            $videoStats,
            $tagStats,
            $saleStats,
            $trafficStats,
            $roiStats,
            $trafficChartStats,
            $productCount,
            $saleChartStats,
            $stats,
        );
    }

    /**
     * @param $keyWord
     * @return array
     * @throws Exception
     */
    public function getTrends($keyWord): array
    {
        $options1 = [
            'hl' => 'pt-BR',
            'tz' => 360,
            'geo' => 'BR',
        ];

        $gt = new GTrends($options1);

        $trends = $gt->interestOverTime($keyWord, 0, 'today 12-m');

        $trendValue[0] = 0;
        $trendValue[1] = 0;

        if (isset($trends) and $trends !== false) {
            foreach ($trends as $key => $trend) {
                if ($key <= 13) {
                    $trendValue[0] = $trend['value'][0] + $trendValue[0];
                }
                if ($key > 13 and $key <= 26) {
                    $trendValue[1] = $trend['value'][0] + $trendValue[1];
                }
            }
        }

        return $trendValue;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
        $hostName = $_SERVER['HTTP_HOST'];
        $currentPath = $_SERVER['REQUEST_URI'];

        return $protocol.'://'.$hostName.$currentPath;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getUrlParams($url)
    {
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);
        return $params;
    }

    /**
     * @param $salesGrowthMin
     * @param $salesGrowthMedium
     * @param $salesGrowthMax
     * @return mixed
     */
    public function salesGrowth($salesGrowthMin, $salesGrowthMedium, $salesGrowthMax)
    {
        if ($salesGrowthMax >= 0){
            return $salesGrowthMax;
        }
        if ($salesGrowthMedium >= 0){
            return $salesGrowthMedium;
        }
        return $salesGrowthMin;
    }

    /**
     * @param $salesGrowthMedium
     * @param $salesGrowthMax
     * @return string
     */
    public function salesGrowthFlag($salesGrowthMin, $salesGrowthMedium, $salesGrowthMax): string
    {
        if ($salesGrowthMax >= 0){
            return 'salesGrowthMax';
        }
        if ($salesGrowthMedium >= 0){
            return 'salesGrowthMedium';
        }
        if ($salesGrowthMin >= 0){
            return 'salesGrowthMin';
        }
        return 'salesGrowthBelowGoal';
    }
}
