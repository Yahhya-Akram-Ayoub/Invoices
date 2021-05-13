@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection

@section('content')

    <div class="card">
        <div class="panel panel-primary tabs-style-3">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#tab11" class="active" data-toggle="tab"><i class="fa fa-laptop"></i> Tab
                                Style 01</a></li>
                        <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i> Tab Style 02</a></li>
                        <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> Tab Style 03</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab11">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mg-b-0 text-md-nowrap">
                                            <tr>
                                                <th scope="row">رقم الفاتورة</th>
                                                <td>{{ $invoice->invoice_number }}</td>
                                                <th scope="row">تاريخ الاصدار</th>
                                                <td>{{ $invoice->invoive_date }}</td>
                                                <th scope="row">تاريخ الاستحقاق</th>
                                                <td>{{ $invoice->due_date }}</td>
                                                <th scope="row">القسم</th>
                                                <td>{{ $invoice->section_id }}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">المنتج</th>
                                                <td>{{ $invoice->product_id }}</td>
                                                <th scope="row">مبلغ التحصيل</th>
                                                <td>{{ $invoice->amount_collection }}</td>
                                                <th scope="row">مبلغ العمولة</th>
                                                <td>{{ $invoice->amount_commission }}</td>
                                                <th scope="row">الخصم</th>
                                                <td>{{ $invoice->discount }}</td>
                                            </tr>


                                            <tr>
                                                <th scope="row">نسبة الضريبة</th>
                                                <td>{{ $invoice->rate_vat }}</td>
                                                <th scope="row">قيمة الضريبة</th>
                                                <td>{{ $invoice->value_vat }}</td>
                                                <th scope="row">الاجمالي مع الضريبة</th>
                                                <td>{{ $invoice->total }}</td>
                                                <th scope="row">الحالة الحالية</th>

                                                @if ($invoice->value_status == 1)
                                                    <td><span
                                                            class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                                    </td>
                                                @elseif($invoice->value_status ==2)
                                                    <td><span
                                                            class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                                    </td>
                                                @endif
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab12">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mg-b-0 text-md-nowrap">
                                            <thead>
                                                <th>#</th>
                                                <th>رقم الفاتورة</th>
                                                <th>نوع المنتج</th>
                                                <th>القسم</th>
                                                <th>حالة الدفع</th>
                                                <th>تاريخ الدفع </th>
                                                <th>ملاحظات</th>
                                                <th>تاريخ الاضافة </th>
                                                <th>المستخدم</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ $details->invoice_number }}</th>
                                                    <th>{{ $details->product }}</th>
                                                    <th>{{ $details->section }}</th>
                                                    <th>{{ $details->status }}</th>
                                                    <th>{{ $details->value_status }}</th>
                                                    <th>{{ $details->note }}</th>
                                                    <th>{{ $details->created_at }}</th>
                                                    <th>{{ $details->user }}</th>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab13">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped mg-b-0 text-md-nowrap">
                                            <thead>
                                                <th scope="col">م</th>
                                                <th scope="col">اسم الملف</th>
                                                <th scope="col">قام بالاضافة</th>
                                                <th scope="col">تاريخ الاضافة</th>
                                                <th scope="col">العمليات</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @php
                                                        $x = 0;
                                                    @endphp
                                                    @foreach ($attachment as $item)

                                                        <th>{{ $x++ }}</th>
                                                        <th>{{ $item->file_name }}</th>
                                                        <th>{{ $item->Created_by }}</th>
                                                        <th>{{ $item->create_date }}</th>
                                                        <th>
                                                            <button type="button" name="delete" id="btn-delete"
                                                                class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                                data-target=".bd-example-modal-sm"
                                                                data-attachment_id="{{ $item->id }}"
                                                                data-file_name="{{ $item->file_name }}">حذف</button>
                                                            <button type="button"
                                                                class="btn btn-outline-primary btn-sm">تحميل</button>
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm">عرض</button>
                                                        </th>
                                                    @endforeach
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--  modalS -->

        <!--  DELETE modal -->

        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true" id="delete_modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">هل انت متاكد من حذف المرفق</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../delete-attachment" method="POST">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <input type="text" class="form-control" readonly name="file_name" id="name_attchment_deleted">
                            <input type="hidden" class="form-control" readonly name="id" id="id_attchment_deleted">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-info btn-sm" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-outline-danger btn-sm">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--enD  modalS-->
    </div>
    <!-- row closed -->
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


    <script>
        $('#delete_modal').on('shown.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var file_name = button.data('file_name');
            var id = button.data('attachment_id');
            $('#name_attchment_deleted').val(file_name);
            $('#id_attchment_deleted').val(id);
        })

    </script>
@endsection
