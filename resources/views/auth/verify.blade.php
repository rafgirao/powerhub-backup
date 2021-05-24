@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Verifique seu endereço de e-mail') }}</small>
                        </div>
                        <div>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('Um novo link de verificação foi enviado ao seu endereço de e-mail.') }}
                                </div>
                            @endif

                            {{ __('Antes de prosseguir, verifique seu e-mail para um link de verificação.') }}

                            @if (Route::has('verification.resend'))
                                {{ __('Se você não recebeu o email') }}, <a href="{{ route('verification.resend') }}">{{ __('Clique aqui para solicitar outro') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
