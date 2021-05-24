<!-- GOOGLE MODAL -->
<div class="modal fade google" id="sheets">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Acesse a planilha de Recuperação</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>

            @if(session()->get('sheet'))

                <div class="col-12 mt-4 text-center">
                    <div class="btn-group">

                        <div class="mr-3">
                            <a class='waves-effect btn btn-success' href='https://docs.google.com/spreadsheets/d/{{session()->get('sheet')->sheet_id ?? null}}' target="_blank" data-toggle="tooltip" data-placement="top" title="Relatório de Métricas">Acessar Planilha</a>
                        </div>

                        <div>
                            <form action="{{ route('sheets.destroy', session()->get('sheet')->id)}}" onsubmit="return confirm('Tem certeza que você quer deletar a planilha?')" method="POST" data-toggle="tooltip" data-placement="top" title="Deletar Planilha">
                                @csrf
                                @method('DELETE')
                                <button class="waves-effect btn btn-danger fas fa-trash" title="Delete"></button>
                            </form>
                        </div>

                    </div>
                    <div class="col-12 mt-2 text-center">
                        <i class=" fas fa-check mr-2"></i><span>Criada {{session()->get('sheet')->created_at->diffForHumans()}}</span>
                    </div>
                </div>



            @endif

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mb-0" data-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>

{{--<style>--}}
{{--    .modal-facebook{--}}
{{--        height: 40vh;--}}
{{--        overflow-y: auto;--}}
{{--    }--}}
{{--</style>--}}
