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
@section('title')
    تعديل فاتورة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تعديل فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- row -->
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="../invoices/update " method="POST" id="form" autocomplete="off">
                        {{ csrf_field() }}
                        @method('PUT')
                        {{-- 1 --}}

                        <input type="text" value="{{ $invoice->id }}" name="id" hidden>
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                    value="{{ $invoice->invoice_number }}" title="يرجي ادخال رقم الفاتورة" required>
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                    value="{{ $invoice->invoice_date }}" type="text" value="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                    value="{{ $invoice->due_date }}" type="date" required>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="Section" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"
                                            {{ $section->id == $invoice->section_id ? 'selected' : '' }}>
                                            {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="branch" name="branch" class="form-control">
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control calc" id="amount_collection" name="amount_collection"
                                    value="{{ $invoice->amount_collection }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control calc form-control-lg" id="amount_commission"
                                    value="{{ $invoice->amount_commission }}" name="amount_commission"
                                    title="يرجي ادخال مبلغ العمولة "
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control calc form-control-lg" id="discount" name="discount"
                                    title="يرجي ادخال مبلغ الخصم " value="{{ $invoice->discount }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                   required>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control calc" >
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value="5%" {{ $invoice->rate_vat == '5%' ? 'selected' : '' }}>5%</option>
                                    <option value="10%" {{ $invoice->rate_vat == '10%' ? 'selected' : '' }}>10%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text"  class="form-control" id="total_amount" name="total_amount" readonly>
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note"
                                    rows="3">{{ $invoice->note }}</textarea>
                            </div>
                        </div><br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>


                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="attachment_table" class="table table-striped mg-b-0 text-md-nowrap">
                                        <thead>
                                            <th scope="col">م</th>
                                            <th scope="col">اسم الملف</th>
                                            <th scope="col">قام بالاضافة</th>
                                            <th scope="col">تاريخ الاضافة</th>
                                            <th scope="col">العمليات</th>
                                        </thead>
                                        <tbody>

                                            @php
                                                $x = 0;
                                            @endphp


                                            @foreach ($invoice->invoices_attachments as $item)
                                                <tr>
                                                    <th>{{ $x++ }}</th>
                                                    <th>{{ $item->file_name }}</th>
                                                    <th>{{ $item->Created_by }}</th>
                                                    <th>{{ $item->create_date }}</th>
                                                    <th>
                                                        <button type="button" name="delete" id="btn-delete"
                                                            class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                            data-target=".bd-example-modal-sm"
                                                            data-attachment_id="{{ $item->id }}"
                                                            data-file_name="{{ $item->file_name }}"
                                                            data-invoice_number="{{ $item->invoice_number }}">حذف</button>
                                                        <a type="button" class="btn btn-outline-secondary btn-sm"
                                                            href="../download_file/{{ $item->invoice_number }}/{{ $item->file_name }}">تحميل</a>
                                                        <a type="button" class="btn btn-outline-secondary btn-sm"
                                                            href="../view_file/{{ $item->invoice_number }}/{{ $item->file_name }}">عرض</a>
                                                    </th>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                        @if( empty($invoice->deleted_at)  )
                        @can('Add Attachment')
                            <form action="../add-attachment" method="POST" id="add_form" enctype="multipart/form-data">
                            @csrf
                            <div class="custom-file">
                                <input type="file" name="pic" id="pic" class="custom-file-input"
                                    accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" onchange="this.form.submit();" hidden/>
                                <a class="btn btn-sm btn-info" onclick="document.getElementById('pic').click()">Choose file</a>
                                <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                <input type="hidden" id="invoice_number" name="invoice_number"
                                    value="{{ $invoice->invoice_number }}">
                            </div>
                        </form>
                          @endcan
                        @endif


                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('form').submit()">حفظ البيانات</button>
                        </div>



                </div>
            </div>
        </div>
    </div>

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
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>


    <script>
        function getSections() {
            var section_id = $(this).val();

            if (section_id) {

                $.ajax({
                    url: "../get_branch/" + section_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('select[name="branch"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="branch"]').append(' <option value="' +
                                value + '"> ' + value + '</option>');

                        });
                    },
                });
            } else {
                console.log('error loading ajax');
            }
        }

        $(document).ready(function() {
            $('select[name="Section"]').change(getSections).change();
            $('.calc').on('change', function() { myFunction();  });
        });
        getSections();


    </script>


    <script>
       function myFunction() {
            var Amount_Commission = parseFloat(document.getElementById("amount_commission").value);
            Amount_Commission= Amount_Commission ? Amount_Commission : 0;
            var discount = parseFloat(document.getElementById("discount").value);
            discount = discount? discount:0;
            var rate_vat = parseFloat(document.getElementById("rate_vat").value);
            rate_vat = rate_vat ? rate_vat : 0;

            var Amount_Commission2 = Amount_Commission - discount;
                var intResults = Amount_Commission2 * rate_vat / 100;
                var intResults2 = parseFloat(intResults + Amount_Commission2);
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("value_vat").value = sumq ;
                document.getElementById("total_amount").value = sumt ;

        }
        myFunction();
    </script>



@endsection
