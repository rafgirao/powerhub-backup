@extends('layouts.app', [
    'parentSection' => 'reports',
    'elementName' => 'reports'
])
@push('css')
    <meta name="robots" content="noindex">
@endpush
@section('content')
    @component('layouts.headers.auth')
        @if(auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div>
        @endif
        @if(!auth()->check() || in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div class="pt-5 ml-xl-9 mr-xl-9">
        @endif
            @component('layouts.headers.breadcrumbs', [ 'stats' => $stats ?? '', 'project' => $project, 'reportType' => $reportType])
                @slot('title')
                    {{--                {{ __('Default') }}--}}
                @endslot
                <li id="reportTitle" class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Desempenho do Projeto - ')}}{{$project->name}}</a></li>
                {{--            <li class="breadcrumb-item active" aria-current="page">{{ __('Default') }}</li>--}}
            @endcomponent
            @include('reports.performance.cards')
            </div>
    @endcomponent

    <div class="zima container-fluid mt--6" id="targetPdf">

        @if(auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div>
        @endif

        @if(!auth()->check() || in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div class="ml-xl-9 mr-xl-9">
        @endif

        @isset($trafficChartStats)
            <div class="" id="chart-report-traffic-kpis" data-chart-kpis='{{count($trafficChartStats)}}'>
                @foreach($trafficChartStats as $kpi => $singleTrafficChartStat)<div class="">

                    @if(isset($singleTrafficChartStat) and isset($singleTrafficChartStat['summaryValue']) and $singleTrafficChartStat['summaryValue'] !== 0)
                        <div class="card bg-default">

                            <div class="row mt-2 ml-2 mr-2">
                                    <div class="col-lg-6 col-md-6 col-xl-10">
                                    <div class="card-header bg-transparent">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="h3 text-white mb-0">Tráfego: Desempenho de {{$kpi}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Chart -->
                                        <div class="chart">
                                            <!-- Chart wrapper -->
                                            <canvas id="chart-report-traffic-dark-{{$trafficItem}}" data-chart-series='{{$kpi}}' data-chart-labels='{{$singleTrafficChartStat['labels']}}' data-chart-values="{{ $singleTrafficChartStat['values']}}" data-chart-spend="{{ $singleTrafficChartStat['spend']}}" data-chart-target="{{ $singleTrafficChartStat['target']}}" data-chart-cpa="{{ $singleTrafficChartStat['cpa']}}" {{$trafficItem = $trafficItem + 1}} class="chart-canvas"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-xl-2">
                                    <div class="card card-stats mt-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">Investimento</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{$stats->currency}} {{ number_format($singleTrafficChartStat['summarySpend'], 2, ",", ".") }}</span>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-nowrap"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card card-stats mt-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">Resultados</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ number_format($singleTrafficChartStat['summaryValue'], 0, ",", ".") }}</span>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-nowrap"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="card card-stats mt-4">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">Custo/Resultado</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{$stats->currency}} {{ number_format($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'], 2, ",", ".") }}</span>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                @if($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'] > $singleTrafficChartStat['summaryTarget'])
                                                    <span class="text-danger mr-2">Fora da Meta</span>
                                                    <br>
                                                    <span class="text-danger mr-2"><i class="fa fa-arrow-up"></i> {{number_format( ($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'] - $singleTrafficChartStat['summaryTarget'])  / $singleTrafficChartStat['summaryTarget'] * 100, 2, ",", ".")}}%</span>
                                                @elseif($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'] < $singleTrafficChartStat['summaryTarget'])
                                                    <span class="text-success mr-2">Dentro da Meta</span>
                                                    <br>
                                                    <span class="text-success mr-2"><i class="fa fa-arrow-down"></i> {{number_format( ($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'] - $singleTrafficChartStat['summaryTarget']) * -1 / $singleTrafficChartStat['summaryTarget'] * 100, 2, ",", ".")}}%</span>
                                                @elseif($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'] = $singleTrafficChartStat['summaryTarget'])
                                                    <span class="text-default mr-2">No Alvo!</span>
                                                    <br>
                                                    <span class="text-default mr-2"><i class="fa fa-arrow-right"></i> {{number_format( ($singleTrafficChartStat['summarySpend']/$singleTrafficChartStat['summaryValue'] - $singleTrafficChartStat['summaryTarget']) / $singleTrafficChartStat['summaryTarget'] * 100, 2, ",", ".")}}%</span>
                                                @endif
                                                <span class="text-nowrap"></span>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach
            </div>
        @endisset

        @isset($saleChartStats)
            <div id="chart-report-sales-kpis" data-chart-kpis='{{$productCount}}'>
                @foreach($saleChartStats as $product => $productSaleChartStats)
                    @foreach($productSaleChartStats as $status => $singleSaleChartStats)
                        @if($singleSaleChartStats['labels'] !== null )
                            <div class="card bg-default">
                                <div class="card-header bg-transparent">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            {{--                                        <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>--}}
                                            <h5 class="h3 text-white mb-0">Vendas: {{$product}} - {{$status}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Chart -->
                                    <div class="chart">
                                        <!-- Chart wrapper -->
                                        <canvas id="chart-report-sales-dark-{{$salesItem}}" data-chart-series='{{$product}}-{{$status}}' data-chart-labels='{{$singleSaleChartStats['labels']}}' data-chart-sum="{{ $singleSaleChartStats['sum']}}" data-chart-count="{{ $singleSaleChartStats['count']}}" {{$salesItem = $salesItem + 1}} class="chart-canvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        @endisset

        @isset($videoStats['labels'])
            <div id="chart-report-videos-kpis">
                <div class="card bg-default">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                {{--                                        <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>--}}
                                <h5 class="h3 text-white mb-0">Visualizações dos Vídeos</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-report-videos-dark" data-chart-series='videos' data-chart-labels='{{$videoStats['labels']}}' data-chart-values="{{ $videoStats['views']}}" data-chart-target="{{ $videoStats['target']}}" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
    </div>

    <div>
        @if(auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            @include('layouts.footers.auth')
        @endif

        @if(!auth()->check() || in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))

        @endif
    </div>
    @endsection

@push('js')

    <script src="{{ asset('argon') }}/vendor/RGraph/libraries/RGraph.svg.common.core.js"></script>
    <script src="{{ asset('argon') }}/vendor/RGraph/libraries/RGraph.svg.funnel.js"></script>
    <script src="{{ asset('js/powerhub.js') }}"></script>

@endpush
