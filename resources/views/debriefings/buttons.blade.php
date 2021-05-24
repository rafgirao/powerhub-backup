<div style='display: flex; justify-content: flex-start'>

    <a class='waves-effect btn btn-sm btn-primary fa fa-eye' href='{{route('debriefings.show', $project->uuid)}}' target="_self" data-toggle="tooltip" data-placement="top" title="Visualizar Debriefing"></a>
    <a class='waves-effect btn btn-sm btn-warning fa fa fa-pen' href='{{route('debriefings.edit', $project->id)}}' data-toggle="tooltip" data-placement="top" title="Editar Debriefing"></a>
{{--    <a class='waves-effect btn btn-sm btn-warning fa fa-file-pdf mr-1' data-value='{{$project->id}}' href='{{route('debriefings.makePdf', $project->id)}}' target="_blank"></a>--}}
</div>
