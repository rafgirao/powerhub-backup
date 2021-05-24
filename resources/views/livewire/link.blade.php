 <div class="container-fluid mt--6">

    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('alert'))
            <div class="alert alert-default">
                {{ session('alert') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>



    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="mb-0">Todos os Deeplinks</h3>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" id="newDeeplink" wire:click="create" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">{{ __('Novo Deeplink') }}</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-3 mt-4">
                        <input class="form-control" wire:model="search" type="search" placeholder="Buscar" id="example-search-input">
                    </div>

                    <!-- Light table -->
                    <div class="table-responsive" data-toggle="list" data-list-values='["url", "project", "shortLink", "clicks"]'>
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 20%;" class="sort" data-sort="url">URL</th>
                                <th scope="col" style="width: 20%;" class="sort" data-sort="project">Projeto</th>
                                <th scope="col" style="width: 30%;" class="sort" data-sort="shortLink">Deeplink</th>
                                <th scope="col" style="width: 10%;" class="sort" data-sort="clicks">Cliques</th>
                                <th scope="col" style="width: 10%;">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($links as $key => $link)
                                    <tr wire:loading.class.delay="opacity-5">
                                        <td>
                                            <span class="url mb-0 text-sm" data-toggle="tooltip" data-placement="top" title="{{$link->url}}">{{substr($link->url, 0, 30)}}...</span>
                                        </td>
                                        <td class="project">
                                            {{$link->project ? $link->getProject->name : $link->project}}
                                        </td>
                                        <td class="shortLink">
                                            <input id="deeplink-{{$key}}" class="form-control input-lg" value="{{env('APP_URL').'/go/'.$link->short_link}}" readonly>
                                        </td>
                                        <td class="text-center">
                                            <span class="clicks">{{$link->clicks}}</span>
                                        </td>
                                        <td class="text-right">
                                            <div wire:ignore class="col-4 text-right">
                                                <button type="button" id="copyDeeplink-{{$key}}" data-clipboard-target="#deeplink-{{$key}}" class="waves-effect btn btn-sm btn-success mr-1"><i class="fa fa-link" data-toggle="tooltip" data-placement="top" title="Copiar Link"></i></button>
                                                <button type="button" onclick="window.open('{{env('APP_URL').'/go/'.$link->short_link}}')" id="viewDeeplink-{{$key}}" class="waves-effect btn btn-sm btn-info mr-1" ><i class="fas fa-external-link-square-alt" data-toggle="tooltip" data-placement="top" title="Ver Link"></i></button>
                                                <button type="button" wire:click="edit({{ $link->id }})" id="editDeeplink-{{$key}}" class="waves-effect btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-pen" data-toggle="tooltip" data-placement="top" title="Editar Link"></i></button>
                                                <button type="button" wire:click="destroy({{ $link->id }})" onclick="confirm('Você tem certeza?') || event.stopImmediatePropagation()" id="destroyDeeplink-{{$key}}" class="waves-effect btn btn-sm btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Deletar Link"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="5">
                                        <div class="font-weight-normal text-lg text-center py-5 opacity-6">
                                            <i class="fa fa-inbox" aria-hidden="true"></i>
                                            <span> Não foi encontrado nenhum registro...</span>
                                        </div>
                                    </td>
                                @endforelse
                                </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $links->links('vendor.pagination.powerhub', ['links' => $links])}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar novo Deeplink</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="url" class="form-control-label">URL de Destino</label>
                        <input type="text" class="form-control" name="url" id="url" placeholder="Informe a URL de destino" wire:model.laze="url">
                        <div>
                            @error('url') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>


                    <div class="form-group">

                        <div wire:ignore>
                            <label for="project" class="form-control-label">Selecione o Projeto (Opcional)</label>
                            <select wire:ignore wire:model.lazy="project" class="form-control" id="select2-dropdown">
                                <option value="">Selecione uma Opção</option>
                                @foreach($projects as $singleProject)
                                    <option value="{{ $singleProject->id }}" {{ $singleProject->id == $project ? 'selected' : ''}}>{{ $singleProject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="short_link">Informe o Slug do Deeplink</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">https://powerhub.app/go/</span>
                            </div>
                            <input type="text" class="form-control" name="short_link" id="short_link" aria-describedby="basic-addon3" wire:model.laze="short_link">
                        </div>
                        <div>
                            @error('short_link') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    @if($method === 'store')
                        <button type="button" wire:click.prevent="store()" class="btn btn-primary" data-dismiss="modal">Salvar Deeplink</button>
                    @elseif($method === 'update')
                        <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Editar Deeplink</button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
        @include('layouts.footers.auth')
</div>

@push('css')
{{--    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>--}}

@endpush

@push('js')

    <script src="{{ asset('argon') }}/vendor/list.js/dist/list.min.js"></script>

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


