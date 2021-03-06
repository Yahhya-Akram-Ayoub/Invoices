@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('title')
الفواتير المدفوعة جزئيا
@stop

@section('page-header')
    <!--notfication-->
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "warning"
                })
            }

        </script>
    @endif
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الفواتير المدفوعة جزئيا</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
            </div>
            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate"
                        data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">




        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-body">
                    <div class="table-responsive" style="height:460px ">
                        <table id="table_invoices" class="table  text-md-nowrap" >
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">{{__('invoice.number')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.date')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.due_date')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.section')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.branch')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.total')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.status')}}</th>
                                    <th class="border-bottom-0">{{__('invoice.options')}}</th>
                                    <th class="border-bottom-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($invoices as $i)

                                    <tr>
                                        <th class="border-bottom-0">{{ $count++ }}</th>
                                        <th class="border-bottom-0">{{ $i->invoice_number }}</th>
                                        <th class="border-bottom-0">{{ $i->invoice_date }}</th>
                                        <th class="border-bottom-0">{{ $i->due_date }}</th>
                                        <th class="border-bottom-0">{{ $i->section->section_name }}</th>
                                        <th class="border-bottom-0">{{ $i->branch->branch_name }}</th>
                                        <th class="border-bottom-0">{{ $i->total_amount }}</th>

                                        <th class="border-bottom-0">
                                            <div class="btn-group">
                                                <a type="button" class=" dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @if ($i->value_status == 2)
                                                    <span class="badge badge-pill badge-success">{{__('invoice.paid')}}</span>

                                                @elseif($i->value_status ==0)
                                                    <span class="badge badge-pill badge-danger">{{ __('invoice.unpaid') }}</span>

                                                @else
                                                  <span class="badge badge-pill badge-warning">{{__('invoice.partially') }}</span>

                                                @endif
                                                </a>
                                                <div class="dropdown-menu">
                                                    @can('Change paid status')<a href="show_pay/{{ $i->id }}" class=" dropdown-item"><i
                                                            class=" typcn typcn-arrow-back-outline"></i>
                                                        تعديل</a>@endcan
                                                </div>
                                            </div>
                                        </th>

                                        <th>
                                            <!-- Example single danger button -->
                                            <div class="btn-group">
                                                <a type="button" class=" dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="badge badge-pill badge-info"> العمليات</span>
                                            </a>
                                                <div class="dropdown-menu">
                                                    <a href="showInvoices/{{ $i->id }}" class=" dropdown-item"><i
                                                            class=" typcn typcn-arrow-back-outline"></i>
                                                        عرض</a>
                                                        @can('Modify invoice')<a href="edit/{{ $i->id }}" class=" dropdown-item"><i
                                                            class=" typcn typcn-arrow-back-outline"></i>
                                                        تعديل</a>@endcan
                                                   @can('Delete invoice') <a class="dropdown-item" id="delete_btn_id" name="delete_btn_id"
                                                        data-toggle="modal" data-target="#deleteModal"
                                                        data-id="{{ $i->id }}"><i
                                                            class=" typcn typcn-arrow-back-outline"></i>
                                                        حذف</a>@endcan
                                                        @can('Archive invoice') <a class="dropdown-item" id="archived_btn_id" name="archived_btn_id"
                                                        data-toggle="modal" data-target="#archivedModal"
                                                        data-id="{{ $i->id }}" ><i
                                                            class=" typcn typcn-arrow-back-outline"></i>
                                                        ارشفة</a>@endcan
                                                        @can('Print invoice')  <a class="dropdown-item" href="print/{{ $i->id }}" ><i
                                                            class=" typcn typcn-arrow-back-outline"></i>
                                                        طباعة </a>@endcan

                                                </div>
                                            </div>
                                        </th>
                                        <th class="border-bottom-0"></th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->



        <!-- delete -->
        <div class="modal" id="deleteModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="invoices/destroy" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>

                            <input class="form-control" name="invoice_id" id="invoice_id" type="text" readonly hidden>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                </div>
                </form>
            </div>
        </div>


    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">



        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Bordered Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Example of Valex Bordered Table.. <a href="">Learn more</a></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبة </th>
                                    <th class="border-bottom-0">قيمة الضريبة </th>
                                    <th class="border-bottom-0">الاجمالي</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>20200025</td>
                                    <td>2020-3-1</td>
                                    <td>2020-3-1</td>
                                    <td>cars</td>
                                    <td>القسم 54</td>
                                    <td>244</td>
                                    <td>3%</td>
                                    <td>600</td>
                                    <td>61214</td>
                                    <td>غير مدفوع</td>
                                    <td>غير مسلم</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#invoice_id').val(id);
        });

    </script>
@endsection
