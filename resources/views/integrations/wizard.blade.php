<!-- WIZARD MODAL -->
<div class="modal fade wizard" id="wizard">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
                {{--    <div class="container">--}}
                <div class="header-body text-center mb-7">
                    <h1 class="text-white">{{ __('Bem-Vindo ao PowerHub.') }}</h1>
                    <p class="text-lead text-light mt-3 mb-0">
                        {{ __('Para começar, aperte no botão abaixo e escolha uma integração para cadastrar...') }}
                        @include('alerts.migrations_check')
                    </p>
                    <button class="btn btn-success mt-3" data-dismiss="modal" type="button">Cadastrar uma Integração</button>
                </div>
            </div>
        </div>
    </div>
</div>
