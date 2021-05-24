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
                        @component('layouts.headers.breadcrumbs', ['stats' => $stats ?? '', 'project' => $project, 'reportType' => $reportType])
                            @slot('title')
                                {{--                {{ __('Default') }}--}}
                            @endslot
                            <li id="reportTitle" class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Concepção do Projeto - ')}}{{$project->name}}</a></li>
                            {{--            <li class="breadcrumb-item active" aria-current="page">{{ __('Default') }}</li>--}}
                        @endcomponent
{{--                    @include('reports.performance.cards')--}}
                        {{--                    </div>--}}
    </div>
    @endcomponent

    {{--    <div class="chart">--}}
    {{--        <canvas class="chartLine"--}}
    {{--                data-chart-background-color="<?= $chart->getColorGreenOnlyWithOpacity() ?>"--}}
    {{--                data-chart-border-color="<?= $chart->getColorGreenOnly() ?>"--}}
    {{--                data-chart-labels="<?= $chart->getLabel($categoryPosts) ?>"--}}
    {{--                data-chart-values="[0, 50, 10, 30, 15, 40, 20, 60, 60]"></canvas>--}}
    {{--    </div>--}}

    <div class="zima container-fluid mt--6" id="targetPdf">

        @if(auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div>
        @endif

        @if(!auth()->check() || in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div class="ml-xl-9 mr-xl-9">
        @endif

        @if($project->cp_timeline !== null and $project->cp_timeline !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Timeline do Lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_timeline}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_opportunities !== null and $project->cp_opportunities !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Oportunidades do Mercado</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_opportunities}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_avatar_pains_dreams !== null and $project->cp_avatar_pains_dreams !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Avatar: Dores e Sonhos</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_avatar_pains_dreams}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_copy !== null and $project->cp_copy !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Copy do Lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_copy}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_event_name !== null and $project->cp_event_name !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Nome do Evento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_event_name}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_event_promisescp_avatar_objections !== null and $project->cp_event_promisescp_avatar_objections !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Promessas do Lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_event_promisescp_avatar_objections}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_avatar_objections !== null and $project->cp_avatar_objections !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Objeções do Avatar</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_avatar_objections}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_avatar_traps_mythscp_design_launch_line !== null and $project->cp_avatar_traps_mythscp_design_launch_line !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Armadilhas e mitos do avatar</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_avatar_traps_mythscp_design_launch_line}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_design_launch_line !== null and $project->cp_design_launch_line !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Linha Gráfica do Lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_design_launch_line}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_product_qualities !== null and $project->cp_product_qualities !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Qualidades do Produto</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_product_qualities}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_product_efficiency !== null and $project->cp_product_efficiency !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">O produto realmente resolve os problemas?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_product_efficiency}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_product_unique !== null and $project->cp_product_unique !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">O Produto tem um sistema único/diferenciado?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_product_unique}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_product_steps !== null and $project->cp_product_steps !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Quais são os passos que o método usa para gerar transformação?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_product_steps}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_product_warranty !== null and $project->cp_product_warranty !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">A Garantia é No Brainner?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_product_warranty}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_offer_unique !== null and $project->cp_offer_unique !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">A oferta é realmente irresistível?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_offer_unique}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_common_enemy !== null and $project->cp_common_enemy !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Qual é o grande vilão? (inimigo em comum)</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_common_enemy}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_who !== null and $project->cp_who !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Para quem é o Programa?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_who}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_requirements !== null and $project->cp_requirements !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Quais são os requisitos necessários para se fazer o programa/adquirir o produto?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_requirements}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_niche !== null
            and $project->cp_product !== null
            and $project->cp_offer !== null)
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">O NPO está acima de 7,5?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>Nota do Nicho: {{$project->cp_niche}}</p>
                        <p>Nota do Produto: {{$project->cp_product}}</p>
                        <p>Nota do Oferta: {{$project->cp_offer}}</p>
                        <p>Nota do NPO: {{$project->npo_evaluation}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_strategy !== null and $project->cp_strategy !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Informações adicionais:</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_strategy}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_aggregates !== null and $project->cp_aggregates !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Os agregados do produto principal</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_aggregates}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_offers_description !== null and $project->cp_offers_description !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Ofertas do Lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_offers_description}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_structure !== null and $project->cp_structure !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Estrutura técnica do lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_structure}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_links !== null and $project->cp_links !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Todos os links do lançamento:</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_links}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_definitions !== null and $project->cp_definitions !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Definições do lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_definitions}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->cp_ads_copy !== null and $project->cp_ads_copy !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Textos dos anúncios do lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->cp_ads_copy}}</p>
                    </blockquote>
                </div>
            </div>
        @endif

    </div>

    <div>
        @if(auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            @include('layouts.footers.auth')
        @endif

        @if(!auth()->check() || in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))

        @endif
    </div>

@endsection
