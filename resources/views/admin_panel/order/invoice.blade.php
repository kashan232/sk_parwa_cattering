<!-- Meta tags and other links -->
@include('admin_panel.include.header_include')
<style>
    .invoice-container {
        width: 100%;
        background: #f8f9fa;
        padding: 30px 0;
    }

    .invoice {
        border: 2px solid #343a40;
        padding: 30px;
        width: 100%;
        max-width: 900px;
        margin: auto;
        background: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);
        font-family: 'Poppins', sans-serif;
        border-radius: 8px;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #343a40;
        padding-bottom: 15px;
    }

    .invoice-header img {
        max-width: 140px;
        margin-bottom: 10px;
    }

    .invoice-header p {
        margin: 3px 0;
        font-size: 16px;
        font-weight: 600;
        color: #495057;
    }

    .invoice-title {
        font-size: 24px;
        font-weight: bold;
        margin: 20px 0;
        text-transform: uppercase;
        text-align: center;
        color: #343a40;
    }

    .invoice table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .invoice th {
        background: #343a40;
        color: #fff;
        font-size: 14px;
        padding: 10px;
        text-transform: uppercase;
    }

    .invoice td {
        font-size: 14px;
        padding: 10px;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .invoice tbody tr:nth-child(even) {
        background: #f8f9fa;
    }

    .invoice-footer {
        text-align: center;
        margin-top: 25px;
    }

    .invoice-footer .btn {
        font-size: 16px;
        padding: 10px 20px;
        background: #dc3545;
        color: #fff;
        border-radius: 6px;
        font-weight: bold;
    }

    @media print {
        .invoice-footer, .navbar-wrapper {
            display: none;
        }

        .invoice {
            border: none;
            box-shadow: none;
        }
    }
</style>

<!-- Page-wrapper start -->
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    <!-- Sidebar end -->

    <!-- Navbar-wrapper start -->
    @include('admin_panel.include.navbar_include')
    <!-- Navbar-wrapper end -->

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius--10">
                        <div class="card-body p-0">
                            <div class="invoice-container">
                                <div class="invoice">
                                    <!-- Header with Logo and Contact Details -->
                                    <div class="invoice-header">
                                        <img src="{{ asset('assets/images/logo.jpg') }}" alt="Company Logo">
                                        <p><strong>Contact for Query:</strong> 0333-2548976 | 0333-2548976</p>
                                        <p><strong>Invoice Date: {{ $order->sale_date }}</strong> | <strong>Program Date: {{ $order->delivery_date }}</strong></p>
                                    </div>

                                    <!-- Client and Invoice Details -->
                                    <div class="row mt-3">
                                        <div class="col-md-6"><strong>Client Name:</strong> {{ $order->customer_name }}</div>
                                        <div class="col-md-6 text-right"><strong>Invoice #:</strong> {{ $order->id }}</div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6"><strong>Venue:</strong> {{ $order->Venue }}</div>
                                        <div class="col-md-6 text-right"><strong>Person Program:</strong> {{ $order->person_program ?? 'N/A' }}</div>
                                    </div>

                                    <!-- Invoice Title -->
                                    <div class="invoice-title">{{ $order->event_type }} Program Invoice</div>

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
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>Discount:</strong></td>
                                                <td><strong>{{ number_format($order->discount, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>Payable Amount:</strong></td>
                                                <td><strong>{{ number_format($order->payable_amount, 2) }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- Print Button -->
                                    <div class="invoice-footer">
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
</div>
@include('admin_panel.include.footer_include')
