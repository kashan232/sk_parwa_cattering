@include('admin_panel.include.header_include')

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .invoice-container {
        width: 800px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header img {
        width: 100px;
    }

    .header h1 {
        margin-left: 20px;
        font-size: 32px;
        font-weight: 700;
        font-family: 'Roboto', sans-serif; /* Stylish font */
        color: #333;
        text-transform: uppercase;
    }

    .header .company-info {
        text-align: right;
    }

    .header .company-info p {
        margin: 0;
        line-height: 1.5;
    }

    .invoice-title {
        text-align: center;
        font-size: 24px;
        font-weight: 600;
        margin: 20px 0;
    }

    .date-info {
        text-align: center;
        font-size: 14px;
        margin-top: 5px;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .invoice-table th,
    .invoice-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .invoice-table th {
        background-color: #f7b801;
        color: #fff;
    }

    .invoice-table .subtotal,
    .invoice-table .discount,
    .invoice-table .total {
        background-color: #f7b801;
        color: #fff;
        font-weight: 600;
    }

    .footer {
        text-align: left;
        margin-top: 30px;
    }

    .footer .prepared-by {
        font-weight: 600;
    }
</style>

<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius--10">
                        <div class="card-body p-0">
                            <div class="invoice-container">
                                <div class="header">
                                    <img src="{{ asset('assets/images/final_logo.png') }}" alt="Company Logo">
                                    <h1>SK Parwa Caterers</h1>
                                    <div class="company-info">
                                        <p>Client Name: <strong>{{ $order->customer_name }}</strong></p>
                                        <p>Mobile: <strong>{{ $order->mobile_number }}</strong></p>
                                        <p>Reference: <strong>{{ $order->reference_name }}</strong></p>
                                        <p>Venue: <strong>{{ $order->Venue }}</strong></p>
                                        <p>Person Program: <strong>{{ $order->person_program ?? 'N/A' }}</strong></p>
                                        <p>Event Type: <strong>{{ $order->event_type }}</strong></p>
                                    </div>
                                </div>

                                <div class="invoice-title">
                                    INVOICE
                                    <div class="date-info">
                                        <p>Estimate Date:{{ $order->sale_date }} | Program Date:{{ $order->delivery_date }}</p>
                                    </div>
                                </div>

                                <div class="table-container">
                                    <table class="invoice-table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Name</th>
                                                <th>Sub Category</th>
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
                                                 <td>{{ $categoriesMap[$categories[$index]] ?? '-' }}</td>
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
                                </div>

                                <div class="footer">
                                    <p>Prepared By</p>
                                    <p class="prepared-by">{{ auth()->user()->name }}</p>
                                    <p>{{ auth()->user()->role }}</p>
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
