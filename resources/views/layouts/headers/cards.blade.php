<div class="row">
{{--    {{dd($stats->trafficValueBefore)}}--}}
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Novos Leads</h5>
                        <span class="h2 font-weight-bold mb-0">{{ number_format($stats->leadsCount, 0, ",", ".") }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                            <i class="ni ni-active-40"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm"><span
                    @if($stats->leadsCount > $stats->leadsCountBefore and $stats->leadsCountBefore != 0)
                         class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                    @elseif($stats->leadsCount < $stats->leadsCountBefore and $stats->leadsCountBefore != 0)
                        class="text-danger mr-2"><i class="fa fa-arrow-down"></i>
                    @elseif($stats->leadsCount = $stats->leadsCountBefore and $stats->leadsCountBefore != 0)
                        class="text-default mr-2"><i class="fa fa-arrow-right"></i>
                    @endif
                     {{number_format( (isset($stats->leadsCountBefore) and $stats->leadsCountBefore != 0) ? ($stats->leadsCount-$stats->leadsCountBefore) / $stats->leadsCountBefore * 100 : 0, 2, ",", ".")}}%</span>
                    @if($stats->leadsCountBefore == 0)
                    <span class="text-nowrap"><i class="fa fa-arrow-right"></i> Sem dados anteriores</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total de Vendas</h5>
                        <span class="h2 font-weight-bold mb-0">{{ number_format($stats->salesCount, 0, ",", ".") }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                            <i class="ni ni-chart-pie-35"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm"><span
                    @if($stats->salesCount > $stats->salesCountBefore and $stats->salesCountBefore != 0)
                        class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                    @elseif($stats->salesCount < $stats->salesCountBefore and $stats->salesCountBefore != 0)
                        class="text-danger mr-2"><i class="fa fa-arrow-down"></i>
                    @elseif($stats->salesCount = $stats->salesCountBefore and $stats->salesCountBefore != 0)
                        class="text-default mr-2"><i class="fa fa-arrow-right"></i>
                    @endif
                     {{number_format( (isset($stats->salesCountBefore) and $stats->salesCountBefore != 0) ? ($stats->salesCount-$stats->salesCountBefore) / $stats->salesCountBefore * 100 : 0, 2, ",", ".")}}%</span>
                   @if($stats->salesCountBefore == 0)
                    <span class="text-nowrap"><i class="fa fa-arrow-right"></i> Sem dados anteriores</span>
                   @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Faturamento</h5>
                        <span class="h2 font-weight-bold mb-0">{{$stats->currency}} {{ number_format($stats->salesValue, 2, ",", ".") }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                            <i class="ni ni-money-coins"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm"><span
                    @if($stats->salesValue > $stats->salesValueBefore and $stats->salesValueBefore != 0)
                        class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                    @elseif($stats->salesValue < $stats->salesValueBefore and $stats->salesValueBefore != 0)
                        class="text-danger mr-2"><i class="fa fa-arrow-down"></i>
                    @elseif($stats->salesValue = $stats->salesValueBefore and $stats->salesValueBefore != 0)
                        class="text-default mr-2"><i class="fa fa-arrow-right"></i>
                    @endif
                     {{$stats->currency}} {{number_format( (isset($stats->salesValueBefore) and $stats->salesValueBefore != 0) ? ($stats->salesValue-$stats->salesValueBefore) / $stats->salesValueBefore * 100 : 0, 2, ",", ".")}}%</span>
                    @if($stats->salesValueBefore == 0)
                    <span class="text-nowrap"><i class="fa fa-arrow-right"></i> Sem dados anteriores</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Investimento em Tráfego</h5>
                        <span class="h2 font-weight-bold mb-0">{{$stats->currency}} {{ number_format($stats->trafficValue, 2, ",", ".") }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                            <i class="ni ni-chart-bar-32"></i>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 text-sm"><span
                    @if($stats->trafficValue > $stats->trafficValueBefore and $stats->trafficValueBefore != 0)
                        class="text-success mr-2"><i class="fa fa-arrow-up"></i>
                    @elseif($stats->trafficValue < $stats->trafficValueBefore and $stats->trafficValueBefore != 0)
                        class="text-danger mr-2"><i class="fa fa-arrow-down"></i>
                    @elseif($stats->trafficValue = $stats->trafficValueBefore and $stats->trafficValueBefore != 0)
                        class="text-default mr-2"><i class="fa fa-arrow-right"></i>
                    @endif
                     {{$stats->currency}} {{ number_format( (isset($stats->trafficValueBefore) and $stats->trafficValueBefore != 0) ? ($stats->trafficValue- $stats->trafficValueBefore) / $stats->trafficValueBefore * 100 : 0, 2, ",", ".") }}%</span>
                    @if($stats->trafficValueBefore == 0)
                    <span class="text-nowrap"><i class="fa fa-arrow-right"></i> Sem dados anteriores</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
