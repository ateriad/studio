@extends('pages.admin._layout')

@section('title', trans('pages/admin/assets.asset_categories_list'))

@section('mobile_asset_categories', 'menu--active')
@section('mobile_asset_categories_index', 'menu--active')
@section('mobile_asset_categories_sub', 'menu__sub-open')
@section('side_asset_categories', 'side-menu--active')
@section('side_asset_categories_index', 'side-menu--active')
@section('side_asset_categories_sub', 'side-menu__sub-open')

@section('style')
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('admin.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/admin/assets.asset_categories_list') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/admin/assets.asset_categories_list') }}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a class="button text-white bg-theme-1 shadow-md mr-2"
               href="{{ route('admin.asset-categories.create') }}">
                {{ trans('pages/admin/assets.asset_categories_create') }}
            </a>
        </div>
    </div>

    <div class="intro-y box p-5 mt-5 ">
        <div class="overflow-x-auto scrollbar-hidden">
            <table class="table table-striped hover" style="width:100%" id="datatable"
                   data-lang="{{  (app()->getLocale() != 'en') ? asset('vendor/datatable/' . app()->getLocale() . '.json'): '' }}"
                   data-action="{{ route('admin.asset-categories.datatable') }}">
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatable/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            const Cols = [
                {
                    name: "id",
                    title: "شناسه",
                    render: function (data, type, row, meta) {
                        return row.id;
                    },
                    orderable: true,
                    visible: false,
                }, {
                    name: "name",
                    title: "نام",
                    render: function (data, type, row, meta) {
                        return row.name;
                    },
                    orderable: false,
                }, {
                    name: "parent",
                    title: "والد",
                    render: function (data, type, row, meta) {
                        return row.parent;
                    },
                    orderable: false,
                },
            ];

            let tableElement = $("#datatable");
            let table = tableElement.DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                paging: true,
                scrollX: true,
                buttons: [],
                dom: "<'table_info'<l><r><i>><t><p>",
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
                order: [[0, "desc"]],
                language: {
                    url: tableElement.data('lang')
                },
                columns: Cols,
                ajax: {
                    type: 'POST',
                    dataType: "json",
                    url: tableElement.data('action'),
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')
                    },
                    dataSrc: function (response) {
                        return response.data;
                    }
                },
            });
        });
    </script>
@endsection
