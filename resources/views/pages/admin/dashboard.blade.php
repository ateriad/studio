@extends('pages.admin._layout')

@section('title', trans('pages/general.dashboard'))
@section('mobile_dashboard', 'menu--active')
@section('side_dashboard', 'side-menu--active')

@section('css')
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('admin.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/general.dashboard') }}</a>
    </div>
@endsection

@section('content')

@endsection

@section('js')
@endsection

