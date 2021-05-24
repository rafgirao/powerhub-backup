@extends('layouts.app', [
    'parentSection' => 'projects',
    'elementName' => 'newproject'
])

@section('content')
    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs')
            @slot('title')
{{--                {{ __('Projetos') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('page.index', 'components') }}">{{ __('Projetos') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Novo Projeto') }}</li>
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
                            <h3 class="mb-0">Detalhes do Projeto</h3>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form name="projects" action="{{route('projects.store')}}" method="post" autocomplete="off">
                                @csrf

                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'acTags',}}">
                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'hotmartProducts', }}">
                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'fbCampaigns', }}">
                                <input type="hidden" name="fieldsUpdate[]" value="{{ 'videos' }}">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Nome do Projeto</label>
                                        <div class="input-group input-group-merge">
                                            <input name="projectName" class="form-control" placeholder="Informe um nome para o Projeto" type="text" value="{{ old('projectName') ?? null}}">
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
                                            <textarea name="projectDescription" class="form-control" aria-label="Descrição do Projeto">{{ old('projectDescription') ?? null}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-control-label">Tipo de Lançamento</label>
                                    <select name="type" class="select-launch-type form-control" data-toggle="select">
                                        <option selected=""></option>
                                        <option value="Lançamento Semente" {{ (old('type') == 'Lançamento Semente' ? 'selected' : '') }}>Lançamento Semente</option>
                                        <option value="Lançamento Clássico Externo" {{ (old('type') == 'Lançamento Clássico' ? 'selected' : '') }}>Lançamento Clássico Externo</option>
                                        <option value="Lançamento Meteórico" {{ (old('type') == 'Lançamento Meteórico' ? 'selected' : '') }}>Lançamento Meteórico</option>
                                        <option value="Lançamento Possuído" {{ (old('type') == 'Lançamento Possuído' ? 'selected' : '') }}>Lançamento Possuído</option>
                                        <option value="Lançamento Relâmpago" {{ (old('type') == 'Lançamento Relâmpago' ? 'selected' : '') }}>Lançamento Relâmpago</option>
                                        <option value="Lançamento Perpétuo" {{ (old('type') == 'Lançamento Perpétuo' ? 'selected' : '') }}>Lançamento Perpétuo</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Meta de Leads</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="leadsGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0" value="{{ old('leadsGoal') ?? null}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Meta de Grupos no WhatsApp</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="whatsappGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0" value="{{ old('whatsappGoal') ?? null}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Meta de Leads no Telegram</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="telegramGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0" value="{{ old('telegramGoal') ?? null}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Meta de Faturamento Mínimo</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="revenueGoalMin" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0.01" value="{{ old('revenueGoalMin') ?? null}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Meta de Faturamento Ideal</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="revenueGoal" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0.01" value="{{ old('revenueGoal') ?? null}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Meta de Faturamento Top</label>
                                                <div class="input-group input-group-merge">
                                                    <input name="revenueGoalMax" class="form-control" placeholder="Informe uma meta, se houver" type="number" step="0.01" value="{{ old('revenueGoalMax') ?? null}}">
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
                                                <input class="form-control datepicker" name="from_date" id="from_date" placeholder="Selecione uma Data" type="text" value="{{ old('from_date') ?? null}}">
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
                                                <input class="form-control datepicker" name="cart_date" id="cart_date" placeholder="Selecione uma Data" type="text" value="{{ old('cart_date') ?? null}}">
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
                                                <input class="form-control datepicker" name="to_date" id="to_date" placeholder="Selecione uma Data" type="text" value="{{ old('to_date') ?? null}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-6 col-lg-2 form-control-label">Tags do Active Campaign</label>
                                        </div>
                                        <button type="button" name="addAc" id="addAc" class="btn btn-sm btn-primary mb-3 align-text-top text-right">Adicionar</button>
                                        <div class="ac-selector d-none">
                                            <select name="acTags[]" id="acTags[]" class="select-placeholder form-control d-none" data-toggle="select" multiple>
                                               @if($tags)
                                                    @foreach($tags as $tag)
                                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-6 col-lg-2 form-control-label">Produtos da Hotmart</label>
                                        </div>
                                        <button type="button" name="addHotmart" id="addHotmart" class="btn btn-sm btn-primary mb-3 align-text-top text-right">Adicionar</button>
                                        <div class="hotmart-selector d-none">
                                            <select name="hotmartProducts[]" id="hotmartProducts[]" class="select-placeholder form-control" data-toggle="select" multiple>
                                                @if($products)
                                                    @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                    @endforeach
                                                @endif
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
                                            <th style="width: 30%; min-width: 300px;">Link do Vídeo</th>
                                            <th style="width: 30%; min-width: 300px;">Descrição</th>
                                            <th style="width: 15%; min-width: 120px;">Visualizações</th>
                                            <th style="width: 15%; min-width: 120px;">Alvo</th>
                                            <th style="width: 10%; min-width: 100px;">Remover</th>
                                        </tr>
                                    </table>
                                    <div id="buttonsVideo" class="row">
                                        <button type="button" name="addVideo" id="addVideo" class="btn btn-sm btn-primary ml-3 mb-3 align-text-top text-right">Adicionar</button>
                                        <button type="button" name="getVideoInfo" id="getVideoInfo" class="btn btn-sm btn-info mb-3 align-text-top text-right d-none">Obter Informações do Vídeo</button>
                                    </div>

                                </div>

                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h5 class="mb-0">Concepção do Lançamento (Opcional)</h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Informe as Datas / Timeline do Lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Exemplo:
                                                                    - Início da Captação: 10/08/2021
                                                                    - Aula 01: 21/08/2021
                                                                    - Abertura de Carrinho: 24/08/2021">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectTimeline" class="form-control" placeholder="Informe as datas chave do seu lançamento" rows="4" aria-label="Informe as Datas / Timeline do Lançamento">{{ old('projectTimeline') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Oportunidades do Mercado</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Citar, deixar claro, as oportunidades de mercado que esse lançamento vai aproveitar.
                                                            Exemplo:
                                                            - Temos 2000 alunos que fizeram um curso inicial prontos para subir de nível, pedindo um algo mais.
                                                            - Atualmente o governo anunciou uma medida econômica que fará com que essa oportunidade de negócios decole.">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectOpportunities" class="form-control" placeholder="Descreva as oportunidades que o mercado tem no momento do lançamento" aria-label="Oportunidades do Mercado">{{ old('projectOpportunities') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Avatar: Dores e Sonhos</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Citar tudo que você sabe sobre o comportamento do seu avatar.
                                                            - Citar a lista de dores...
                                                            - Citar a lista de sonhos e desejos do avatar...
                                                            => Se tiver mais de um avatar do produto, você deve separar dores e sonhos por avatar
                                                            Citar batalhas internas e externas do avatar:
                                                            - Internas: o que eu sinto por não conquistar o que quero ou por estar com o problema. É sobre o que acontece nos sentimentos e pensamentos. Exemplo: me sinto um lixo por não conseguir colocar meu filho numa escola particular.
                                                            - Externas: é o que as pessoas veem, exemplo: conquistar o carro, comprar a casa, casar, viajar, emagrecer, etc.">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectAvatarInfo" class="form-control" placeholder="Descreva aqui as Dores e os Sonhos do Seu Avatar" aria-label="Avatar: Dores e Sonhos">{{ old('projectAvatarInfo') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Copy do Lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Descreva os 3 Pilares da Copy do seu Lançamento: Encontre seu CIM.
                                                            1-CAUSA - Algo que está errado no mundo e que o expert quer solucionar. Criação de uma causa, manifesto, movimento. Algo que você queira levantar uma bandeira de inconformismo, rebeldia positiva, vontade de quebrar o sistema.
                                                            => Não acho justo o número de engenheiros que estudaram tanto e acabam tendo que trabalhar de úber por não conseguir se colocar no mercado. Chega, isso precisa acabar e foi por isso que eu criei a imersão online Engenheiro Milionário.
                                                            2-INIMIGO EM COMUM (SOMA DE VÁRIOS INIMIGOS) - Some vários problemas, mostre quais são e então trate como uma conspiração.
                                                            => Existe uma classe de profissionais que quer que você acredite que você tem que ser uma modelo para fazer sucesso no instagram. Que somente com um corpo escultural e muito ostentação para mostrar que você fará sucesso. Eu chamo essa conspiração de Ditadura do Fake e eu quero a sua ajuda para destruir esse equívoco de uma vez por todas. Você não pode matar o seu sonho de ser influencer, você não pode acreditar nessa mentira que uma minoria inescrupulosa vem fazendo de tudo para você acreditar.
                                                            3-MENSAGEM 'SALVADOR DO MUNDO' - É a sua mensagem, a sua solução:
                                                            => Sua vida não pode ser um inferno toda vez que você vai fazer uma fritura, por isso criamos o revolucionário AirFryer qcom o revolucionário sistema rapid air que frita os alimentos sem a necessidade de uso de óleo.">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectCopy" class="form-control" placeholder="Descreva os 3 Pilares da Copy do seu Lançamento (CIM)" aria-label="Copy do Lançamento">{{ old('projectCopy') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Nome do Evento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Agora que você já tem o CIM, você precisa de um nome para o seu lançamento possuído
                                                            (CIM = CAUSA, INIMIGOS, MENSAGEM QUE SALVA)
                                                            O que é importante ter no nome do evento?
                                                            Algo que evidencie a sua luta ( causa que quer levantar no mundo)
                                                            Algo que evidencie a sua mensagem salvadora ( benefício que quer gerar, promessa)
                                                            Algo que conecte com emoções bem definidas (ira, amor, ganância, pertencimento, etc)
                                                            Exemplo 1: Plano imediato para emagrecer nas férias
                                                            Exemplo 2: Maratona Dobre seus lucro na bolsa
                                                            Exemplo 3: Imersão Coach milionário
                                                            Exemplo 4: Imersão Exterminador de gordura
                                                            Exemplo 5: Imersão fale inglês com nativos
                                                            Exemplo 6: Maratona solteira nunca mais">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <input name="projectEventName" class="form-control" placeholder="Informe nome para o seu evento" type="text" value="{{ old('projectEventName') ?? null}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Promessas do Lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Agora que você já sabe os inimigos que quer combater e a causa que quer lutar, então faça uma lista de benefícios claros e tangíveis de participar do Possuído.
                                                            Liste 20 vantagens claras e tangíveis em participar do lançamento. não menos que 20 e nada 'pimpão' exemplo: conquistar plenitude.">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectPromises" class="form-control" placeholder="Informe 20 vantagens claras e tangíveis em participar do lançamento" aria-label="Promessas do Lançamento">{{ old('projectPromises') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Objeções do Avatar</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Faça uma lista de possíveis objeções do seu avatar.
                                                            Exemplos clássicos:
                                                            - Não é pra mim
                                                            - É muito difícil
                                                            - Não tenho dinheiro
                                                            - Preciso de dinheiro pra começar?
                                                            - Sou muito velho, sou muito novo, vai funcionar?
                                                            - Eu tenho que ter faculdade?
                                                            - Será que é possível com a minha situação.
                                                            => Preencha com capricho, converse com seu time, entreviste alunos, etc">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="avatarObjections" class="form-control" placeholder="Escreva uma lista de possíveis objeções do seu avatar" aria-label="Objeções do Avatar">{{ old('avatarObjections') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Armadilhas e mitos do avatar</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="(O que ele faz achando que é certo mas é errado). Se esforce para achar uma lista de pelo menos 8.
                                                            Exemplos clássicos:
                                                            -Guardar dinheiro na poupança é bom
                                                            -Comer de 3 em 3 horas emagrece.">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="avatarTrapsMyths" class="form-control" placeholder="Liste ao menos 8 armadilhas bem clássicas do seu nicho" aria-label="Armadilhas e mitos do avatar">{{ old('avatarTrapsMyths') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Linha Gráfica do Lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="As emoções que quero passar para logo e artes são...
                                                            O que quero que o avatar sinta ao ver minha comunicação visual é...
                                                            O que não quero que tenha nem no logo nem nas cores é...
                                                            O que faço questão que exista no logo e nas cores é...">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectDesign" class="form-control" placeholder="Descreva a linha gráfica do lançamento" aria-label="Linha Gráfica do Lançamento">{{ old('projectDesign') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Qualidades do Produto</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Exemplos:
                                                            Ultra Rápido. Isso é verdade?
                                                            Simples. Sim?
                                                            Implementação imediata. Isso é real?
                                                            Baixa curva de aprendizado (rápido demais para aprender, usar e ter resultados). Isso é real?
                                                            Não requer habilidades especiais. Isso é real?
                                                            Não requer acessórios especiais. Isso é real?
                                                            Atua na causa dos problemas?
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="productQualities" class="form-control" placeholder="Descreva a linha gráfica do lançamento" aria-label="Linha Gráfica do Lançamento">{{ old('productQualities') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">O produto realmente resolve os problemas?</label>
{{--                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Agora que você já tem o CIM, você precisa de um nome para o seu lançamento possuído--}}
{{--                                                            (CIM = CAUSA, INIMIGOS, MENSAGEM QUE SALVA)--}}
{{--                                                            O que é importante ter no nome do evento?--}}
{{--                                                            Algo que evidencie a sua luta ( causa que quer levantar no mundo)--}}
{{--                                                            Algo que evidencie a sua mensagem salvadora ( benefício que quer gerar, promessa)--}}
{{--                                                            Algo que conecte com emoções bem definidas (ira, amor, ganância, pertencimento, etc)--}}
{{--                                                            Exemplo 1: Plano imediato para emagrecer nas férias--}}
{{--                                                            Exemplo 2: Maratona Dobre seus lucro na bolsa--}}
{{--                                                            Exemplo 3: Imersão Coach milionário--}}
{{--                                                            Exemplo 4: Imersão Exterminador de gordura--}}
{{--                                                            Exemplo 5: Imersão fale inglês com nativos--}}
{{--                                                            Exemplo 6: Maratona solteira nunca mais">--}}
{{--                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>--}}
{{--                                                        </button>--}}
                                                        <div class="input-group input-group-merge">
                                                            <input name="productEfficiency" class="form-control" placeholder="Descreva a Eficiência do seu Produto" type="text" value="{{ old('productEfficiency') ?? null}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">O Produto tem um sistema único/diferenciado?</label>
                                                        {{--                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Agora que você já tem o CIM, você precisa de um nome para o seu lançamento possuído--}}
                                                        {{--                                                            (CIM = CAUSA, INIMIGOS, MENSAGEM QUE SALVA)--}}
                                                        {{--                                                            O que é importante ter no nome do evento?--}}
                                                        {{--                                                            Algo que evidencie a sua luta ( causa que quer levantar no mundo)--}}
                                                        {{--                                                            Algo que evidencie a sua mensagem salvadora ( benefício que quer gerar, promessa)--}}
                                                        {{--                                                            Algo que conecte com emoções bem definidas (ira, amor, ganância, pertencimento, etc)--}}
                                                        {{--                                                            Exemplo 1: Plano imediato para emagrecer nas férias--}}
                                                        {{--                                                            Exemplo 2: Maratona Dobre seus lucro na bolsa--}}
                                                        {{--                                                            Exemplo 3: Imersão Coach milionário--}}
                                                        {{--                                                            Exemplo 4: Imersão Exterminador de gordura--}}
                                                        {{--                                                            Exemplo 5: Imersão fale inglês com nativos--}}
                                                        {{--                                                            Exemplo 6: Maratona solteira nunca mais">--}}
                                                        {{--                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>--}}
                                                        {{--                                                        </button>--}}
                                                        <div class="input-group input-group-merge">
                                                            <input name="productUnique" class="form-control" placeholder="Descreva se seu produto é único" type="text" value="{{ old('productUnique') ?? null}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Quais são os passos que o método usa para gerar transformação?</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="(tenha clareza dos passos ou chaves do método. Descreva abaixo e explique sucintamente o que cada um significa)
                                                            - Passo X
                                                            - Passo Y
                                                            - Passo Z
                                                            - Passo N">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="productSteps" class="form-control" placeholder="Descreva os passos que o método usa para gerar transformação" aria-label="Quais são os passos que o método usa para gerar transformação?">{{ old('productSteps') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">A Garantia é No Brainner?</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="É aquele tipo de garantia que faz a pessoa confiar totalmente?
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="productWarranty" class="form-control" placeholder="Descreva como é a garantia do seu produto" aria-label="A Garantia é No Brainner?">{{ old('productWarranty') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">A oferta é realmente irresistível?</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Fala a verdade vai? Oferta boa é diferente de oferta irresistível
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="offer_Unique" class="form-control" placeholder="Descreva se a oferta é irresistível" aria-label="A oferta é realmente irresistível?">{{ old('offer_Unique') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Qual é o grande vilão? (inimigo em comum)</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Ele está definido e tem um nome atraente (pegar isso lá na copy do produto)
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="commonEnemy" class="form-control" placeholder="Descreva como é a garantia do seu produto" aria-label="Qual é o grande vilão?">{{ old('commonEnemy') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Para quem é o Programa?</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Para quem quer fazer a sua parte e implementar um plano claro de vida
                                                            - Exige ação
                                                            - Não é para quem quer só ler o livro
                                                            - Etc....
                                                            => Esses são exemplos para clarear a sua mente. Escreve aqui sem preguiça para que você possa segmentar bem.
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="productWho" class="form-control" placeholder="Descreva para quem é o Programa" aria-label="Para quem é o Programa</">{{ old('productWho') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Quais são os requisitos necessários para se fazer o programa/adquirir o produto?</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Exemplos:
                                                            - Saber ler
                                                            - Saber usar a internet para o evento
                                                            - Ter ação
                                                            - O que mais ??? Escreva abaixo...
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="productRequirements" class="form-control" placeholder="Descreva para quem é o Programa" aria-label="Para quem é o Programa">{{ old('productRequirements') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">

                                                    <label class="form-control-label">O NPO está acima de 7,5 ?</label>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="(O cálculo é do que será vendido e não do nome do lançamento)
                                                            (N Alto = Demanda forte e febril, sem teto, necessidade clara e grande consciência da dor)
                                                            (P Alto = Sedutor, Quase Mágico, Bem embalado, Transformador ultra rápido, gostoso de ser comprado, cheiro de desejo no ar, nome que gruda, nome difícil de ser copiado)
                                                            (O Alto = Valor utilitário muito maior que o monetário, impossível de ser ignorada, não tem como reclamar do preço diante de tantas vantagens, condições de pagamentos facilitadas, a copy está pegando direto na jugular, consegue facilmente tangibilizar o retorno que faz o produto parecer barato)
                                                            ">
                                                        <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                    </button>

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Nota do Nicho</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="nicheEvaluation" id="nicheEvaluation" class="form-control nicheEvaluation" placeholder="Informe a Nota do Nicho" type="number" step="0.01" min="0" max="10.00" value="{{ old('nicheEvaluation') ?? null}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Nota do Produto</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="productEvaluation" id="productEvaluation" class="form-control productEvaluation" placeholder="Informe a Nota do Produto" type="number" step="0.01" min="0" max="10.00" value="{{ old('productEvaluation') ?? null}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Nota da Oferta</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="offerEvaluation" id="offerEvaluation" class="form-control offerEvaluation" placeholder="Informe a Nota da Oferta" type="number" step="0.01" min="0" max="10.00" value="{{ old('offerEvaluation') ?? null}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Valor do NPO</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input name="npoEvaluation" id="npoEvaluation" class="form-control npoEvaluation" placeholder="Informe a Notas Anteriores" type="number" step="0.01" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Informações adicionais:</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Estratégia de Lançamento se divide em fases (VOCÊ ORGANIZA COMO QUISER, MAS ESCREVA AQUI PARA FICAR DOCUMENTADO)
                                                            Exemplo:
                                                            01) Comprar tráfego com inúmeros criativos do guarda-chuvas completo
                                                            02) Rodar o evento em 5 aulas noturnas ao vivo
                                                            03) Fazer duas aulas de lançamento ('Raio X' e 'Passa a Régua')
                                                            04) Vender produto com bônus das aulas 4 em diante
                                                            05) Quando abrir o carrinho na quinta-feira a noite, distribuir sequencia de email de ganho, causa e dor até fechar o carrinho
                                                            06) Fazer primeiro lote por 72 horas
                                                            07) Organizar time de recuperação de pedidos
                                                            08) Vender um downsell uma semana após fechar o carrinho
                                                            09) E o que mais?
                                                            10) E o que mais?
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectStrategy" class="form-control" placeholder="Descreva como será executada a estratégia do lançamento" aria-label="Informações adicionais:">{{ old('projectStrategy') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Os agregados do produto principal</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Produto já existe? Sim? Precisa revisar?
                                                            ● Produto do zero? Como vai entregar? Criar a área de membros e integrações.
                                                            ● Testar o caminho do cliente ao fazer a compra
                                                            ● Qual e o upsell e por que escolheu essa oferta?
                                                            ● Essa oferta fará realmente a conversão do upsell ser de no mínimo 10%?
                                                            ● Existe um order bump interessante para a oferta?
                                                            ● Quais são os bônus do produto? Eles fazem sentido? Eles aumentam a vontade de comprar e matam possíveis objeções? Eles são estratégicos?
                                                            - Bônus 1 é esse por ese motivo
                                                            - Bônus 2 é esse por ese motivo
                                                            - Bônus 3 é esse por ese motivo
                                                            - Bônus 4 é esse por ese motivo
                                                            - E por aí vai
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="productAggregates" class="form-control" placeholder="Descreva todos os produtos e bônus que serão ofertados no lançamento" aria-label="Os agregados do produto principal">{{ old('productAggregates') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Ofertas do Lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Aqui eu descrevo as ofertas e suas particularidades
                                                            ● Aqui eu descrevo as ofertas de lotes se assim tiver (exemplo lote1, lote 2)
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="offersDescription" class="form-control" placeholder="Descreva quais e como a ofertas serão utilizadas" aria-label="Ofertas do Lançamento">{{ old('offersDescription') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Estrutura técnica do lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="(É para tudo ficar claro e documentado, principalmente para quem trabalha com time remoto)
                                                            ● Exibição no youtube
                                                            ● Criação de página R2X na seguinte ferramenta e da seguinte forma
                                                            ● Vamos mandar email para toda base? Se sim, como será?
                                                            ● Vamos Fazer teste A/B de páginas para considerar diferentes headlines (testar ao menos duas opções de páginas)
                                                            ● Vamos avaliar o caminho do cliente com precisão para ver se nada atrapalha a conversão ou se gera suporte desnecessário por falta de clareza.
                                                            ● Vamos criar remarketing com vídeo para abandono de carrinho
                                                            ● Vamos fazer páginas de captura na seguinte ferramenta
                                                            ● Vamos usar os seguinte gerenciador de tarefas
                                                            ● Vamos usar as seguintes mídias para anúncios
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectStructure" class="form-control" placeholder="Descreva a Estrutura técnica do lançamento" aria-label="Estrutura técnica do lançamento">{{ old('projectStructure') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Todos os links do lançamento:</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Link do modelo de squeeze:
                                                            ● Links dos vídeos usados para comprar tráfego:
                                                            ● FACEBOOK:
                                                            ● INSTAGRAM:
                                                            ● YOUTUBE ADS:
                                                            ● GOOGLE ADS (antigo AdWords):
                                                            ● Links de ofertas
                                                            ● Links de presentes
                                                            ● Links de páginas de desafios ou outras coisas extras
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectLinks" class="form-control" placeholder="Informe todos os links do lançamento." aria-label="Todos os links do lançamento">{{ old('projectLinks') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Definições do lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Exemplo:
                                                            Até R$250K com ROI mínimo de 4
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectDefinitions" class="form-control" placeholder="Informe as definições do lançamento." aria-label="Definições do lançamento">{{ old('projectDefinitions') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label">Textos dos anúncios do lançamento</label>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle" data-toggle="tooltip" data-placement="right" title="Dicas:
                                                            1) Transforme as vantagens de participar do possuído lá do item 5 em perguntas. Exemplo se a vantagem é dormir sem remédios: Precisa de remédios para dormir ? bla bla bla.
                                                            2) Uma outra forma de fazer é contrariar a lógica. Pegue a lista de armadilhas e use em anúncios como exemplo: Sabia que 97% das pessoas que tem dinheiro na poupança perdem nunca serão ricas? Bla bla bla...
                                                            3) Nossa dica, transfira copy modelo CIM (causa, inimigo e mensagem) em forma de anúncios. Cada item da causa, cada inimigo e o ideal principal costumam funcionar nos anúncios também. A super diversificação de criativos vai fazer a diferença no seu lançamento.
                                                            EXEMPLOS:
                                                            ● Avatar 1 - Variação 1
                                                            CHAMADA
                                                            Seu casamento está em pé de guerra?
                                                            TEXTO
                                                            Já faz tempo que você e seu marido estão discutindo por qualquer coisa? Mesmo fazendo de tudo parece que vocês não se acertam mais? Parece que nunca mais vai ser a mesma coisa? Calma você pode estar sofrendo da síndrome dos 7 anos e isso tem cura! E foi pensando nisso que eu decidi fazer um evento bla bla bla [CTA completo]
                                                            ● Avatar 1 - Variação 2
                                                            CHAMADA TEXTO
                                                            ● Avatar 1 - Variação 3
                                                            CHAMADA TEXTO
                                                            ● Avatar 1 - Variação 4
                                                            CHAMADA TEXTO
                                                            ● Avatar 1 - Variação 5
                                                            CHAMADA TEXTO
                                                            ">
                                                            <span class="btn-inner--icon"><i class="fas fa-info-circle"></i></span>
                                                        </button>
                                                        <div class="input-group input-group-merge">
                                                            <textarea name="projectAdsCopy" class="form-control" placeholder="Escreva aqui os Textos dos anúncios do lançamento." aria-label="Textos dos anúncios do lançamento">{{ old('projectAdsCopy') ?? null}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-light mt-4" onclick='window.location="{{ route('projects.index') }}"'>{{ __('Voltar') }}</button>
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
            let i = 0;
            $("#addFb").click(function(){
                $(this).html("Adicionar +1 Grupo de Campanhas");
                $(this).addClass("mt-2");
                $('.tablehead').removeClass("d-none");
                $('.fbcpm').select2("destroy");
                $('.fbkpi').select2("destroy");

                $("#dynamicTableFb").append('' +
                    '<tr>' +
                    '<td>' +
                        '<select name="fbCampaigns['+i+'][id][]" id="fbCampaigns['+i+'][id][]" class="fbcpm select-placeholder form-control" data-toggle="select" multiple>' +
                            @if($fbCampaigns)
                                @foreach($fbCampaigns as $fbCampaign)
                                    '<option value="{{$fbCampaign->id}}">{{$fbCampaign->getIntegrationDet->description}} - {{$fbCampaign->provider_campaign_name}}</option>' +
                                @endforeach
                            @endif
                        '</select>'+
                    '</td>' +
                    '<td>' +
                        '<select name="fbCampaigns['+i+'][kpi]" id="fbCampaigns['+i+'][kpi]" class="fbkpi select-placeholder form-control" data-toggle="select">' +
                            @foreach($kpis as $kpi)
                                '<option></option>' +
                                '<option value="{{$kpi->id}}">{{$kpi->getIntegrationDet->description}} - {{$kpi->br_name}}</option>' +
                            @endforeach
                        '</select>' +
                    '</td>' +
                    '<td><input type="number" name="fbCampaigns['+i+'][target]" id="fbCampaigns['+i+'][target]" placeholder="" step="0.01" class="form-control" /></td>'+
                    '<td><button type="button" name="removeFb" id="removeFb" class="btn btn-danger remove-tr fa fa-trash"></button></td>' +
                    '</tr>');

                $('.fbcpm').select2({
                    placeholder: "Selecione uma ou mais campanhas",
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
            let i = 0;
            $("#addVideo").click(function(){
                $(this).html("Adicionar mais um Vídeo");
                $('#buttonsVideo').addClass("mt-2");
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
                    url: "{{route('videos.stats')}}", // the url we want to send and get data from
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

    <script>
            $('#nicheEvaluation').focusout(function () {

                if ($('#nicheEvaluation').val() >10 ) {
                    alert('Escolha um número menor que 10');
                };

                var scores = [
                    Number($('#nicheEvaluation').val()),
                    Number($('#productEvaluation').val()),
                    Number($('#offerEvaluation').val()),
                ];

                var sum = 0;

                for(var i = 0; i < scores.length; i++) {
                    sum += scores[i];
                }

                var average = Math.round(sum / scores.length *100)/100;
                $('#npoEvaluation').val(average);
            });

            $('#productEvaluation').focusout(function () {

                if ($('#productEvaluation').val() >10 ) {
                    alert('Escolha um número menor que 10');
                };
                var scores = [
                    Number($('#nicheEvaluation').val()),
                    Number($('#productEvaluation').val()),
                    Number($('#offerEvaluation').val()),
                ];

                var sum = 0;

                for(var i = 0; i < scores.length; i++) {
                    sum += scores[i];
                }

                var average = Math.round(sum / scores.length *100)/100;
                $('#npoEvaluation').val(average);
            });

            $('#offerEvaluation').focusout(function () {

                if ($('#offerEvaluation').val() >10 ) {
                    alert('Escolha um número menor que 10');
                };

                var scores = [
                    Number($('#nicheEvaluation').val()),
                    Number($('#productEvaluation').val()),
                    Number($('#offerEvaluation').val()),
                ];

                var sum = 0;

                for(var i = 0; i < scores.length; i++) {
                    sum += scores[i];
                }

                var average = Math.round(sum / scores.length *100)/100;
                $('#npoEvaluation').val(average);
            });
    </script>

@endpush
