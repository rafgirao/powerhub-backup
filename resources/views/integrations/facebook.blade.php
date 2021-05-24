<!-- FACEBOOK MODAL -->
<div class="modal fade facebook" id="facebook">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Escolha as Contas de Anúncio que você deseja acompanhar</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form name="acIntegration" action="{{route('integrations.create.do')}}" method="post" autocomplete="off">
                @csrf
                <div class="modal-facebook">
                    <input type="hidden" class="form-control" name="providerName" value="Facebook">
                    <input type="hidden" class="form-control" name="providerType" value="AdAccount">
                    <input type="hidden" class="form-control" name="description" value="FB 01">
                    <input type="hidden" class="form-control" name="fbToken" value="{{session()->get('fbToken')}}">
                    <input type="hidden" class="form-control" name="expiresIn" value="{{session()->get('expiresIn')}}">
                        <div class="form-group border border-light-3 rounded m-4" style="height: 40vh; overflow-y: auto;">
                            @if(session()->get('fbAdAccounts'))
                                <ul class="mt-4 mb-4" style="list-style-type:none;">
                                    @foreach(session()->get('fbAdAccounts') as $key => $fbAdAccount)
                                        <li>
                                            <input type="hidden" class="form-control" name="adAccounts[{{$key}}][description]" value="{{$fbAdAccount->name}}">
                                            <input type="hidden" class="form-control" name="adAccounts[{{$key}}][fbAdAccountId]" value="{{$fbAdAccount->id}}">
                                            <input type="hidden" class="form-control" name="adAccounts[{{$key}}][fbAdAccountTimezone]" value="{{$fbAdAccount->timezone_name}}">
                                            <input type="hidden" class="form-control" name="adAccounts[{{$key}}][fbAdAccountCurrency]" value="{{$fbAdAccount->currency}}">
                                            <label class="custom-toggle">
                                                <input type="checkbox" name="adAccounts[{{$key}}][checkbox]" {{ (!empty($fbAdAccountStatus->where('value', $fbAdAccount->id)->first()->status) ?
                                                    ($fbAdAccountStatus->where('value', $fbAdAccount->id)->first()->status == 1 ? 'checked' : '')
                                                    : '' ) }}>
                                                <span class="custom-toggle-slider rounded-circle" data-label-off="Inat" data-label-on="Ativ"></span>
                                            </label>
                                            <label for="fbAccount" class="form-label align-top"> {{$fbAdAccount->name}}</label>
                                        </li>
                                    @endforeach
                                </ul>

                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mb-0">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--<style>--}}
{{--    .modal-facebook{--}}
{{--        height: 40vh;--}}
{{--        overflow-y: auto;--}}
{{--    }--}}
{{--</style>--}}
