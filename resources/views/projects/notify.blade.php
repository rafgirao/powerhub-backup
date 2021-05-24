<!-- notify CAMPAIGN MODAL -->
<div class="modal fade notify" id="notify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Insira os dados da API HotConnect2 da sua conta notify</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form name="acIntegration" action="{{route('integrations.create.do')}}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="providerName" id="providerNamenotify" value="notify">
                    <input type="hidden" class="form-control" name="providerType" id="providerTypenotify" value="PaymentGateway">
                    <input type="hidden" class="form-control" name="description" id="descriptionnotify" value="notify 01">
                    <div class="form-group">
                        <label for="clientId" class="form-label">Client Id</label>
                        <input type="text" class="form-control" name="clientId" id="clientId" placeholder="Informe a sua Client Secret" value="{{$notifyCredentials->clientId}}">
                    </div>
                    <div class="form-group">
                        <label for="clientSecret" class="form-label">Client Secret</label>
                        <input type="text" class="form-control" name="clientSecret" id="clientSecret" placeholder="Informe a sua Client Secret" value="{{$notifyCredentials->clientSecret}}">
                    </div>
                    <div class="form-group">
                        <label for="basic" class="form-label">Basic</label>
                        <input type="text" class="form-control" name="basic" id="basic" placeholder="Informe a sua chave Basic (incluindo a palavra 'Basic' no início)" value="{{$notifyCredentials->basic}}">
                    </div>
                    <div>
                        <label for="webhook" class="form-label">Agora insira Webhook abaixo na sua conta da notify</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="webhook" id="webhook" readonly value="https://powerhub.app/webhook?act={{session()->get('account')->uuid}}">
                        <div class="input-group-append">
                            <button class="btn btn-info" data-clipboard-target="#webhook" type="button"><i class="fa fa-copy" data-toggle="tooltip" data-placement="top" title="Copiar Link"></i></button>
                        </div>
                    </div>
                    <div>
                        <a href="https://blog.notify.com/pt-br/hotconnect-e-webhook/" target="_blank">Aperte aqui para saber como pegar sua chave de API do HotConnect2 e configurar a Webhook</a>
                    </div>

                    <label class="custom-toggle">
                        <input type="checkbox" name="adAccounts[{{$key}}][checkbox]" {{ (!empty($fbAdAccountStatus->where('value', $fbAdAccount->id)->first()->status) ?
                                                    ($fbAdAccountStatus->where('value', $fbAdAccount->id)->first()->status == 1 ? 'checked' : '')
                                                    : '' ) }}>
                        <span class="custom-toggle-slider rounded-circle" data-label-off="Inat" data-label-on="Ativ"></span>
                    </label>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mt-4 mb-0">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('clipboard') }}/dist/clipboard.min.js"></script>
    <script>
        var clipboard = new ClipboardJS('.btn');

        clipboard.on('success', function (e) {
            console.log(e);
        });

        clipboard.on('error', function (e) {
            console.log(e);
        });
    </script>
@endpush
