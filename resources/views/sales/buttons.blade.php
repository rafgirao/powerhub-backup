@if($phoneNumber)
<div style="display: flex; justify-content: flex-start">
{{--    <a class="waves-effect btn btn-sm btn-primary fa fa-search mr-1" data-value="{{$id}}" href="{{$detailsUrl}}"></a>--}}
    <a class="btn btn-sm btn-success fab fa-whatsapp mr-1" data-value="{{$id}}" href="{{$whatsUrl}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Enviar WhatsApp"></a>
</div>
@else
<div style="display: flex; justify-content: flex-start">
{{--    <a class="waves-effect btn btn-sm btn-primary fa fa-search mr-1" data-value="{{$id}}" href="{{$detailsUrl}}"></a>--}}
    <a class="btn btn-sm btn-secondary fab fa-whatsapp mr-1" data-value="{{$id}}"></a>
</div>
@endif
