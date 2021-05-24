@extends('layouts.app', [
    'parentSection' => 'integrations',
    'elementName' => 'integrations'
])

@section('content')
    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs')
            @slot('title')
{{--                {{ __('Integrações') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('integrations') }}">{{ __('Integrações') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Todas as Integrações') }}</li>
        @endcomponent
        @include('components.alert',['alert' => $alert])
        @include('components.errors',['error' => $errors])
        @include('components.success',['success' => $success])
    @endcomponent

    <div class="container-fluid mt--6">
        <div class="row card-wrapper">

            <div class="col-lg-3">
                <!-- Image overlay -->
                <div class="card text-white border-0">
                    <img class="card-img" src="{{ url(asset('/media/integrations/activecampaign.png')) }}" alt="Card image">
                    <div class="card-img-overlay d-flex align-items-end">
{{--                        <div>--}}
{{--                            <h5 class="h2 card-title text-white mb-2">Card title</h5>--}}
{{--                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This--}}
{{--                                content is a little bit longer.</p>--}}
{{--                            <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>--}}
{{--                        </div>--}}
                        <div class="">
                            @if($acIntegration === null)
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".activecampaign">Adicionar</button>
                            @else
                                <div class="btn-toolbar">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".activecampaign">Editar Integração</button>
                                    <form name="acIntegration" action="{{route('integrations.destroy', ['integration' => $acIntegration])}}" method="post" onsubmit="return confirm('Tem certeza que você quer deletar a integração {{addslashes($acIntegration->provider_name)}}?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger fa fa-trash"></button>
                                    </form>
                                    <i class="far fa-check-circle text-success text-lg mt-1 ml-2"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <!-- Image overlay -->
                <div class="card text-white border-0">
                    <img class="card-img" src="{{ url(asset('/media/integrations/hotmart.png')) }}" alt="Card image">
                    <div class="card-img-overlay d-flex align-items-end">
                        {{--                        <div>--}}
                        {{--                            <h5 class="h2 card-title text-white mb-2">Card title</h5>--}}
                        {{--                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This--}}
                        {{--                                content is a little bit longer.</p>--}}
                        {{--                            <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>--}}
                        {{--                        </div>--}}
                        <div class="">
                            @if($hotmartIntegration === null)
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".hotmart">Adicionar</button>
                            @else
                                <div class="btn-toolbar">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".hotmart">Editar Integração</button>
                                    <form name="hotmartIntegration" action="{{route('integrations.destroy', ['integration' => $hotmartIntegration])}}" method="post" onsubmit="return confirm('Tem certeza que você quer deletar a integração {{addslashes($hotmartIntegration->provider_name)}}?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger fa fa-trash"></button>
                                    </form>
                                    <i class="far fa-check-circle text-success text-lg mt-1 ml-2"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <!-- Image overlay -->
                <div class="card text-white border-0">
                    <img class="card-img" src="{{ url(asset('/media/integrations/eduzz.png')) }}" alt="Card image">
                    <div class="card-img-overlay d-flex align-items-end">
                        {{--                        <div>--}}
                        {{--                            <h5 class="h2 card-title text-white mb-2">Card title</h5>--}}
                        {{--                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This--}}
                        {{--                                content is a little bit longer.</p>--}}
                        {{--                            <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>--}}
                        {{--                        </div>--}}
                        <div class="">
                            <h4 class="text-black-50">[Em desenvolvimento]</h4>
{{--                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".eduzz">Adicionar</button>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class = col-lg-3>
                <!-- Image overlay -->
                <div class="card text-white border-0">
                    <img class="card-img" src="{{ url(asset('/media/integrations/provi.png')) }}" alt="Card image">
                    <div class="card-img-overlay d-flex align-items-end">
                        {{--                        <div>--}}
                        {{--                            <h5 class="h2 card-title text-white mb-2">Card title</h5>--}}
                        {{--                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This--}}
                        {{--                                content is a little bit longer.</p>--}}
                        {{--                            <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>--}}
                        {{--                        </div>--}}
                        <div class="col-auto">
                            <h4 class="text-black-50">[Em desenvolvimento]</h4>
{{--                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".provi">Adicionar</button>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row card-wrapper">

            <div class = col-lg-3>
                <!-- Image overlay -->
                <div class="card text-white border-0">
                    <img class="card-img" src="{{ url(asset('/media/integrations/facebookads.png')) }}" alt="Card image">
                    <div class="card-img-overlay d-flex align-items-end">
                        {{--                        <div>--}}
                        {{--                            <h5 class="h2 card-title text-white mb-2">Card title</h5>--}}
                        {{--                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This--}}
                        {{--                                content is a little bit longer.</p>--}}
                        {{--                            <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>--}}
                        {{--                        </div>--}}
                        <div class="">
                            @if($fbIntegration === null)
                                <button onclick='window.location="{{ route('facebook.start') }}"' type="button" class="btn btn-sm btn-primary">Adicionar</button>
                            @else
                                <div class="btn-toolbar">
                                    <button onclick='window.location="{{ route('facebook.start') }}"' type="button" class="btn btn-sm btn-primary">Editar Integração</button>
                                    <form name="fbIntegration" action="{{route('integrations.destroy', ['integration' => $fbIntegration])}}" method="post" onsubmit="return confirm('Tem certeza que você quer deletar a integração {{addslashes($fbIntegration->provider_name)}}?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger fa fa-trash"></button>
                                    </form>
                                    <i class="far fa-check-circle text-success text-lg mt-1 ml-2"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class = col-lg-3>
                <!-- Image overlay -->
                <div class="card text-white border-0">
                    <img class="card-img" src="{{ url(asset('/media/integrations/googleads.png')) }}" alt="Card image">
                    <div class="card-img-overlay d-flex align-items-end">
                        {{--                        <div>--}}
                        {{--                            <h5 class="h2 card-title text-white mb-2">Card title</h5>--}}
                        {{--                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This--}}
                        {{--                                content is a little bit longer.</p>--}}
                        {{--                            <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>--}}
                        {{--                        </div>--}}
                        <div class="col-auto">
                            <h4 class="text-black-50">[Em desenvolvimento]</h4>
{{--                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".googleads">Adicionar</button>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('layouts.footers.auth')
    </div>
    @include('integrations.activecampaign', ['acCredentials' => $acCredentials])
    @include('integrations.hotmart', ['hotmartCredentials' => $hotmartCredentials])
    @include('integrations.facebook', ['facebookCredentials' => $fbCredentials, 'fbAdAccountStatus' => $fbAdAccountStatus])
    @include('integrations.wizard', [])
@endsection

@push('js')
    @if($acIntegration === null and $hotmartIntegration === null and $fbIntegration === null)
        <script>
            $(function() {
                $('#wizard').modal('show');
            });
        </script>
    @endif

    @if($modal === 'Facebook Modal')
        <script>
            $(function() {
                $('#facebook').modal('show');
            });
        </script>
    @endif
@endpush

