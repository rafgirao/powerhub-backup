@extends('layouts.app', [
    'parentSection' => 'debriefings',
    'elementName' => 'debriefings'
])

@section('content')
    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs')
            @slot('title')
                {{--                {{ __('Debriefings') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('page.index', 'components') }}">{{ __('Debriefings') }}</a></li>
        @endcomponent
        @include('components.alert',['alert' => $alert])
        @include('components.errors',['error' => $errors])
        @include('components.success',['success' => $success])
    @endcomponent

    <div class="container-fluid mt--6">

        <div class="row">
            <div class="col">
                <div class="card-wrapper">
                    <!-- Input groups -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Detalhes do Debriefing</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form name="debriefings" action="{{route('debriefings.update', $project->id)}}" method="post" autocomplete="off">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" value="{{ $project->id }}">

                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h5 class="mb-0">Editar informações do Projeto (Opcional)</h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">

                                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'acTags',}}">
                                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'hotmartProducts', }}">
                                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'fbCampaigns', }}">
                                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'videos' }}">

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Nome do Projeto</label>
                                                        <div class="input-group input-group-merge">
                                                            <input name="projectName" class="form-control" placeholder="Informe um nome para o Projeto" type="text" value="{{ old('projectName') ?? $project->name}}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fas fa-rocket"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Descrição do Projeto</label>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectDescription" class="form-control" aria-label="Descrição do Projeto">{{ old('projectDescription') ?? $project->description}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-4">
                                                    <label class="form-control-label">Tipo de Lançamento</label>
                                                    <select name="type" class="select-launch-type form-control" data-toggle="select">
                                                        <option selected=""></option>
                                                        <option value="Lançamento Semente" {{ (old('type') == 'Lançamento Semente' ? 'selected' : ($project->type == 'Lançamento Semente' ? 'selected' : '')) }}>Lançamento Semente</option>
                                                        <option value="Lançamento Clássico Externo" {{ (old('type') == 'Lançamento Clássico' ? 'selected' : ($project->type == 'Lançamento Clássico' ? 'selected' : '')) }}>Lançamento Clássico Externo</option>
                                                        <option value="Lançamento Meteórico" {{ (old('type') == 'Lançamento Meteórico' ? 'selected' : ($project->type == 'Lançamento Meteórico' ? 'selected' : '')) }}>Lançamento Meteórico</option>
                                                        <option value="Lançamento Possuído" {{ (old('type') == 'Lançamento Possuído' ? 'selected' : ($project->type == 'Lançamento Possuído' ? 'selected' : '')) }}>Lançamento Possuído</option>
                                                        <option value="Lançamento Relâmpago" {{ (old('type') == 'Lançamento Relâmpago' ? 'selected' : ($project->type == 'Lançamento Relâmpago' ? 'selected' : '')) }}>Lançamento Relâmpago</option>
                                                        <option value="Lançamento Perpétuo" {{ (old('type') == 'Lançamento Perpétuo' ? 'selected' : ($project->type == 'Lançamento Perpétuo' ? 'selected' : '')) }}>Lançamento Perpétuo</option>
                                                    </select>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Meta de Leads</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="leadsGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0" value="{{ old('leadsGoal') ?? $project->leads_goal}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Meta de Grupos no WhatsApp</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="whatsappGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0" value="{{ old('whatsappGoal') ?? $project->whatsapp_goal}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Meta de Leads no Telegram</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="telegramGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0" value="{{ old('telegramGoal') ?? $project->telegram_goal}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Meta de Faturamento Mínimo</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="revenueGoalMin" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0.01" value="{{ old('revenueGoalMin') ?? $project->revenue_goal_min}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Meta de Faturamento Ideal</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="revenueGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0.01" value="{{ old('revenueGoal') ?? $project->revenue_goal}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Meta de Faturamento Top</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="revenueGoalMax" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0.01" value="{{ old('revenueGoalMax') ?? $project->revenue_goal_max}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 form-group">
                                                            <label class="form-control-label">Início da Compra de Leads</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control datepicker" name="from_date" id="from_date" placeholder="Selecione uma Data" type="text" value="{{ old('from_date') ?? $project->start_at}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 form-group">
                                                            <label class="form-control-label">Abertura de Carrinho</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control datepicker" name="cart_date" id="cart_date" placeholder="Selecione uma Data" type="text" value="{{ old('cart_date') ?? $project->cart_at}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 form-group">
                                                            <label class="form-control-label">Fechamento do Carrinho</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">
                                                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control datepicker" name="to_date" id="to_date" placeholder="Selecione uma Data" type="text" value="{{ old('to_date') ?? $project->end_at}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-6 col-lg-2 form-control-label">Tags do Active Campaign</label>
                                                        </div>
                                                        @if($oldTags === null)
                                                        <button type="button" name="addAc" id="addAc" class="btn btn-sm btn-primary mb-3 align-text-top text-right">Adicionar</button>
                                                        <div class="ac-selector d-none">
                                                        @else
                                                        <button type="button" name="addAc" id="addAc" class="btn btn-sm btn-primary mb-3 align-text-top text-right d-none">Adicionar</button>
                                                        <div class="ac-selector">
                                                            @endif
                                                            <select name="acTags[]" id="acTags[]" class="select-placeholder form-control" data-toggle="select" multiple>
                                                                @foreach($tags as $tag)
                                                                    @if(isset($oldTags)  &&  in_array($tag->id, $oldTags))
                                                                        <option value="{{$tag->id}}" selected="true">{{ $tag->name }}</option>
                                                                    @else
                                                                        <option value="{{$tag->id}}">{{ $tag->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-6 col-lg-2 form-control-label">Produtos da Hotmart</label>
                                                        </div>
                                                        @if($oldProducts === null)
                                                            <button type="button" name="addHotmart" id="addHotmart" class="btn btn-sm btn-primary mb-3 align-text-top text-right">Adicionar</button>
                                                            <div class="hotmart-selector d-none">
                                                        @else
                                                        <button type="button" name="addHotmart" id="addHotmart" class="btn btn-sm btn-primary mb-3 align-text-top text-right d-none">Adicionar</button>
                                                        <div class="hotmart-selector">
                                                            @endif
                                                            <select name="hotmartProducts[]" id="hotmartProducts[]" class="select-placeholder form-control" data-toggle="select" multiple>
                                                                @isset($products)
                                                                    @foreach($products as $product)
                                                                        @if(isset($oldProducts)  &&  in_array($product->id, $oldProducts))
                                                                            <option value="{{$product->id}}" selected="true">{{$product->product_name}}</option>
                                                                        @else
                                                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endisset
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3 d-inline-block">
                                                    <div class="row">
                                                        <label class="col-6 col-lg-2 form-control-label">Campanhas do Facebook</label>
                                                    </div>

                                                    <table class="table table-responsive table-hover" id="dynamicTableFb">
                                                        <tr class="tablehead d-none">
                                                            <th style="width: 48%; min-width: 480px;">Campanhas</th>
                                                            <th style="width: 30%; min-width: 300px;">Objetivo</th>
                                                            <th style="width: 12%; min-width: 120px;">Custo Alvo</th>
                                                            <th style="width: 10%; min-width: 100px;">Remover</th>
                                                        </tr>

                                                        @foreach($oldProjectsDet as $key => $oldProjectDet)
                                                            <tr>
                                                                <td>
                                                                    @isset($oldFbCampaigns)
                                                                        <select name="fbCampaigns[{{$key}}][id][]" id="fbCampaigns[{{$key}}][id][]" class="fbcpm select-placeholder form-control select2" data-toggle="select2" multiple>
                                                                            @foreach($oldProjectDet as $oldCampaignProjectDet)
                                                                                @foreach($oldFbCampaigns as $oldFbCampaign)
                                                                                    @if($oldCampaignProjectDet->id == $oldFbCampaign->id)
                                                                                        {{$ref[$key][] = $oldFbCampaign->key->id}}
                                                                                        <option value="{{$oldFbCampaign->key->id}}" selected="true">{{$oldFbCampaign->key->getIntegrationDet->description}} - {{$oldFbCampaign->key->provider_campaign_name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach

                                                                            @foreach($fbCampaigns as $fbCampaign)
                                                                                @if(!in_array($fbCampaign->id, $ref[$key]))
                                                                                    <option value="{{$fbCampaign->id}}">{{$fbCampaign->getIntegrationDet->description}} - {{$fbCampaign->provider_campaign_name}}</option>
                                                                                @endif
                                                                            @endforeach

                                                                        </select>
                                                                    @endisset
                                                                </td>

                                                                <td>
                                                                    <select name="fbCampaigns[{{$key}}][kpi]" id="fbCampaigns[{{$key}}][kpi]" class="fbkpi select-placeholder form-control select2" data-toggle="select2">
                                                                        @isset($kpis)
                                                                            @foreach($kpis as $kpi)
                                                                                @if($kpi->id == $key)
                                                                                    <option value="{{$kpi->id}}" selected="true">{{$kpi->getIntegrationDet->description}} - {{$kpi->br_name}}</option>
                                                                                @else
                                                                                    <option value="{{$kpi->id}}">{{$kpi->getIntegrationDet->description}} - {{$kpi->br_name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @endisset
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" name="fbCampaigns[{{$key}}][target]" id="fbCampaigns[{{$key}}][target]" placeholder="" step="0.01" class="form-control" value="{{$oldProjectDet[0]['target']}}"/></td>

                                                                <td class=""><button type="button" name="removeFb[{{$key}}]" id="removeFb[{{$key}}]" class="btn btn-danger remove-tr fa fa-trash"></button></td>
                                                            </tr>

                                                        @endforeach
                                                    </table>
                                                    <div class="row">
                                                        <button type="button" name="addFb" id="addFb" class="btn btn-sm btn-primary ml-3 mb-3 align-text-top text-right">Adicionar</button>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3 d-inline-block">
                                                    <div class="row">
                                                        <label class="col-6 col-lg-2 form-control-label">Vídeos do Lançamento</label>
                                                    </div>

                                                    <table class="table table-responsive table-hover" id="dynamicTableVideo">
                                                        <tr class="tableHeadVideo d-none">
                                                            <th style="width: 30%;">Link do Vídeo</th>
                                                            <th style="width: 30%; min-width: 300px;">Descrição</th>
                                                            <th style="width: 15%; min-width: 120px;">Visualizações</th>
                                                            <th style="width: 15%; min-width: 120px;">Alvo</th>
                                                            <th style="width: 10%; min-width: 100px;">Remover</th>
                                                        </tr>
                                                        @foreach($videosProjectDet as $videoKey => $videoProjectDet)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="videos[{{$videoKey}}][url]" id="videos[{{$videoKey}}][url]" placeholder="URL do Vídeo" class="form-control" value="{{$videoProjectDet->video()->url}}"/>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="videos[{{$videoKey}}][description]" id="videos[{{$videoKey}}][description]" placeholder="Descrição" class="form-control" value="{{$videoProjectDet->video()->description}}"/>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="videos[{{$videoKey}}][views]" id="videos[{{$videoKey}}][views]" placeholder="Visualizações" step="0" class="form-control" value="{{$videoProjectDet->video()->views}}"/>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="videos[{{$videoKey}}][target]" id="videos[{{$videoKey}}][target]" placeholder="Alvo" step="0" class="form-control" value="{{$videoProjectDet->target}}"/>
                                                                </td>
                                                                <td>
                                                                    <button type="button" name="removevideos[{{$videoKey}}]" id="removevideos[{{$videoKey}}]" class="btn btn-danger remove-tr fa fa-trash"></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                    <div id="buttonsVideo" class="row">
                                                        <button type="button" name="addVideo" id="addVideo" class="btn btn-sm btn-primary ml-3 mb-3 align-text-top text-right">Adicionar</button>
                                                        <button type="button" name="getVideoInfo" id="getVideoInfo" class="btn btn-sm btn-info mb-3 align-text-top text-right d-none">Obter Informações do Vídeo</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Nicho</label>
                                    <div class="input-group input-group-merge">
                                        <input name="niche" class="form-control" placeholder="Informe o Nicho do Projeto" type="text" value="{{ old('niche') ?? $project->niche}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class=""></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Subnicho</label>
                                    <div class="input-group input-group-merge">
                                        <input name="subNiche" class="form-control" placeholder="Informe o Subnicho do Projeto" type="text" value="{{ old('subNiche') ?? $project->sub_niche}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class=""></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <label class="form-control-label">Perfil do Instagram</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input name="instagram" class="form-control" placeholder="Informe o Perfil do Instagram" type="text" value="{{ old('instagram') ?? $project->instagram}}">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Seguidores no Início</label>
                                            <div class="input-group input-group-merge">
                                                <input name="instagram_followers_before" class="form-control" placeholder="Seguidores no início do Projeto" type="number" step="0" value="{{ old('instagram_followers_before') ?? $project->instagram_followers_before}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Seguidores no Final</label>
                                            <div class="input-group input-group-merge">
                                                <input name="instagram_followers_after" class="form-control" placeholder="Seguidores no final do Projeto" type="number" step="0" value="{{ old('instagram_followers_after') ?? $project->instagram_followers_after}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <label class="form-control-label">Fanpage do Facebook</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input name="facebook" class="form-control" placeholder="Informe a URL da Fanpage do Facebook" type="text" value="{{ old('facebook') ?? $project->facebook}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Fãs no Início</label>
                                            <div class="input-group input-group-merge">
                                                <input name="facebook_fans_before" class="form-control" placeholder="Fãs no início do Projeto" type="number" step="0" value="{{ old('facebook_fans_before') ?? $project->facebook_fans_before}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Fãs no Final</label>
                                            <div class="input-group input-group-merge">
                                                <input name="facebook_fans_after" class="form-control" placeholder="Fãs no final do Projeto" type="number" step="0" value="{{ old('facebook_fans_after') ?? $project->facebook_fans_after}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <label class="form-control-label">Canal do Youtube</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                                                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.122C.002 7.343.01 6.6.064 5.78l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <input name="youtube" class="form-control" placeholder="Informe a URL do Canal do Youtube" type="text" value="{{ old('youtube') ?? $project->youtube}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Inscritos no Início</label>
                                            <div class="input-group input-group-merge">
                                                <input name="youtube_subscribers_before" class="form-control" placeholder="Inscritos no início do Projeto" type="number" step="0" value="{{ old('youtube_subscribers_before') ?? $project->youtube_subscribers_before}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-3 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label">Inscritos no Final</label>
                                            <div class="input-group input-group-merge">
                                                <input name="youtube_subscribers_after" class="form-control" placeholder="Inscritos no final do Projeto" type="number" step="0" value="{{ old('youtube_subscribers_after') ?? $project->youtube_subscribers_after}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Descreva o seu Avatar</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="avatar" class="form-control" aria-label="Insira aqui a Descrição do Avatar">{{ old('avatar') ?? $project->avatar}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Qual a transformação do Produto</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="transformation" class="form-control" aria-label="Descreva aqui a transformação do seu Produto">{{ old('transformation') ??$project->transformation}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">O que você fez e funcionou?</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="strengths" class="form-control" aria-label="Descreva o que funcionou no seu projeto">{{ old('strengths') ?? $project->strengths}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">O que faria diferente?</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="weaknesses" class="form-control" aria-label="Descreva o que você faria diferente">{{ old('weaknesses') ?? $project->weaknesses}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Que oportunidades você identifica?</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="opportunities" class="form-control" aria-label="Descreva as oportunidades você identifica">{{ old('opportunities') ?? $project->opportunities}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Que ameaças podem prejudicar?</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="threats" class="form-control" aria-label="Descreva as ameaças que podem prejudicar">{{ old('threats') ?? $project->threats}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Quais os links dos melhores Ads?</label>
                                    <div class="input-group input-group-merge">
                                        <textarea name="comments" class="form-control" aria-label="Insira os links dos melhores Ads / Criativos">{{ old('comments') ?? $project->comments}}</textarea>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-light mt-4" onclick='window.location="{{ route('debriefings.index') }}"'>{{ __('Voltar') }}</button>
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Salvar Dados') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Footer -->
        @include('layouts.footers.auth')
    </div>
@endsection

@push('css')

    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/quill/dist/quill.core.css">
@endpush

@push('js')
    <script src="{{ asset('argon') }}/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/quill/dist/quill.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script type="text/javascript">


        $(document).ready(function () {
            let i = {{count($oldFbCampaigns)}};

            if (i > 0) {
                $('.tablehead').removeClass("d-none");
                $("#addFb").html("Adicionar +1 Grupo de Campanhas");
            }

            $("#addFb").click(function(){
                $(this).html("Adicionar +1 Grupo de Campanhas");
                $('.tablehead').removeClass("d-none");
                $('.fbcpm').select2("destroy");
                $('.fbkpi').select2("destroy");

                $("#dynamicTableFb").append('' +
                    '<tr>' +
                    '<td>' +
                        '<select name="fbCampaigns['+i+'][id][]" id="fbCampaigns['+i+'][id][]" class="fbcpm select-placeholder form-control" data-toggle="select" multiple>' +
                            @if($fbCampaigns)
                                @foreach($fbCampaigns as $fbCampaign)
                                    '<option value="{{$fbCampaign->id}}">{{$fbCampaign->provider_campaign_name}}</option>' +
                                @endforeach
                            @endif
                        '</select>'+
                    '</td>' +
                    '<td>' +
                        '<select name="fbCampaigns['+i+'][kpi]" id="fbCampaigns['+i+'][kpi]" class="fbkpi select-placeholder form-control" data-toggle="select">' +
                            @foreach($kpis as $kpi)
                                '<option></option>' +
                            '<option value="{{$kpi}}">{{$kpi}}</option>' +
                            @endforeach
                        '</select>' +
                    '</td>' +
                    '<td><input type="number" name="fbCampaigns['+i+'][target]" id="fbCampaigns['+i+'][target]" placeholder="" step="0.01" class="form-control" /></td>'+
                    '<td><button type="button" name="removeFb" id="removeFb" class="btn btn-danger remove-tr fa fa-trash"></button></td>' +
                    '</tr>');
                $('.fbcpm').select2({
                    allowClear: true
                });
                $('.fbkpi').select2({
                    placeholder: "Selecione",
                    allowClear: true
                });
                ++i;
            });

            $("#addAc").click(function(){
                $('.ac-selector').removeClass("d-none");
                $(this).addClass("d-none");
            });

            $("#addHotmart").click(function(){
                $('.hotmart-selector').removeClass("d-none");
                $(this).addClass("d-none");
            });

            $(document).on('click', '.remove-tr', function(){
                $(this).parents('tr').remove();

                var tbodyRowFbCount = $('#dynamicTableFb').find('tr').length
                console.log(tbodyRowFbCount);
                if (tbodyRowFbCount == 1){
                    $('.tablehead').addClass("d-none");
                    $("#addFb").html("Adicionar");
                }
            });

            $(".select-placeholder").select2({
                allowClear: true
            });

        });
    </script>

    <script type="text/javascript">

        $(document).ready(function () {

            let i = {{count($videosProjectDet)}};
            console.log($('#dynamicTableVideo').find('tr').length);

            if (i > 0) {
                $("#addVideo").html("Adicionar mais um Vídeo");
                $('.tableHeadVideo').removeClass("d-none");
                $('#getVideoInfo').removeClass("d-none");
            }

            $("#addVideo").click(function(){
                $(this).html("Adicionar mais um Vídeo");
                $('#getVideoInfo').removeClass("d-none");
                $('.tableHeadVideo').removeClass("d-none");

                $('#dynamicTableVideo').append('' +
                    '<tr>' +
                    '<td>' +
                    '<input name="videos['+i+'][url]" id="videos['+i+'][url]" class="form-control" placeholder="URL do Vídeo" type="text">' +
                    '</td>' +
                    '<td>' +
                    '<input name="videos['+i+'][description]" id="videos['+i+'][description]" class="form-control" placeholder="Descrição" type="text" disabled>' +
                    '</td>' +
                    '<td>' +
                    '<input type="number" name="videos['+i+'][views]" id="videos['+i+'][views]" placeholder="Visualizações" step="0" class="form-control" disabled>'+
                    '</td>' +
                    '<td>' +
                    '<input type="number" name="videos['+i+'][target]" id="videos['+i+'][target]" placeholder="Alvo" step="0" class="form-control">'+
                    '</td>' +
                    '<td>' +
                    '<button type="button" name="removeVideo" id="removeVideo" class="btn btn-danger remove-tr-video fa fa-trash"></button>' +
                    '</td>' +
                    '</tr>');
                ++i;
            });

            $(document).on('click', '.remove-tr-video', function(){

                $(this).parents('tr').remove();

                var tbodyRowVideoCount = $('#dynamicTableVideo').find('tr').length
                console.log(tbodyRowVideoCount);
                if (tbodyRowVideoCount == 1){
                    $("#addVideo").html("Adicionar");
                    $('.tableHeadVideo').addClass("d-none");
                    $('#getVideoInfo').addClass("d-none");
                }
            });

            $(document).on('click', '#getVideoInfo', function(){
                load_data();
            });

            function load_data(){

                var url_video = [];

                for (let j = 0; j < i; j++) {
                    url_video[j] = document.getElementById('videos['+(j)+'][url]').value;
                }

                $.ajax({
                    url: "{{ route('videos.stats')}}", // the url we want to send and get data from
                    type: "GET", // type of the data we send (POST/GET)
                    data: {url_video: url_video}, // the data we want to send
                    success: function(data){ // when successfully sent data and returned
                        // do something with the returned data

                        for (let l = 0; l < i; l++) {
                            document.getElementById('videos['+l+'][description]').removeAttribute("disabled");
                            document.getElementById('videos['+l+'][description]').value = data[l]['title'];

                            document.getElementById('videos['+l+'][views]').removeAttribute("disabled");
                            document.getElementById('videos['+l+'][views]').value = data[l]['views'];
                        }
                    }
                }).done(function(){
                    // this part will run when we send and return successfully
                    console.log("Success.");
                }).fail(function(){
                    // this part will run when an error occurres
                    console.log("An error has occurred.");
                }).always(function(){
                    // this part will always run no matter what
                    console.log("Complete.");
                });
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.select-launch-type').select2({
                placeholder: "Selecione",
                allowClear: true,
                tags: true
            });
        });
    </script>

@endpush
