@extends('layouts.app')

@section('title', 'Asro Inventory - Platform Manajemen Inventaris Pintar No. 1 di Indonesia')

@section('content')
    @include('partials.hero')
    @include('partials.stats')
    @include('partials.features')
    @include('partials.workflow')
    @include('partials.integrations')
    @include('partials.testimonials')
    @include('partials.cta')
    @include('partials.footer')
@endsection

@push('modals')
    @include('partials.modal-demo')
@endpush
