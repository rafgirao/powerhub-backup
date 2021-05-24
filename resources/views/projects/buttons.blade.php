<div style='display: flex; justify-content: flex-start'>
    <a class='waves-effect btn btn-sm btn-info fas fa-chart-bar' href='{{route('projects.show', $project->uuid)}}' target="_self" data-toggle="tooltip" data-placement="top" title="Relatório de Métricas"></a>

    <a class='waves-effect btn btn-sm btn-primary ni ni-book-bookmark' href='{{route('projects.conception', $project->uuid)}}' target="_self" data-toggle="tooltip" data-placement="top" title="Visualizar Concepção"></a>
    @if(isset($project->getProjectsDet->where('key_type', 'App\Sheet')->first()->keyable))
        <a class='waves-effect btn btn-sm btn-success fab fa-google-drive' href='{{route('sheets.index', ['scope' => 'drive','project' => $project->id])}}' target="_self" data-toggle="tooltip" data-placement="top" title="Acessar planilha de Vendas"></a>
    @else
        <a class='waves-effect btn btn-sm btn-outline-success fab fa-google-drive' href='{{route('sheets.index', ['scope' => 'drive','project' => $project->id])}}' target="_self" data-toggle="tooltip" data-placement="top" title="Criar planilha de Vendas"></a>
    @endif

    <a class='waves-effect btn btn-sm btn-warning fa fa-pen' href='{{route('projects.edit', $project->id)}}' target="_self" data-toggle="tooltip" data-placement="top" title="Editar Projeto"></a>

    <form action="{{ route('projects.destroy', $project->id) }}" onsubmit="return confirm('Tem certeza que você quer deletar o projeto?')" method="POST" data-toggle="tooltip" data-placement="top" title="Deletar Projeto">
        @csrf
        @method('DELETE')
        <button class="waves-effect btn btn-sm btn-danger fas fa-trash" title="Delete"></button>
    </form>
</div>
