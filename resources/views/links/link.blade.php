@extends('layouts.app', [
    'parentSection' => 'links',
    'elementName' => 'all'
])

@section('content')

    @component('layouts.headers.auth')
        @component('layouts.headers.breadcrumbs')
            @slot('title')
                {{--                {{ __('Projetos') }}--}}
            @endslot
            <li class="breadcrumb-item"><a href="{{ route('links.index') }}">{{ __('Deeplinks') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Todos os Deeplinks') }}</li>
        @endcomponent
        @include('components.alert',['alert' => $alert])
        @include('components.errors',['error' => $errors])
        @include('components.success',['success' => $success])
    @endcomponent

    @livewire('link')

@endsection


