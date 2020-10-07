@extends('pages.admin._layout')

@section('title', trans('pages/admin/assets.assets_list'))

@section('mobile_assets', 'menu--active')
@section('mobile_assets_index', 'menu--active')
@section('mobile_assets_sub', 'menu__sub-open')
@section('side_assets', 'side-menu--active')
@section('side_assets_index', 'side-menu--active')
@section('side_assets_sub', 'side-menu__sub-open')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable/css/datatables.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('admin.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/admin/assets.assets_list') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/admin/assets.assets_list') }}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a class="button text-white bg-theme-1 shadow-md mr-2"
               href="{{ route('admin.assets.create') }}">
                {{ trans('pages/admin/assets.assets_create') }}
            </a>
        </div>
    </div>

    <div class="intro-y box p-5 mt-5 ">
        <div class="overflow-y-auto scrollbar-hidden">
            <table class="table table-striped stripe hover row-border" style="width:100%" id="datatable"
                   data-lang="{{  (app()->getLocale() != 'en') ? asset('vendor/datatable/' . app()->getLocale() . '.json'): '' }}"
                   data-action="{{ route('admin.assets.datatable') }}">
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
                    name: "path",
                    title: "آدرس",
                    render: function (data, type, row, meta) {
                        return row.path;
                    },
                    orderable: false,
                }, {
                    name: "categories",
                    title: "دسته ها",
                    render: function (data, type, row, meta) {
                        let html = '';
                        if (row.categories) {
                            $.each(row.categories, function (i, val) {
                                html += '<li>' + val['name'] + '</li>'
                            });
                        }

                        return html
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
                dom: "<'row'<'col-md-3 col-sm-12'l><'col-md-4 col-sm-12'i><'col-md-5 pull-left'B>r>" +
                    "<'table-scrollable't><'row'<'col-md-7 col-sm-12'p>>",
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

