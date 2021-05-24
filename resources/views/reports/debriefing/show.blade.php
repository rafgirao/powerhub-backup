@extends('layouts.app', [
    'parentSection' => 'debriefings',
    'elementName' => 'debriefings'
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
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Debriefing do Projeto: ')}}{{$project->name}}</a></li>
                {{--            <li class="breadcrumb-item active" aria-current="page">{{ __('Default') }}</li>--}}
            @endcomponent
            @include('reports.debriefing.cards')
            </div>
    @endcomponent

    <div class="container-fluid mt--6">

        @if(auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div>
        @endif

        @if(!auth()->check() || in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock']))
            <div class="ml-xl-9 mr-xl-9">
        @endif

        @if($project->niche !== null and $project->niche !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Nicho do Projeto</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->niche}}</p>
                        @if($project->nicheGrowth > 0)
                        <footer class="blockquote-footer text-success">As buscas pela palavra-chave do nicho cresceram {{$project->nicheGrowth}}% nos últimos 90 dias segundo o Google Trends (comparado com o período anterior).</footer>
                        @elseif($project->nicheGrowth < 0)
                            <footer class="blockquote-footer text-danger">As buscas pela palavra-chave do nicho diminuíram {{$project->nicheGrowth}}% nos últimos 90 dias segundo o Google Trends (comparado com o período anterior).</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->sub_niche !== null and $project->sub_niche !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Subnicho do Projeto</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->sub_niche}}</p>
                        @if($project->subNicheGrowth > 0)
                            <footer class="blockquote-footer text-success">As buscas pela palavra-chave do subnicho cresceram {{$project->subNicheGrowth}}% nos últimos 90 dias segundo o Google Trends (comparado com o período anterior).</footer>
                            @elseif($project->subNicheGrowth < 0)
                            <footer class="blockquote-footer text-orange">As buscas pela palavra-chave do subnicho diminuíram {{$project->subNicheGrowth}}% nos últimos 90 dias segundo o Google Trends (comparado com o período anterior).</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->type !== null and $project->type !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Tipo de Lançamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->type}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->instagram !== null and $project->instagram !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Perfil do Instagram</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p><a href="{{str_replace('@', 'https://instagram.com/',$project->instagram )}}" target="_blank">{{$project->instagram}}</a> - {{number_format($project->instagram_followers_after, '0',',', '.') }} seguidores</p>
                        @if($project->instagramGrowth > 0)
                            <footer class="blockquote-footer text-success">O perfil cresceu {{$project->instagramGrowth}}% durante esse projeto.</footer>
                        @elseif($project->instagramGrowth < 0)
                            <footer class="blockquote-footer text-orange">O perfil reduziu {{$project->instagramGrowth}}% durante esse projeto.</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->facebook !== null and $project->facebook !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Fanpage do Facebook</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p><a href="{{$project->facebook}}" target="_blank">{{$project->facebook}}</a> - {{number_format($project->facebook_fans_after, '0',',', '.') }} fãs</p>
                        @if($project->facebookGrowth > 0)
                            <footer class="blockquote-footer text-success">A fanpage cresceu {{$project->facebookGrowth}}% durante esse projeto.</footer>
                        @elseif($project->facebookGrowth < 0)
                            <footer class="blockquote-footer text-orange">A fanpage reduziu {{$project->facebookGrowth}}% durante esse projeto.</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->youtube !== null and $project->youtube !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Canal do Youtube</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p><a href="{{$project->youtube}}" target="_blank">{{$project->youtube}}</a> - {{number_format($project->youtube_subscribers_after, '0',',', '.') }} inscritos</p>
                        @if($project->youtubeGrowth > 0)
                            <footer class="blockquote-footer text-success">O canal cresceu {{$project->youtubeGrowth}}% durante esse projeto.</footer>
                        @elseif($project->youtubeGrowth < 0)
                            <footer class="blockquote-footer text-orange">O canal reduziu {{$project->youtubeGrowth}}% durante esse projeto.</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->leads_goal !== null and $project->leads !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Total de Leads</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{number_format($project->leads, '0',',', '.')}} Leads</p>
                        @if($project->leads_goal !== 0 and $project->leads_goal !== null and $project->leads_goal !== '' and $project->leads > $project->leads_goal)
                            <footer class="blockquote-footer text-success">Foram captados {{number_format(($project->leads-$project->leads_goal) / $project->leads_goal * 100, '1',',', '.') }}% leads acima da meta.</footer>
                        @elseif($project->leads_goal !== 0 and $project->leads_goal !== null and $project->leads_goal !== '' and $project->leads < $project->leads_goal)
                            <footer class="blockquote-footer text-orange">Foram captados {{number_format(($project->leads-$project->leads_goal) / $project->leads_goal * 100, '1',',', '.') }}% leads abaixo da meta.</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->emailCampaigns !== null and $project->emailCampaigns !== 0 and $project->emailCampaigns !== '' and $project->emailCampaignsSendsSum !== null and $project->emailCampaignsSendsSum !== 0 and $project->emailCampaignsSendsSum !== '')
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header border-0">
                            <h3 class="card-title text-black-50">Desempenho de Emails</h3>
                            <blockquote class="blockquote text-black-50 mb-0">
                                <footer class="blockquote-footer text-info">Os emails do período do projeto tiveram {{number_format($project->emailCampaigns->sum('unique_opens') / $project->emailCampaignsSendsSum * 100,1,',', '.')}}% de abertura e {{number_format($project->emailCampaigns->sum('unique_clicks') / $project->emailCampaigns->sum('unique_opens') * 100,1,',', '.')}}% de cliques em média.</footer>
                            </blockquote>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive" data-toggle="list" data-list-values='["name","type", "sending", "date", "opens", "clicks"]'>
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 30%;" class="sort" data-sort="name">Nome da Campanha</th>
                                    <th scope="col" style="width: 20%;" class="sort" data-sort="type">Tipo de Campanha</th>
                                    <th scope="col" style="width: 10%;" class="sort" data-sort="sending">Envios</th>
                                    <th scope="col" style="width: 10%;" class="sort" data-sort="date">Data de Envio</th>
                                    <th scope="col" style="width: 10%;" class="sort" data-sort="opens">Aberturas</th>
                                    <th scope="col" style="width: 10%;" class="sort" data-sort="clicks">Cliques</th>
                                    <th scope="col" style="width: 10%;"></th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @foreach($project->emailCampaigns as $key => $emailCampaign)
                                <tr>
                                    <th scope="row">
    {{--                                    <div class="media align-items-center">--}}
    {{--                                        <a href="#" class="avatar rounded-circle mr-3">--}}
    {{--                                            <img alt="Image placeholder" src="https://argon-dashboard-pro-laravel.creative-tim.com/argon/img/theme/bootstrap.jpg">--}}
    {{--                                        </a>--}}
    {{--                                        <div class="media-body">--}}
                                                <span class="name mb-0 text-sm"><a href="#" onclick="window.open('{{$emailCampaign->screenshot}}', '_blank')">{{$emailCampaign->campaign_name}}</a></span>
    {{--                                        </div>--}}
    {{--                                    </div>--}}
                                    </th>
                                    <td class="type text-center">
                                        {{$emailCampaign->type}}
                                    </td>
                                    <td class="sending text-center">
                                        {{number_format($emailCampaign->sends, '0',',', '.')}}
                                    </td>
                                    <td class="date text-center">
    {{--                                    <span class="badge badge-dot mr-4">--}}
    {{--                                        <i class="bg-warning"></i>--}}
                                            <span>{{$emailCampaign->last_sent_date}}</span>
    {{--                                    </span>--}}
                                    </td>
                                    <td class="opens">
                                        @if($emailCampaign->sends !== 0 and $emailCampaign->sends !== null and $emailCampaign->sends !== '')
                                            <div class="d-flex align-items-center">
                                                <span class="completion mr-2">({{ $emailCampaign->unique_opens }}) {{number_format($emailCampaign->unique_opens / $emailCampaign->sends *100, '1',',', '.') }}%</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$emailCampaign->opens / $emailCampaign->sends *100}}%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <span class="completion mr-2">0</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="clicks">
                                        @if($emailCampaign->unique_opens !== 0 and $emailCampaign->unique_opens !== null and $emailCampaign->unique_opens !== '')
                                            <div class="d-flex align-items-center">
                                                <span class="completion mr-2">({{ $emailCampaign->unique_clicks }}) {{number_format($emailCampaign->unique_clicks / $emailCampaign->unique_opens *100, '1',',', '.') }}%</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$emailCampaign->unique_clicks / $emailCampaign->unique_opens *100}}%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <span class="completion mr-2">0</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="#" onclick="window.open('{{$emailCampaign->screenshot}}', '_blank')">Ver Email</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                            {{--                        @if(($video->views - $video->target)>0)--}}
                            {{--                            @elseif(($video->views - $video->target)<0)--}}
                            {{--                                <footer class="blockquote-footer text-orange">O vídeo teve {{number_format(($video->views-$video->target)/$video->target*100, '1',',', '.') }}% de visualizações abaixo da meta.</footer>--}}
                            {{--                            @endif--}}
                        </div>
                        <!-- Card footer -->
                    </div>

                </div>
            </div>
        @endif

        @if($project->salesGrowth !== null and $project->salesGrowth !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Faturamento</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$stats->currency}} {{number_format($saleStats['Realizada']['sum'], '2', ',', '.')}}</p>
                        @if($project->salesGrowthFlag === 'salesGrowthMax')
                            <footer class="blockquote-footer text-success">O faturamento foi {{$project->salesGrowth}}% acima da meta máxima.</footer>
                        @elseif($project->salesGrowthFlag === 'salesGrowthMedium')
                            <footer class="blockquote-footer text-success">O faturamento foi {{$project->salesGrowth}}% acima da meta média.</footer>
                        @elseif($project->salesGrowthFlag === 'salesGrowthMin')
                            <footer class="blockquote-footer text-success">O faturamento foi {{$project->salesGrowth}}% acima da meta mínima.</footer>
                        @elseif($project->salesGrowthFlag === 'salesGrowthBelowGoal')
                            <footer class="blockquote-footer text-orange">O faturamento foi {{$project->salesGrowth}}% abaixo da meta.</footer>
                        @endif
                    </blockquote>
                </div>
            </div>
        @endif

        @if($videos !== null and $videos !== "")
                <div class="card bg-gradient-neutral">
                    <div class="card-body">
                        <h3 class="card-title text-black-50">Vídeos do Lançamento</h3>
            @foreach($videos as $key => $video)
                        <blockquote class="blockquote text-black-50 mb-0">
                                <p><a href="{{$video->url}}" target="_blank">{{$video->description}}</a> - {{number_format($video->views, '0',',', '.') }} visualizações</p>
                                @if($video->target !== 0 and $video->target !== null and $video->target !== '' and ($video->views - $video->target)>0)
                                    <footer class="blockquote-footer text-success">O vídeo teve {{number_format(($video->views-$video->target) / $video->target*100, '1',',', '.') }}% de visualizações acima da meta.</footer>
                                @elseif($video->target !== 0 and $video->target !== null and $video->target !== '' and ($video->views - $video->target)<0)
                                    <footer class="blockquote-footer text-orange">O vídeo teve {{number_format(($video->views-$video->target) / $video->target*100, '1',',', '.') }}% de visualizações abaixo da meta.</footer>
                                @endif
                        </blockquote>
                        @if(($key+1) !== count($videos))
                        <hr>
                        @endif
            @endforeach
                    </div>
                </div>
        @endif

        @if($project->avatar !== null and $project->avatar !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Descrição do Avatar</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->avatar}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->transformation !== null and $project->transformation !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Transformação do Produto</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->transformation}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->strengths !== null and $project->strengths !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">O que você fez e funcionou?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->strengths}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->weaknesses !== null and $project->weaknesses !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">O que faria diferente?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->weaknesses}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->opportunities !== null and $project->opportunities !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Quais as oportunidades encontradas?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->opportunities}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->threats !== null and $project->threats !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Quais as ameaças identificadas?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->threats}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
                    </blockquote>
                </div>
            </div>
        @endif

        @if($project->comments !== null and $project->comments !== "")
            <div class="card bg-gradient-neutral">
                <div class="card-body">
                    <h3 class="card-title text-black-50">Quais os links dos melhores Ads?</h3>
                    <blockquote class="blockquote text-black-50 mb-0">
                        <p>{{$project->comments}}</p>
                        {{--                        <footer class="blockquote-footer text-danger">Someone famous in <cite title="Source Title">Source Title</cite></footer>--}}
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

@push('js')

    <script src="{{ asset('argon') }}/vendor/RGraph/libraries/RGraph.svg.common.core.js"></script>
    <script src="{{ asset('argon') }}/vendor/RGraph/libraries/RGraph.svg.funnel.js"></script>
    <script src="{{ asset('js/powerhub.js') }}"></script>
    <script src="{{ asset('argon') }}/vendor/list.js/dist/list.min.js"></script>

@endpush
