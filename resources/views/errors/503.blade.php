@extends('errors::minimal')

@section('title', __('Serviço não disponível'))
@section('code', '503')
@section('message', __('Serviço não disponível'))


@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">{{ __('Erro 503') }}</h1>
                        <p class="text-lead text-white">{{ __('Oppps... Estamos em manutenção...') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <!-- Page content -->
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card card-profile bg-secondary mt-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <img src="{{ asset('argon') }}/img/brand/LogoPowerHub.svg" class="rounded-circle border-secondary">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-7 px-5">
                        <div class="text-center mb-4">
                            <h3>{{ 'Mas não se preocupe, voltaremos daqui a pouco...' }}</h3>
                        </div>
{{--                        <div class="text-center">--}}
{{--                            <button type="button" onclick='window.location="{{ url()->previous() }}"' class="btn btn-primary mt-2">{{ __('Aperte para Retornar') }}</button>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
