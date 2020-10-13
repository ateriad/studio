@extends('pages.dashboard._layout')

@section('title', trans('pages/dashboard/assets.asset_categories_list'))

@section('mobile_asset_categories', 'menu--active')
@section('mobile_asset_categories_index', 'menu--active')
@section('mobile_asset_categories_sub', 'menu__sub-open')
@section('side_asset_categories', 'side-menu--active')
@section('side_asset_categories_index', 'side-menu--active')
@section('side_asset_categories_sub', 'side-menu__sub-open')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatable/css/datatables.min.css') }}">
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/dashboard/assets.asset_categories_list') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/dashboard/assets.asset_categories_list') }}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a class="button text-white bg-theme-1 shadow-md mr-2"
               href="{{ route('dashboard.asset-categories.create') }}">
                {{ trans('pages/dashboard/assets.asset_categories_create') }}
            </a>
        </div>
    </div>

    <div class="intro-y mt-5 ">
        <div class="overflow-x-auto scrollbar-hidden">
            <table class="table table-striped hover" style="width:100%" id="datatable"
                   data-lang="{{  (app()->getLocale() != 'en') ? asset('vendor/datatable/' . app()->getLocale() . '.json'): '' }}"
                   data-action="{{ route('dashboard.asset-categories.datatable') }}">
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatable/js/datatables.min.js') }}"></script>
    <script>
        let deleteCategoryUrl = '{{ route('dashboard.asset-categories.destroy', ['category' => 'categoryId']) }}';
    </script>
    <script>
        $(document).ready(function () {
            const Cols = [
                {
                    name: "id",
                    title: "شناسه",
                    render: function (data, type, row) {
                        return row.id;
                    },
                    orderable: true,
                    visible: false,
                }, {
                    name: "name",
                    title: "نام",
                    render: function (data, type, row) {
                        return row.name;
                    },
                    orderable: true,
                }, {
                    name: "parent",
                    title: "والد",
                    render: function (data, type, row) {
                        return row.parent;
                    },
                    orderable: false,
                }, {
                    name: "assets_count",
                    title: "تعداد محتوا",
                    render: function (data, type, row) {
                        return row['assets_count'];
                    },
                    orderable: true,
                }, {
                    name: "operation",
                    title: "عملیات",
                    render: function (data, type, row) {
                        return '' +
                            '<div class="">' +
                            '   <a class="text-theme-6 deleteCategory" href="javascript:void(0);" data-id="' + row.id + '">' +
                            '       <i class="fad fa-trash w-4 h-4 mr-1"></i>' +
                            'حذف        ' +
                            '   </a>' +
                            '</div>';
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
                dom: "<'table_info'<l><r><i>><'box p-5 pt-3 mt-4't><p>",
                pageLength: 25,
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


            $('body').on('click', '.deleteCategory', function () {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'آیا دسته حذف شود؟',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            url: deleteCategoryUrl.replace('categoryId', id),
                            success: function (response) {
                                console.log(response)
                                successToastr(response['message'])
                                table.ajax.reload();
                            },
                            error: function (error) {
                                console.log(error)

                                switch (error.status) {
                                    case 422:
                                        // validation
                                        $.each(error['responseJSON']['errors'], function (i, j) {
                                            errorToastr(j[0])
                                        })
                                        break;
                                    default:
                                        // 500
                                        errorToastr(error['responseJSON']['message'])
                                        break;
                                }
                            }
                        });
                    }
                })
            })
        });
    </script>
@endsection
