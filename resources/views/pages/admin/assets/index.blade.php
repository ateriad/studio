@extends('pages.admin._layout')

@section('title', trans('pages/admin/assets.assets_list'))

@section('mobile_assets', 'menu--active')
@section('mobile_assets_index', 'menu--active')
@section('mobile_assets_sub', 'menu__sub-open')
@section('side_assets', 'side-menu--active')
@section('side_assets_index', 'side-menu--active')
@section('side_assets_sub', 'side-menu__sub-open')

@section('style')
    <style>
        #datatable_wrapper .dataTables_scrollHead {
            display: none;
        }

        #datatable_wrapper table {
            display: block;
            width: 100% !important;
        }

        #datatable_wrapper #datatable tbody {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        #datatable_wrapper #datatable tbody tr {
            padding: 3px;
            width: 200px;
            margin: 10px;
            text-align: center;
        }

        #datatable_wrapper #datatable tbody tr td {
            display: block;
            word-break: break-word;
        }
    </style>
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

    <div class="intro-y p-5 mt-5">
        <table id="datatable"
               data-lang="{{  (app()->getLocale() != 'en') ? asset('vendor/datatable/' . app()->getLocale() . '.json'): '' }}"
               data-action="{{ route('admin.assets.datatable') }}">
        </table>
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
                    name: "thumbnail",
                    title: "thumbnail",
                    render: function (data, type, row, meta) {
                        return '<img alt="asset" class="" src="' + row['thumbnail'] + '">';
                    },
                    orderable: false,
                }, {
                    name: "path",
                    title: "آدرس",
                    render: function (data, type, row, meta) {
                        return '<small class="mt-1"><a target="_blank" href="' + row.path + '">' + row.path.substr(row.path.length - 20) + '</a><small>';
                    },
                    orderable: false,
                }, {
                    name: "categories",
                    title: "دسته ها",
                    render: function (data, type, row, meta) {
                        let html = '';
                        html += '<h5 class="mt-2 text-lg font-medium">دسته ها</h5>';
                        html += '<ul>';

                        if (row.categories) {
                            $.each(row.categories, function (i, val) {
                                html += '<li>' + val['name'] + '</li>'
                            });
                        }

                        html += '</ul>';

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
                rowCallback: function (row, data) {
                    $(row).addClass('zoom-in box');
                }
            });
        });
    </script>
@endsection

