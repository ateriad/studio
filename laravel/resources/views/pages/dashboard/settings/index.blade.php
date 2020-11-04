@extends('pages.dashboard._layout')

@section('title', 'settings')
@section('mobile_settings', 'menu--active')
@section('side_settings', 'side-menu--active')

@section('style')
@endsection

@section('breadcrumb')
    <div class="grid grid-cols-12 gap-6">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="{{ route('dashboard.settings') }}" class="">{{ trans('pages/general.home') }}</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="#" class="breadcrumb--active">settings</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
           
        </h2>
    </div>
@endsection

@section('js')
@endsection

