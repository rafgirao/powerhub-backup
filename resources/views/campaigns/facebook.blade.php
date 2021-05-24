@extends('layouts.app', [
    'parentSection' => 'campaigns',
    'elementName' => 'facebook'
])

@section('content')
    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs')
            @slot('title')
                {{--                {{ __('Produtos') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('campaigns.facebook') }}">{{ __('Campanhas') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Todas as Campanhas') }}</li>
        @endcomponent
        @include('components.alert',['alert' => $alert])
        @include('components.errors',['errors' => $errors])
        @include('components.success',['success' => $success])
    @endcomponent

    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Todas as Campanhas</h3>
                        {{--                        <p class="text-sm mb-0">--}}
                        {{--                            This is an exmaple of datatable using the well known datatables.net plugin. This is a minimal setup in order to get started--}}
                        {{--                            fast.--}}
                        {{--                        </p>--}}
                    </div>
                    <div class="card-body">

                        <div class="row mb-sm-6 mb-md--4 mb-lg--4 mb-xl--4">

                            <div class="col-12 col-md-12 col-lg-4 col-xl-4 input-daterange datepicker">
                                <form class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>
                                                </div>
                                            </div>
                                            <input type="text" name="from_date" id="from_date" class="form-control fc-datepicker" placeholder="" value="{{(date('Y-m-d', strtotime("-7 days")))}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg>
                                                </div>
                                            </div>
                                            <input type="text" name="to_date" id="to_date" class="form-control fc-datepicker" placeholder="" value="{{(date('Y-m-d', strtotime("0 days")))}}">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                <div class="form-group">
                                    <select name="account_filter" id="account_filter" class="form-control">
                                        <option value="">Todas as Contas</option>
                                        @foreach($fbAdAccounts as $key => $fbAdAccount)
                                            <option value="{{$fbAdAccount}}">{{$key}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                <div class="form-group">
                                    <select name="status_filter" id="status_filter" class="form-control">
                                        <option value="" selected>Todos os Status</option>
                                        <option value="ACTIVE">ATIVA</option>
                                        <option value="PAUSED">PAUSADA</option>
{{--                                        <option value="DELETED">DELETADA</option>--}}
                                        <option value="ARCHIVED">ARQUIVADA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                <div class="form-group">
                                    <select name="event_filter" id="event_filter" class="js-basic-single form-control">
                                        <option></option>
                                        @foreach($insights as $key => $insight)
                                            <option value="{{$insight->name}}">{{$insight->getIntegrationDet->description}} - {{$insight->br_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                <div class="btn-group btn-block">
                                    <button type="button" name="filter" id="filter" class="btn btn-primary w-100">Aplicar </button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-primary w-100">Limpar </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-3">
                        <table id="fb_table" class="table table-bordered text-nowrap key-buttons">
                            <thead class="thead-light">
                            <tr>
                                <th>Campanha</th>
                                <th>Status</th>
                                <th>Invest.</th>
{{--                                <th>Result.</th>--}}
{{--                                <th>Custo</th>--}}
{{--                                <th>Valor</th>--}}
                                <th>Alcance</th>
                                <th>Impres.</th>
                                <th>Cliques</th>
                                <th>Freq</th>
                                <th>CPM</th>
                                <th>CPC</th>
                                <th>CTR</th>
                                <th id="fbEvent" class="notToggleVis" hidden>EVENTO</th>
{{--                                <th class="notToggleVis" hidden>VALOR</th>--}}
                                <th id="fbCost" class="notToggleVis" hidden>CUSTO</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        @include('layouts.footers.auth')
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">

{{--    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/select2/dist/css/select2.min.css">--}}
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/quill/dist/quill.core.css">
@endpush

@push('js')
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js|https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}
{{--    <script src="{{ asset('argon') }}/vendor/select2/dist/js/select2.min.js"></script>--}}
    <script src="{{ asset('argon') }}/vendor/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
{{--    <script src="{{ asset('argon') }}/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>--}}
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

    <!--INTERNAL Form Advanced Element -->
{{--    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>--}}

    <script src="{{ asset('argon') }}/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/quill/dist/quill.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
{{--    <script src="https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"></script>--}}

    <script>

        $(document).ready(function () {

            $('.js-basic-single').select2({
                placeholder: 'Selecione um Evento',
                allowClear: true
            });

            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                dateFormat: 'yyyy-mm-dd',
                // format: "dd/mm/yyyy",
                autoclose: true
            });

            load_data();

            function load_data(from_date = '', to_date = '', status_filter = '', event_filter = '', account_filter = '') {

                let fbColumns = [
                        {data: 'provider_campaign_name', name: 'provider_campaign_name', visible: true, maxWidth:5},
                        {data: 'status', name: 'status', visible: true},
                        {
                            data: "spend",
                            className: 'text-right',
                            render: function (data, type, row, meta) {
                                return row.spend ? row.currency + " " + parseFloat(row.spend).toLocaleString('pt-BR', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''
                            }
                        },
                        {data: 'reach', name: 'reach', visible: true, render: $.fn.dataTable.render.number( '.', ',', 0, '' ), className: 'text-right'},
                        {data: 'impressions', name: 'impressions', visible: true, render: $.fn.dataTable.render.number( '.', ',', 0, '' ), className: 'text-right'},
                        {data: 'clicks', name: 'clicks', visible: true, render: $.fn.dataTable.render.number( '.', ',', 0, '' ), className: 'text-right'},
                        {data: 'frequency', name: 'frequency', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ), className: 'text-right'},
                        {
                            data: "cpm",
                            className: 'text-right',
                            render: function (data, type, row, meta) {
                                return row.cpm ? row.currency + " " + parseFloat(row.cpm).toLocaleString('pt-BR', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''

                            }
                        },
                        // {data: 'cpm', name: 'cpm', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ), className: 'text-right'},
                        {

                            data: "cpc",
                            className: 'text-right',
                            render: function (data, type, row, meta) {
                                return row.cpc ? row.currency + " " + parseFloat(row.cpc).toLocaleString('pt-BR', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''
                            }
                        },

                        // {data: 'cpc', name: 'cpc', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ), className: 'text-right'},
                        {data: 'ctr', name: 'ctr', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '', '%' ), className: 'text-right'},
                    ];

                // if ($('#event_filter').val() === null){
                //     // fbColumns.pop();
                //     // fbColumns.pop();
                // };

                if($('#event_filter').val() != null && $('#event_filter').val() != ''){

                    fbColumns.push({name: 'event', data: 'event', render: $.fn.dataTable.render.number( '.', ',', 0, '' ), className: 'text-right'});

                    fbColumns.push({
                        data: "event_cost",
                        className: 'text-right',
                        render: function (data, type, row, meta) {
                            return row.event_cost ? row.currency + " " + parseFloat(row.event_cost ? row.event_cost : 0).toLocaleString('pt-BR', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''

                        }
                    });
                };

                let fbDataTable = $('#fb_table').DataTable({
                    order: [[ 2, "desc" ]],
                    processing: true,
                    serverSide: true,
                    dom:"<'row'<'col-6 col-sm-6'B><'col-6 col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'p>>",
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                    buttons: [
                        {extend: 'copy', text: '<i class="fa fa-copy w-100"></i>'},
                        {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i>'},
                        {extend: 'csv', text: '<i class="fa fa-file-csv"></i>'},
                        // {extend: 'print', text: 'Imprimir'},
                        {extend: 'colvis', text: '<i class="fa fa-columns w-100"></i>'},
                    ],
                    // language: [
                    //     {url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json'}
                    // ],
                    language: {
                        "decimal": ",",
                        "thousands": "."
                    },
                    ajax: {
                        url: '{{ route("campaigns.facebook", ['act' => session()->get('account')->id]) }}',
                        data: {from_date: from_date, to_date: to_date, status_filter: status_filter, event_filter: event_filter, account_filter: account_filter},
                        // error: function()
                        // {
                        //     alert('Não foi possível retornar resultados. Por favor, selecione um filtro ou intervalo de datas diferente...');
                        // },
                    },

                    responsive: false,
                    autoWidth: false,
                    columns: fbColumns,

                    initComplete: function () {
                        $('.dataTables_filter input[type="search"]').css({'height': '38px'});
                    }
                });
            }

            let table = document.getElementById('fb_table'),
                rows = table.rows;

            $('#filter').click(function () {
                let status_filter = $('#status_filter').val();
                let event_filter = $('#event_filter').val();
                let account_filter = $('#account_filter').val();
                let from_date = $('#from_date').val();
                let to_date = $('#to_date').val();

                let p = document.getElementsByTagName('th');
                let myEvent;

                for (let i = 0; i < p.length; i++) {
                    if (p[i].id === 'fbEvent' ) {
                        myEvent = p[i];
                        break;
                    }
                }

                let q = document.getElementsByTagName('th');
                let myCost;

                for (let u = 0; u < q.length; u++) {
                    if (q[u].id === 'fbCost' ) {
                        myCost = q[u];
                        break;
                    }
                }

                if($('#event_filter').val() === null ||  $('#event_filter').val() === '') {
                    myEvent.setAttribute("hidden", 'hidden');
                    myCost.setAttribute("hidden", 'hidden');
                }

                if($('#event_filter').val() !== null &&  $('#event_filter').val() !== '') {

                    myEvent.removeAttribute("hidden");
                    myEvent.innerHTML = event_filter;

                    myCost.removeAttribute("hidden");
                    myCost.innerHTML = 'Custo por ' + event_filter;

                };

                if (from_date !== '' && to_date !== '') {
                    $('#fb_table').empty().DataTable().destroy();
                    load_data(from_date, to_date, status_filter, event_filter, account_filter);
                } else {
                    alert('Ambas as datas são necessárias');
                }

            });


            $('#refresh').click(function () {

                let today = new Date();
                let lastWeek = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);

                function prepareDate(date){
                    let dd = String(date.getDate()).padStart(2, '0');
                    let mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
                    let yyyy = date.getFullYear();
                    return yyyy + '-' + mm + '-' + dd;
                }

                today = prepareDate(today);
                lastWeek = prepareDate(lastWeek);


                $('#from_date').val(lastWeek);
                $('#to_date').val(today);

                $('#status_filter').val(null);
                $('#event_filter').val(null);
                $('#account_filter').val(null);

                let p = document.getElementsByTagName('th');
                let myEvent;

                for (i = 0; i < p.length; i++) {
                    if (p[i].id === 'fbEvent' ) {
                        myEvent = p[i];
                        break;
                    }
                }
                myEvent.setAttribute("hidden", true);
                myEvent.innerHTML = "EVENTO";

                let q = document.getElementsByTagName('th');
                let myCost;

                for (u = 0; u < q.length; u++) {
                    if (q[u].id === 'fbCost' ) {
                        myCost = q[u];
                        break;
                    }
                }
                myCost.setAttribute("hidden", true);
                myCost.innerHTML = event_filter;

                $('.js-basic-single').select2("destroy").select2({
                    placeholder: 'Selecione um Evento',
                    allowClear: true
                });

                $('#fb_table').empty().DataTable().destroy();
                load_data();
            });

        });

    </script>

@endpush


