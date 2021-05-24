<!-- ACTIVE CAMPAIGN MODAL -->
<div class="modal fade activecampaign" id="activecampaign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Insira os dados da API da sua conta Active Campaign</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form name="acIntegration" action="{{route('integrations.create.do')}}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="providerName" id="providerName" value="Active Campaign">
                    <input type="hidden" class="form-control" name="providerType" id="providerType" value="AutoResponder">
                    <input type="hidden" class="form-control" name="description" id="description" value="AC 01">
                    <div class="form-group">
                        <label for="acUrl" class="form-label">URL</label>
                        <input type="text" class="form-control" name="acUrl" id="acUrl" placeholder="Informe a API URL da sua conta" value="{{$acCredentials->acUrl}}">
                    </div>
                    <div class="form-group">
                        <label for="acToken" class="form-label">Key</label>
                        <input type="text" class="form-control" name="acToken" id="acToken" placeholder="Informe a sua API Key" value="{{$acCredentials->acToken}}">
                    </div>
                    <div>
                        <a href="https://help.activecampaign.com/hc/pt-br/articles/207317590-Introdu%C3%A7%C3%A3o-%C3%A0-API#how-to-obtain-your-activecampaign-api-url-and-key" target="_blank">Aperte aqui para saber como pegar sua chave de API do Active Campaign</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mt-4 mb-0">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
