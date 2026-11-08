@extends('layouts.dashboard')

@section('title', 'Dashboard ' . auth()->user()->role->name)

@section('breadcrumb')
<ol class="flex items-center space-x-2 text-sm">
    <li><a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Beranda</a></li>
    <li class="text-gray-400">›</li>
    @if(strtolower(auth()->user()->role->name) == 'audit')
    <li class="text-gray-900 font-medium">Dashboard Audit (Overview)</li>
    @else
    <li class="text-gray-900 font-medium">Dashboard {{ auth()->user()->role->name }} (Overview)</li>
    @endif
</ol>
@endsection

@section('content')
@php
    $userRole = strtolower(auth()->user()->role->name);
@endphp

{{-- AUDIT DASHBOARD --}}
@if($userRole == 'audit')
@include('homepage.partials.audit-dashboard')

{{-- SUPER ADMIN DASHBOARD --}}
@elseif($userRole == 'super admin')
@include('homepage.partials.superadmin-dashboard')

{{-- KEPALA GUDANG DASHBOARD --}}
@elseif($userRole == 'kepala gudang')
@include('homepage.partials.kepalagudang-dashboard')

{{-- PEGAWAI DASHBOARD --}}
@elseif($userRole == 'pegawai')
@include('homepage.partials.pegawai-dashboard')

{{-- HR DASHBOARD --}}
@elseif($userRole == 'hr')
@include('homepage.partials.hr-dashboard')

{{-- DEFAULT --}}
@else
<div class="text-center py-20">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard {{ ucwords($userRole) }}</h2>
    <p class="text-gray-600 mt-2">Content untuk role {{ ucwords($userRole) }} belum tersedia</p>
</div>
@endif

@endsection
