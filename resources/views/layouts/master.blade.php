<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords"
        content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
    @include('layouts.head')
    @livewireStyles
</head>

<body class="main-body app sidebar-mini">
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ URL::asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->
    @include('layouts.main-sidebar')
    <!-- main-content -->
    <div class="main-content app-content">
        @include('layouts.main-header')
        <!-- container -->
        <div class="container-fluid">
            @yield('page-header')
            @yield('content')
            @include('layouts.sidebar')



            @include('layouts.models')
            @include('layouts.footer')
            @include('layouts.footer-scripts')

            @livewireScripts
            <script>
                var txt = '';
                $(document).ready(function() {

                    $("#searchInput").focus(function() {
                        document.getElementById("ico_search").click();
                        sendToSearch();

                    });

                    $("#searchInput").off("focusout", function() {
                        document.getElementById("ico_search").click();
                    });



                    $('#searchInput').on('input', function() {
                        sendToSearch();
                    });

                });

                var sendToSearch = function() {

                    this.txt = $('#searchInput').val();

                    if (txt) {
                        $.ajax({
                            url: "/search/" + txt,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#result_box').empty();

                                if (data) {

                                    $.each(data, function(key, value) {


                                        $('#result_box').append(
                                            '<a href="showInvoices/' + value['id'] +
                                            '" class="p-3 d-flex border-bottom "><div class="wd-90p "><div class="d-flex justify-content-end"><h5 class="mb-1 name"> Invoice number : ' +
                                            value['invoice_number'] +
                                            '</h5></div><div id="desc_' + value['id'] +'"  ></div><p class="time mb-0 text-left float-right mr-2 mt-2">Jan 29 03:16 PM</p></div></a>'
                                        );
                                        checkTxt(value);

                                    });
                                } else {

                                    $('#result_box').empty();

                                }
                            },
                        });
                    } else {
                        $('#result_box').empty();
                    }

                };


                var checkTxt = function(val) {

                    const index = ['total_amount', 'total_paid', 'rate_vat', 'discount', 'invoice_number'];

                    for (let i = 0; i < index.length; i++) {

                        if (val[index[i]].toLowerCase().includes(this.txt.toLowerCase())) {
                            var indexOf = val[index[i]].toLowerCase().indexOf(this.txt.toLowerCase());
                            $('#desc_' + val['id']).append('<p class="mb-0 desc ">'+index[i]+' : ' + val[index[i]].substring(indexOf - 10,
                                indexOf) + '<mark style=" background-color: yellow;">' + this.txt + '</mark>' + val[index[i]].substring(indexOf + this.txt
                                .length, indexOf + this.txt.length + 6) + '</p>');
                        }
                    }

                    //
                    if (val['invoices_attachments']) {

                        var attachments = val['invoices_attachments'];

                        attachments.forEach(el => {

                            el = el['file_name'].toLowerCase();

                            if (el.includes(this.txt.toLowerCase())) {
                                var indexOf = el.indexOf(this.txt.toLowerCase());
                                console.log('indexOf :>> ', indexOf);
                                $('#desc_' + val['id']).append('<p class="mb-0 desc">file_name : '   +el.substring(indexOf - 10,
                                indexOf) + '<mark style=" background-color: yellow;">' + this.txt + '</mark>' + el.substring(indexOf + this.txt
                                .length, indexOf + this.txt.length + 6) +  '</p>');
                            }

                        });

                    }

                    //
                    if (val['invoices_details']) {

                        var details = val['invoices_details'];

                        details.forEach(el => {

                            el = (el['amount_paid'] + '').toLowerCase();

                            if (el.includes(this.txt.toLowerCase())) {
                                var indexOf = el.indexOf(this.txt.toLowerCase());
                                $('#desc_' + val['id']).append('<p class="mb-0 desc">amount_paid : '  +el.substring(indexOf - 10,
                                indexOf) + '<mark style=" background-color: yellow;">' + this.txt + '</mark>' + el.substring(indexOf + this.txt
                                .length, indexOf + this.txt.length + 6) + '</p>');
                            }

                        });

                    }

                };





                // setInterval(function(){
                //     $("#display_notifi").load(window.location.href + "#display_notifi");
                //     $("#count_notifi").load(window.location.href + "#count_notifi");
                //     console.log('loding+');
                // },5000);
            </script>
            <!-- /main-header -->

</body>

</html>
