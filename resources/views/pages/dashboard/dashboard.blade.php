@extends('pages.dashboard._layout')

@section('title', trans('pages/general.dashboard'))
@section('mobile_dashboard', 'menu--active')
@section('side_dashboard', 'side-menu--active')

@section('style')
@endsection

@section('breadcrumb')
    <div class="grid grid-cols-12 gap-6">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="{{ route('dashboard.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="#" class="breadcrumb--active">{{ trans('pages/general.dashboard') }}</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/general.dashboard') }}
        </h2>
    </div>
@endsection

@section('js')
@endsection

