<!-- meta tags and other links -->
@include('admin_panel.include.header_include')
<style>
    .invoice,
    .invoice-header,
    .invoice table,
    .invoice th,
    .invoice td {
        border: 2px solid #000 !important;
    }

    .invoice table {
        border-collapse: collapse;
    }

    .invoice th,
    .invoice td {
        padding: 10px;
        text-align: center;
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .invoice,
        .invoice * {
            visibility: visible;
        }

        .invoice {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .invoice-footer {
            display: none;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }
    }
</style>
<!-- page-wrapper start -->
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')
    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius--10">
                        <div class="card-body p-0">
                            <div class="invoice text-center">
                                <div class="invoice-header">
                                    <img src="{{ asset('assets\images\logo.jpg') }}" alt="Company Logo" class="mb-3" style="max-width: 150px;">
                                    <p><strong>Contact for Query:</strong> 0333-2548976 | 0333-2548976</p>
                                    <p><strong>Invoice Date: {{ $order->sale_date }}</strong></p>
                                </div>
                                <div class="row mt-3 text-left">
                                    <div class="col-md-6"><strong>Client Name:</strong> {{ $order->customer_name }}</div>
                                    <div class="col-md-6 text-right"><strong>Invoice #:</strong> {{ $order->id }}</div>
                                </div>
                                <hr>
                                <h4 class="mb-3" style="font-weight: 900;">Payment & Receipt Voucher</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Particular</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><strong>Recived Amount Rs</strong> {{ $amountInWords }} Against {{ $order->event_type }} Program Date ({{ $order->delivery_date }})  <br> <strong> Program Venue </strong>: {{ $order->Venue }}</td>
                                            <td>{{ number_format($order->payable_amount, 2) }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td><strong> Paid Amount:</strong></td>
                                            <td><strong>{{ number_format($order->advance_paid, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row mt-5 text-left">
                                    <div class="col-md-6">
                                        <p><strong>In Words:</strong> {{ $amountInWords }}</p>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <p><strong>Authorized Signature:</strong> __________________</p>
                                    </div>
                                </div>
                                <div class="invoice-footer mt-4  mb-3">
                                    <button onclick="window.print()" class="btn btn-danger"><i class="fas fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin_panel.include.footer_include')