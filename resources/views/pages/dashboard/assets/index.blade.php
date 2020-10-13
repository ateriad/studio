@extends('pages.dashboard._layout')

@section('title', trans('pages/dashboard/assets.assets_list'))

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

        #datatable_wrapper .dataTables_scrollBody {
            overflow: unset !important;
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
            width: 200px;
            margin: 10px;
            text-align: center;
            cursor: unset;
        }

        #datatable_wrapper #datatable tbody tr td {
            display: block;
            word-break: break-word;
        }

        table.dataTable.no-footer {
            border: none;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="{{ route('dashboard.dashboard') }}" class="">{{ trans('pages/general.home') }}</a>
        <i data-feather="chevron-right" class="breadcrumb__icon"></i>
        <a href="#" class="breadcrumb--active">{{ trans('pages/dashboard/assets.assets_list') }}</a>
    </div>
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ trans('pages/dashboard/assets.assets_list') }}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a class="button text-white bg-theme-1 shadow-md mr-2"
               href="{{ route('dashboard.assets.create') }}">
                {{ trans('pages/dashboard/assets.assets_create') }}
            </a>
        </div>
    </div>

    <div class="intro-y mt-5">
        <table id="datatable"
               data-lang="{{  (app()->getLocale() != 'en') ? asset('vendor/datatable/' . app()->getLocale() . '.json'): '' }}"
               data-action="{{ route('dashboard.assets.datatable') }}">
        </table>
    </div>
@endsection

@section('js')
    <script src="{{ asset('vendor/datatable/js/datatables.min.js') }}"></script>
    <script>
        let deleteAssetUrl = '{{ route('dashboard.assets.destroy', ['asset' => 'assetId']) }}';
        let editAssetUrl = '{{ route('dashboard.assets.edit', ['asset' => 'assetId']) }}';
    </script>
    <script>
        $(document).ready(function () {
            const Cols = [
                {
                    name: "operation",
                    title: "عملیات",
                    render: function (data, type, row) {
                        return '' +
                            '<div class="absolute w-full flex items-center px-2 pt-2 z-10">\n' +
                            '   <div class="dropdown relative ml-auto">\n' +
                            '       <a href="javascript:void(0);" class="dropdown-toggle w-8 h-8 flex items-center justify-center rounded-full" style="background: #bda5a526;">' +
                            '           <i class="fas fa-ellipsis-v-alt w-4 h-4 text-gray"></i>' +
                            '       </a>\n' +
                            '       <div class="dropdown-box mt-8 absolute w-40 top-0 right-0 z-20">\n' +
                            '            <div class="dropdown-box__content box dark:bg-dark-1 p-2">\n' +
                            '                 <a href="' + editAssetUrl.replace('assetId', row.id) + '" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">' +
                            '                    <i class="fad fa-edit w-4 h-4 mr-2"></i> ویرایش ' +
                            '                 </a>\n' +
                            '                 <a href="javascript:void(0);" data-id="' + row.id + '" class="deleteAsset flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">' +
                            '                    <i class="fad fa-trash w-4 h-4 mr-2"></i> حذف ' +
                            '                 </a>\n' +
                            '           </div>\n' +
                            '      </div>\n' +
                            '  </div>\n' +
                            '</div>';
                    },
                    orderable: false,
                }, {
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
                    name: "name",
                    title: "نام",
                    render: function (data, type, row, meta) {
                        return '<h2 class="mt-1 text-lg font-medium">' + row['name'] + '<small>';
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

            $('body').on('click', '.deleteAsset', function () {
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'آیا محتوا حذف شود؟',
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
                            url: deleteAssetUrl.replace('assetId', id),
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

