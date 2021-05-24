@extends('layouts.app', [
    'parentSection' => 'sales',
    'elementName' => 'sales'
])

@section('content')
    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs')
            @slot('title')
                {{--                {{ __('Produtos') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('sales') }}">{{ __('Vendas') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Todas as Vendas') }}</li>
        @endcomponent
        @include('components.alert',['alert' => $alert])
        @include('components.errors',['error' => $errors])
        @include('components.success',['success' => $success])
    @endcomponent
    <div class="container-fluid mt--6">
        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h3 class="mb-0">Todas as Vendas</h3>
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
                                    <select name="status_filter" id="status_filter" class="form-control">
                                        <option value="">Selecione o Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{$status}}">{{(new \App\Sale())->getSaleStatus($status)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                <div class="form-group">
                                    <select name="product_filter" id="product_filter" class="product_filter form-control">
                                        <option></option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-2 col-xl-2">
                                <div class="form-group">
                                    <select name="payment_filter" id="payment_filter" class="form-control">
                                        <option value="">Selecione a F. Pgto</option>
                                        @foreach($payments as $payment)
                                            <option value="{{$payment}}">{{$payment}}</option>
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
                        <table id="order_table" class="table text-nowrap key-buttons table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th>Ação</th>
                                <th>Transação</th>
                                <th>Status</th>
                                <th>Comprador</th>
                                <th>Produto</th>
                                <th>Data</th>
                                <th>Comissão</th>
                                <th>F. Pgto</th>
                                <th>T. Pgto</th>
                                <th>Preço</th>
                                <th>M. Pgto</th>
                                <th>Recorrência</th>
                                <th>Garantia</th>
                                <th>Parcela</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Vendedor</th>
                                {{--                                <th>C. Moeda</th>--}}
                                {{--                                <th>P. Moeda</th>--}}
                                {{--                                            <th>Account</th>--}}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/quill/dist/quill.core.css">
@endpush

@push('js')
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js|https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}
    <script src="{{ asset('argon') }}/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    {{--    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>--}}
    <script src="{{ asset('argon') }}/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

    <script src="{{ asset('argon') }}/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/nouislider/distribute/nouislider.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/quill/dist/quill.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/dropzone/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script>

        $(document).ready(function () {

            $('.product_filter').select2({
                placeholder: 'Selecione um Produto',
                allowClear: true
            });

            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                dateFormat: 'yyyy-mm-dd',
                // format: "dd/mm/yyyy",
                autoclose: true
            });

            load_data();

            function load_data(from_date = '', to_date = '', status_filter = '', product_filter = '', payment_filter = '') {

                let table =  $('#order_table').DataTable({
                    order: [[ 5, "desc" ]],
                    processing: true,
                    serverSide: true,
                    dom:"<'row'<'col-6 col-sm-6'B><'col-6 col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-4'p>>",
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                    buttons: [
                        {extend: 'copy', text: '<i class="fa fa-copy w-100"></i>'},
                        // {extend: 'excel', text: '<i class="fa fa-file-excel-o"></i>'},
                        {extend: 'csv', text: '<i class="fa fa-file-csv"></i>'},
                        // {extend: 'print', text: 'Imprimir'},
                        // {extend: 'colvis', text: '<i class="fa fa-columns w-100"></i>'},
                    ],
                    // language: [
                    //     {url:'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json'}
                    // ],
                    ajax: {
                        url: '{{ route("sales", ['act' => session()->get('account')->id]) }}',
                        data: {from_date: from_date, to_date: to_date, status_filter: status_filter, product_filter: product_filter, payment_filter: payment_filter},
                        error: function()
                        {
                            alert('Não foi possível retornar resultados. Por favor, selecione um filtro ou intervalo de datas diferente...');
                        },
                    },
                    responsive: true,
                    autoWidth: false,
                    columns: [
                        {data: 'action', name: 'Ações'},
                        {data: 'transaction', name: 'transaction'},
                        {data: 'br_status', name: 'br_status'},
                        {data: 'first_name', name: 'first_name'},
                        {data: 'product_name', name: 'product_name'},
                        {data: 'purchase_date_for_humans', name: 'purchase_date'},
                        {data: 'br_commission', name: 'br_commission'},
                        {data: 'payment_type', name: 'payment_type'},
                        {data: 'payment_method', name: 'payment_method'},
                        {data: 'br_price', name: 'br_price'},
                        {data: 'payment_mode', name: 'payment_mode'},
                        {data: 'recurrence_number', name: 'recurrence_number'},
                        {data: 'warranty_refund', name: 'warranty_refund'},
                        {data: 'installments_number', name: 'installments_number'},
                        {data: "email", name: 'email'},
                        {data: 'phone_number', name: 'phone_number'},
                        {data: 'affiliate', name: 'affiliate'},
                        // {data: 'commission_currency', name: 'commission_currency'},
                        // {data: 'price_currency', name: 'price_currency'},
                        /*                                {data: 'account', name: 'account'},*/

                    ],
                    initComplete: function () {
                        $('.dataTables_filter input[type="search"]').css({'height': '38px'});
                    }
                });
            }

            $('#filter').click(function () {
                let status_filter = $('#status_filter').val();
                let product_filter = $('#product_filter').val();
                let payment_filter = $('#payment_filter').val();
                let from_date = $('#from_date').val();
                let to_date = $('#to_date').val();

                if (from_date !== '' && to_date !== '') {
                    $('#order_table').DataTable().destroy();
                    load_data(from_date, to_date, status_filter, product_filter, payment_filter);
                } else {
                    alert('Ambas as datas são necessárias');
                }

                $('.product_filter').select2("destroy").select2({
                    placeholder: 'Selecione um Produto',
                    allowClear: true
                });

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

                $('#status_filter').val('');
                $('#product_filter').val('');
                $('#payment_filter').val('');

                $('#order_table').DataTable().destroy();
                load_data();
            });

        });

    </script>
@endpush


