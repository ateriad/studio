@extends('pages.dashboard._layout')

@section('title', trans('pages/general.dashboard'))
@section('mobile_studio', 'menu--active')
@section('side_studio', 'side-menu--active')

@section('style')
@endsection

@section('breadcrumb')
    <div class="grid grid-cols-12 gap-6">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="{{ route('dashboard.index') }}" class="">{{ trans('pages/general.home') }}</a>
            <i data-feather="chevron-right" class="breadcrumb__icon"></i>
            <a href="#" class="breadcrumb--active">{{ trans('pages/general.studio') }}</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/general.studio') }}
        </h2>
    </div>
@endsection

@section('js')
@endsection

