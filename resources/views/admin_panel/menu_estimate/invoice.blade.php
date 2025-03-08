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
            /* Hides the print button */
        }

        /* Remove extra margin/padding */
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
    <!-- sidebar end -->

    <!-- navbar-wrapper start -->
    @include('admin_panel.include.navbar_include')
    <!-- navbar-wrapper end -->

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius--10">
                        <div class="card-body p-0">
                            <div class="invoice text-center p-2">
                                <!-- Centered Logo -->
                                <div class="invoice-header">
                                    <img src="{{ asset('assets\images\logo.jpg') }}" alt="Company Logo" class="mb-3" style="max-width: 150px;">

                                    <p><strong>Contact for Query:</strong> 0333-2548976 | 0333-2548976</p>
                                    <p><strong>Estimate Date: {{ $order->sale_date }}</strong> | <strong>Program Date: {{ $order->delivery_date }}</strong></p>
                                </div>

                                <!-- Client Name & Invoice Number -->
                                <div class="row mt-3 text-left">
                                    <div class="col-md-6"><strong>Client Name:</strong> {{ $order->customer_name }}</div>
                                    <div class="col-md-6 text-right"><strong>Estimate No #:</strong> {{ $order->id }}</div>
                                </div>

                                <!-- Venue & Person Program -->
                                <div class="row mt-2 text-left">
                                    <div class="col-md-6"><strong>Venue:</strong> {{ $order->Venue }}</div>
                                    <div class="col-md-6 text-right">{{ $order->person_program ?? 'N/A' }}&nbsp;<strong>Person Program</strong> </div>
                                </div>
                                <!-- Static Text: Program Ceremony Invoice -->
                                <h4 class="mb-3" style="font-weight: 900;">{{ $order->event_type }} Program Menu Estimate</h4>
                                <!-- Invoice Table -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Item Name</th>
                                            <th>Main Category</th>
                                            <th>Rate</th>
                                            <th>QTY</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $categories = json_decode($order->item_category, true);
                                        $names = json_decode($order->item_name, true);
                                        $units = json_decode($order->unit, true);
                                        $quantities = json_decode($order->quantity, true);
                                        $prices = json_decode($order->price, true);
                                        $totals = json_decode($order->total, true);
                                        @endphp

                                        @foreach ($names as $index => $name)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $name }}</td>
                                            <td>{{ $categories[$index] ?? '-' }}</td>
                                            <td>{{ number_format($prices[$index], 2) }}</td>
                                            <td>{{ $quantities[$index] }} {{ $units[$index] ?? '-' }}</td>
                                            <td>{{ number_format($totals[$index], 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><strong>Total Price:</strong></td>
                                            <td><strong>{{ number_format($order->total_price, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <!-- Print Button -->
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