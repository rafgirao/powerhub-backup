<div class="row">

    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Faturamento</h5>
                        @isset($saleStats)
                            @foreach($saleStats as $key => $saleStat)
                                @if($key === 'Realizada')
                                    <span class="h4 font-weight-bold mb-0">{{$stats->currency}} {{ number_format($saleStat['sum'], 2, ",", ".") }}</span>
                                @endif
                            @endforeach
                        @endisset
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni ni-money-coins"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
{{--                    @if($stats->leadsCount > $stats->leadsCountBefore)--}}
{{--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->leadsCount < $stats->leadsCountBefore)--}}
{{--                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->leadsCount = $stats->leadsCountBefore)--}}
{{--                        <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @endif--}}
                    <span class="text-nowrap"></span>
                </p>
            </div>
        </div>

        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Vendas</h5>
                        @isset($saleStats)
                            @foreach($saleStats as $key => $saleStat)
                                @if($key === 'Realizada')
                                    <span class="h4 font-weight-bold mb-0">{{ number_format($saleStat['count'], 0, ",", ".") }}</span>
                                @endif
                            @endforeach
                        @endisset
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                            <i class="ni ni-basket"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
{{--                    @if($stats->salesCount > $stats->salesCountBefore)--}}
{{--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->salesCount < $stats->salesCountBefore)--}}
{{--                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->salesCount = $stats->salesCountBefore)--}}
{{--                        <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @endif--}}
                    <span class="text-nowrap"></span>
                </p>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Investimento</h5>
                        @isset($trafficStats)
                            {{--                                {{$investiment = $trafficStat->sum}}--}}
                            <span class="h4 font-weight-bold mb-0">{{$stats->currency}} {{ number_format($trafficStats, 2, ",", ".") }}</span>
                        @endisset
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                            <i class="ni ni-chart-bar-32"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
{{--                    @if($stats->leadsCount > $stats->leadsCountBefore)--}}
{{--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->leadsCount < $stats->leadsCountBefore)--}}
{{--                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->leadsCount = $stats->leadsCountBefore)--}}
{{--                        <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @endif--}}
                    <span class="text-nowrap"></span>
                </p>
            </div>
        </div>

        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Boletos / Expirados</h5>
                        @isset($saleStats)
                            @foreach($saleStats as $key => $saleStat)
                                @if($key === 'Boleto')
                                    <span class="h4 font-weight-bold mb-0">{{ number_format($saleStat['count'], 0, ",", ".") }}</span>
                                @endif
                            @endforeach
                        @endisset
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-light text-white rounded-circle shadow">
                            <i class="ni ni-single-copy-04"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
{{--                    @if($stats->salesCount > $stats->salesCountBefore)--}}
{{--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->salesCount < $stats->salesCountBefore)--}}
{{--                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->salesCount = $stats->salesCountBefore)--}}
{{--                        <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @endif--}}
                    <span class="text-nowrap"></span>
                </p>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">ROI</h5>
                        @isset($roiStats)
                            <span class="h4 font-weight-bold mb-0">{{ ($saleStats['Realizada']['sum'] !== 0 and $trafficStats !== 0) ? number_format($roiStats, 2, ",", ".") : 0 }}</span>
                        @endisset
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-purple text-white rounded-circle shadow">
                            <i class="ni ni-active-40"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
{{--                    @if($stats->leadsCount > $stats->leadsCountBefore)--}}
{{--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->leadsCount < $stats->leadsCountBefore)--}}
{{--                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->leadsCount = $stats->leadsCountBefore)--}}
{{--                        <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @endif--}}
                    <span class="text-nowrap"></span>
                </p>
            </div>
        </div>

        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Cancelados</h5>
                        @isset($saleStats)
                            @foreach($saleStats as $key => $saleStat)
                                @if($key === 'Cancelada')
                                    <span class="h4 font-weight-bold mb-0">{{ number_format($saleStat['count'], 0, ",", ".") }}</span>
                                @endif
                            @endforeach
                        @endisset
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-credit-card"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
{{--                    @if($stats->salesCount > $stats->salesCountBefore)--}}
{{--                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->salesCount < $stats->salesCountBefore)--}}
{{--                        <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @elseif($stats->salesCount = $stats->salesCountBefore)--}}
{{--                        <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100, 2, ",", ".")}}%</span>--}}
{{--                    @endif--}}
                    <span class="text-nowrap"></span>
                </p>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 mt--6">
        <div style="width: 100%; height: 100%" id="chart-lead-container" data-chart-labels='{{$tagStats->labels ?? ' | '}}' data-chart-values='{{$tagStats->values ?? null}}'></div>
    </div>
</div>
