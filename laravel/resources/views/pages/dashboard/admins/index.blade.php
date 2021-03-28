@extends('pages.dashboard._layout')

@section('title', trans('pages/dashboard/admins.admins_list'))

@section('mobile_admins', 'menu--active')
@section('mobile_admins_index', 'menu--active')
@section('mobile_admins_sub', 'menu__sub-open')
@section('side_admins', 'side-menu--active')
@section('side_admins_index', 'side-menu--active')
@section('side_admins_sub', 'side-menu__sub-open')

@section('style')
    <style>
        #datatable {
            width: 100% !important;
        }

    </style>
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.index') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/dashboard/admins.admins_list') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/dashboard/admins.admins_list') }}
        </h2>
    </div>

    <div class="intro-y d-block mt-5">
        <table id="datatable"
               data-lang="{{ (app()->getLocale() != 'en') ? asset('vendor/datatable/' . app()->getLocale() . '.json') : '' }}"
               data-action="{{ route('dashboard.admins.datatable') }}">
        </table>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatable/js/datatables.min.js') }}"></script>
    <script>
        let deleteAdminUrl = '{{ route('dashboard.admins.destroy', ['admin' => 'adminId']) }}';
        let editAdminUrl = '{{ route('dashboard.admins.edit', ['admin' => 'adminId']) }}';
    </script>
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
                    name: "full_name",
                    title: "نام",
                    render: function (data, type, row, meta) {
                        return '<h2 class="mt-1 text-lg font-medium">' + row['full_name'] + '</h2>';
                    },
                    orderable: false,
                }, {
                    name: "cellphone",
                    title: "تلفن",
                    render: function (data, type, row, meta) {
                        return row['cellphone'];
                    },
                    orderable: false,
                }, {
                    name: "roles",
                    title: "نقش",
                    render: function (data, type, row, meta) {
                        return row['roles'];
                    },
                    orderable: false,
                }, {
                    name: "operation",
                    title: "عملیات",
                    render: function (data, type, row) {
                        return '' +
                            '<a href="' + editAdminUrl.replace('adminId', row.id) + '" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">' +
                            '   <i class="fad fa-edit w-4 h-4 mr-2"></i> ویرایش ' +
                            '</a>\n' +
                            '<a href="javascript:void(0);" data-id="' + row.id + '" class="deleteAdmin flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">' +
                            '   <i class="fad fa-trash w-4 h-4 mr-2"></i> حذف ' +
                            '</a>\n'
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

            $('body').on('click', '.deleteAdmin', function () {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'آیا مدیر حذف شود؟',
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
                            url: deleteAdminUrl.replace('adminId', id),
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

