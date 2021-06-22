@extends('layouts.master')
@section('title' ,'طباعة فاتورة' )

@section('css')

<style>
    @media print{
        #btn_print{
            display: none;
        }
    }
</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">طباعة فاتورة</span>
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
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
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
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">Invoice</h1>
										<div class="billed-from">
											<h6>BootstrapDash, Inc.</h6>
											<p>201 Something St., Something Town, YT 242, Country 6546<br>
											Tel No: 324 445-4544<br>
											Email: youremail@companyname.com</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
												<h6>Juan Dela Cruz</h6>
												<p>4033 Patterson Road, Staten Island, NY 10301<br>
												Tel No: 324 445-4544<br>
												Email: youremail@companyname.com</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">Invoice Information</label>
											<p class="invoice-info-row"><span>Invoice No</span> <span>{{$invoice->invoice_number}}</span></p>
											<p class="invoice-info-row"><span>Project ID</span> <span>{{$invoice->id}}</span></p>
											<p class="invoice-info-row"><span>Issue Date:</span> <span>{{$invoice->invoive_date}}</span></p>
											<p class="invoice-info-row"><span>Due Date:</span> <span>{{$invoice->due_date}}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0"  >
											<thead>
												<tr>
                                                    <th>#</th>
                                                    <th>رقم الفاتورة</th>
                                                    <th>نوع المنتج</th>
                                                    <th>القسم</th>
                                                      <th>تاريخ الدفع </th>
                                                    <th>المدفوع</th>
                                                    <th>اجمالي الدفع</th>
                                                    <th>حالة الدفع</th>
                                                    <th>تاريخ الاضافة </th>
                                                    <th>المستخدم</th>
												</tr>
											</thead>
											<tbody>
                                                <@php
                                                $sum = 0;
                                            @endphp
                                                @foreach ($invoice->invoices_details  as $detail)

                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ $detail->invoice_number }}</th>
                                                    <th>{{ $detail->branch }}</th>
                                                    <th>{{ $detail->section }}</th>
                                                    <th>{{ $detail->value_status }}</th>
                                                    <th>{{ $detail->amount_paid }}</th>
                                                    <th>{{  $sum+=$detail->amount_paid  }}</th>
                                                    <th>
                                                        @if ($sum ==0 )
                                                          غير مدفوعة
                                                       @elseif ( $sum < $invoice->total )
                                                         مدفوعة جزئيا
                                                         @else
                                                         مدفوعة
                                                    @endif</th>
                                                    <th>{{ $detail->created_at }}</th>
                                                    <th>{{ $detail->user }}</th>
                                                </tr>

                                            @endforeach
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">Notes</label>
														</div><!-- invoice-notes -->
													</td>
                                                    <@php
                                                        $total = $invoice->amount_commission+$invoice->amount_collection;
                                                    @endphp
													<td class="tx-right">Total</td>
													<td class="tx-right" colspan="2">{{number_format($total,2)}}</td>
												</tr>
												<tr>
													<td class="tx-right">Tax ({{$invoice->rate_vat}})</td>
                                                    <td class="tx-right" colspan="2">{{number_format($invoice->value_vat,2)}}</td>


												</tr>
												<tr>
													<td class="tx-right">Discount</td>
                                                    <td class="tx-right" colspan="2">{{number_format($invoice->discount,2)}}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">{{number_format($invoice->total,2)}}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									{{-- <a class="btn btn-purple float-left mt-3 mr-2" href="">
										<i class="mdi mdi-currency-usd ml-1"></i>Pay Now
									</a> --}}
									<a href="#" onclick="printInvoice()" id="btn_print" class="btn btn-danger float-left mt-3 mr-2">
										<i class="mdi mdi-printer ml-1"></i>Print
									</a>
									{{-- <a href="#" class="btn btn-success float-left mt-3">
										<i class="mdi mdi-telegram ml-1"></i>Send Invoice
									</a> --}}
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<script>
    function printInvoice(){
var printCountents = document.getElementById('print').innerHTML;
// var orginalCountents = document.body.innerHTML;
document.body.innerHTML = printCountents;
window.print();
// document.body.innerHTML = orginalCountents;
location.reload();
    }
</script>
@endsection
