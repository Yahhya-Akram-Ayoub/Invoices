<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;

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
    public function index()
    {

        $data =  $this->getData();

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 450, 'height' => 280])
            ->labels(['Unpaid Invoices', 'Partially Unpaid Invoices', 'Paid Invoices'])
            ->datasets([
                [
                    // "label" => [ "Unpaid Invoices","Paid Invoices" ,"Paid Invoices"],
                    'backgroundColor' => ['rgba(255, 0, 0, 0.4)', 'rgba(255, 0, 255, 0.4)', 'rgba(0, 255, 255, 0.4)'],
                    'data' => [$data['UnpaidPercent'], $data['PartiallyPercent'], $data['PaidPercent']]
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

        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 250])
            ->labels(['Label x', 'Label y'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [69, 59]
                ]
            ])
            ->options([]);







        return view('home', compact('chartjs','chartjs2', 'data'));
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
