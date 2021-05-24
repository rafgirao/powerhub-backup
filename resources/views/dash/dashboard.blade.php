@extends('layouts.app', [
    'parentSection' => 'dashboards',
    'elementName' => 'dashboard'
])
@section('content')
    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs', ['stats' => $stats, 'reportType' => $reportType])
            @slot('title')
{{--                {{ __('Default') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
{{--            <li class="breadcrumb-item active" aria-current="page">{{ __('Default') }}</li>--}}
        @endcomponent

        @include('layouts.headers.cards')
    @endcomponent

{{--    <div class="chart">--}}
{{--        <canvas class="chartLine"--}}
{{--                data-chart-background-color="<?= $chart->getColorGreenOnlyWithOpacity() ?>"--}}
{{--                data-chart-border-color="<?= $chart->getColorGreenOnly() ?>"--}}
{{--                data-chart-labels="<?= $chart->getLabel($categoryPosts) ?>"--}}
{{--                data-chart-values="[0, 50, 10, 30, 15, 40, 20, 60, 60]"></canvas>--}}
{{--    </div>--}}

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-8">
                <div class="card bg-default">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
{{--                                <h6 class="text-light text-uppercase ls-1 mb-1">Overview</h6>--}}
                                <h5 class="h3 text-white mb-0">Faturamento</h5>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-sales-dark" data-chart-labels='{{$stats->chartSalesLabels}}' data-chart-values="{{ $stats->chartSalesSum}}" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
{{--                                <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>--}}
                                <h5 class="h3 mb-0">Total de Vendas</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-bars" data-chart-labels='{{$stats->chartSalesLabels}}' data-chart-values="{{$stats->chartSalesCount}}" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-4">
                <!-- Members list group card -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">Últimas Transações</h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list my--3">
                            @foreach($sales as $sale)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">{{$sale->transaction}} | {{$sale->price_currency}} {{$sale->price}}</a>
                                            </h4>
                                            <small>{{$sale->status}}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Members list group card -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">Últimos Clientes</h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list my--3">
                            @foreach($sales as $sale)
                            <li class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <!-- Avatar -->
                                        <a href="#" class="avatar rounded-circle" style="width: 38px; height: 38px">
                                            <img alt="Image placeholder" src="{{ (new \Creativeorange\Gravatar\Gravatar())->get($sale->getLead->email ?? 'example@gmail.com') }}">
                                        </a>
                                    </div>
                                    <div class="col ml--2">
                                        <h4 class="mb-0">
                                            <a href="#!">{{$sale->getLead->first_name ?? ''}} {{$sale->getLead->last_name ?? ''}}</a>
                                    </h4>
                                        <small>{{$sale->getLead->email ?? ''}}</small>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Members list group card -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">Últimos Produtos Vendidos</h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list my--3">
                            @foreach($sales as $sale)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar rounded-circle" style="width: 40px; height: 40px">
                                                <img alt="Image placeholder" src="{{ $sale->getProduct->cover_photo ?? null}}">
                                            </a>
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">{{$sale->getProduct->product_name ?? null}}</a>
                                            </h4>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        @include('layouts.footers.auth')
    </div>
@endsection



@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
