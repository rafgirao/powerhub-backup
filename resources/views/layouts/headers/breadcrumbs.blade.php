<div class="row align-items-center py-4 mb-5">
    <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">{{ $title }}</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
                {{ $slot }}
            </ol>
        </nav>
    </div>
{{--    @if (isset($calendar))--}}
{{--        {{ $calendar }}--}}
{{--    @else--}}
{{--        <div class="col-lg-6 col-5 text-right">--}}
{{--            <a href="#" class="btn btn-sm btn-neutral">{{ __('New') }}</a>--}}
{{--            <a href="#" class="btn btn-sm btn-neutral">{{ __('Filters') }}</a>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    {{dd($stats->currencies)}}--}}

    <div class="col-sm-12 col-lg-6 text-right">
        <div class="btn-group">
            @if(isset($reportType) and ($reportType !== 'dashboard'))
                <div>
                    <button type="button" name="ShareButton" id="shareButton" onclick="copy()" class="btn btn-secondary ml-4"><i class="fa fa-link" data-toggle="tooltip" data-placement="top" title="Copiar Link"></i></button>
                </div>

                <div>
                    <button type="button" name="PdfButton" id="PdfButton" onclick="pdf()" class="btn btn-secondary ml-4"><i class="fas fa-file-pdf" data-toggle="tooltip" data-placement="top" title="Gerar PDF"></i></button>
                </div>

<!--                Pdf Backup-->
{{--                <div>--}}
{{--                    <button type="button" name="pdfDownloader" id="pdfDownloader" class="btn btn-secondary ml-4">Gerar Pdf</button>--}}
{{--                </div>--}}
            @endif

            @if (isset($stats))

                @if(isset($stats->currency))

                    @if((isset($reportType) and ($reportType === 'performance' or $reportType === 'debriefing' or $reportType === 'dashboard')))
                    <div class="dropdown ml-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $stats->currency }}
                        </button>
                        @if(isset($stats->currencies))
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($stats->currencies as $key => $currency)
                                    @if(isset($project))
                                        @if($reportType === 'performance')
                                            <form method="get" action="{{ route('projects.show', $project->uuid)}}" autocomplete="off">
                                        @elseif($reportType === 'debriefing')
                                            <form method="get" action="{{ route('debriefings.show', $project->uuid)}}" autocomplete="off">
                                        @endif
                                    @else
                                        <form method="get" action="{{ route('home')}}" autocomplete="off">
                                    @endif
{{--                                        @csrf--}}
                                        <input class="" form-control="" type="hidden" id="currency-{{$key}}" name="currency" value="{{$currency}}" required>
                                        <button type="submit" class="dropdown-item">{{$currency}}</button>
                                    </form>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @endif

                @endif

                @if(isset($stats->datePreset))
                    <div class="dropdown ml-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('validation.'.$stats->datePreset)
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if(isset($stats->datePreset))
                                @foreach($stats->datePresets as $key => $datePreset)
                                    <form method="post" action="{{ route('home')}}" autocomplete="off">
                                        @csrf
                                        <input class="" form-control="" type="hidden" id="datePreset-{{$key}}" name="datePreset" value="{{ $datePreset }}" required>
                                        <button type="submit" class="dropdown-item">@lang('validation.'.$datePreset)</button>
                                    </form>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>
</div>

@push('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.4/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

{{--    Pdf Backup--}}
{{--    <script>--}}

{{--        $(document).ready(function(){--}}

{{--            //pdf 다운로드--}}
{{--            $("#pdfDownloader").click(function(){--}}

{{--                html2canvas(document.body, {--}}
{{--                    useCORS: true,--}}

{{--                    onrendered: function(canvas) {--}}

{{--                        var imgData = canvas.toDataURL('image/png');--}}
{{--                        // console.log('Report Image URL: '+imgData);--}}
{{--                        var doc = new jsPDF('p', 'mm', [400, 1000]); //210mm wide and 297mm high--}}

{{--                        doc.addImage(imgData, 'PNG', 0, 0);--}}
{{--                        doc.save('sample.pdf');--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        })--}}

{{--    </script>--}}

    <script type="text/javascript">
        function copy() {
            $("body").append('<input id="copyURL" type="text" value="" />');
            $("#copyURL").val(window.location.href).select();
            document.execCommand("copy");
            $("#copyURL").remove();
        }

        function pdf() {
            let url = window.location.href;
            console.log(url)
            window.open('https://pdf.powerhub.app?pdf.pageRanges=1&pdf.format=A4&pdf.width=1600&url='+url, '_blank');
        }
    </script>


@endpush
