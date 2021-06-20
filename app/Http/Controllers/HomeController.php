<?php

namespace App\Http\Controllers;


use App\Models\invoices;
use Illuminate\Http\Request;
use GrahamCampbell\ResultType\Result;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $geoIpInfo =  geoip()->getLocation( geoip()->getClientIP() )->toArray();
        $data =  $this->getData();

        $chartjs = app()->chartjs
            ->name('barChart')
            ->type('bar')
            ->size(['width' => 450, 'height' => 280])
            ->labels(['Unpaid Invoices', 'Partially Unpaid Invoices', 'Paid Invoices'])
            ->datasets([
                [
                    "label" => [ "Unpaid Invoices"],
                    'backgroundColor' => ['rgba(255, 0, 0, 0.6)'],
                    'data' => [$data['UnpaidPercent']]
                ], [
                    "label" => ["Paid Invoices" ],
                    'backgroundColor' => ['rgba(255, 0, 255, 0.6)'],
                    'data' => [ $data['PartiallyPercent']]
                ], [
                    "label" => [ "Paid Invoices"],
                    'backgroundColor' => [ 'rgba(0, 255, 255, 0.6)'],
                    'data' => [ $data['PaidPercent']]
                ]

            ])
            ->options([]);
        // ->options([
        //       'legend' => [
        //     'display' => true,
        //     'labels' => [
        //         'fontColor' => 'black',
        //         'fontFamily' => 'Cairo',
        //         'fontStyle' => 'bold',
        //         'fontSize' => 14,

        //     ]]]);




        // ExampleController.php


        $Unpaid =  $data['AllAmount'] - $data['paidAmount'];
        $paid =     $data['paidAmount'];
        $chartjs2 = app()->chartjs
            ->name('pieChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 250])
            ->labels(['$'. $Unpaid.' Unpaid Amount','$'. $paid. ' paid Amount'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [$Unpaid, $paid]
                ]
            ])
            ->options([]);







        return view('home', compact('chartjs', 'chartjs2', 'data','geoIpInfo'));
    }

    public function getData()
    {
        $AllInvoices = invoices::all();
        $UnpaidInvoices = invoices::where('value_status', '=', 0)->get();
        $PartiallyPaidInvoices = invoices::where('value_status', '=', 1)->get();
        $PaidInvoices = invoices::where('value_status', '=', 2)->get();

        $countAll = $AllInvoices->count();
        $countUnpaid =  $UnpaidInvoices->count();
        $countPartially = $PartiallyPaidInvoices->count();
        $countPaid = $PaidInvoices->count();

        $PartiallyPercent = round($countPartially / $countAll * 100, 2);
        $UnpaidPercent = round($countUnpaid / $countAll * 100, 2);
        $PaidPercent = round($countPaid / $countAll * 100, 2);


        $result =  [
            'Unpaid' => $countUnpaid,
            'UnpaidPercent' =>  $UnpaidPercent,

            'Partially' =>  $countPartially,
            'PartiallyPercent' => $PartiallyPercent,

            'Paid' =>  $countPaid,
            'PaidPercent' =>   $PaidPercent,

            'AllInvoices' =>  $countAll,

            'AllAmount' => $AllInvoices->sum('total_amount'),
            'paidAmount' => $AllInvoices->sum('total_paid')


        ];

        return $result;
    }
}
