@include('admin_panel.include.header_include')

<style>
    /* Ensure styles are specifically for screen and print */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f8f8; /* A light grey to distinguish content area */
        margin: 0;
        padding: 0;
        color: #333;
    }

    .invoice-container {
        width: 210mm; /* A4 width */
        margin: 10px auto;
        padding: 10mm; /* Padding in mm for consistent print output */
        border: 1px solid #eee; /* Lighter border */
        border-radius: 8px; /* Slightly softer corners */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05); /* Softer shadow */
        background-color: #fff;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px; /* More space below header */
    }

    .header img {
        width: 80px; /* Slightly smaller logo */
        height: auto;
        max-width: 100%; /* Ensure responsiveness */
    }

    .header h1 {
        margin-left: 20px;
        font-size: 28px; /* Slightly smaller font size */
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        color: #333;
        text-transform: uppercase;
        flex-grow: 1; /* Allows the title to take available space */
        text-align: left; /* Align title to left */
    }

    .header .company-info {
        text-align: right;
        font-size: 14px;
        line-height: 1.6; /* Improved readability */
    }

    .header .company-info p {
        margin: 0;
    }

    .invoice-title {
        text-align: center;
        font-size: 28px; /* Larger invoice title */
        font-weight: 700;
        margin: 30px 0; /* More vertical spacing */
        color: #555;
    }

    .date-info {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin-top: 10px;
    }

    .table-container {
        width: 100%;
        margin-top: 20px; /* Space above the table */
        margin-bottom: 30px; /* Space below the table */
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
    }

    .invoice-table th,
    .invoice-table td {
        padding: 12px 15px; /* More padding for better spacing */
        text-align: left;
        border: 1px solid #e0e0e0; /* Lighter border for table cells */
    }

    .invoice-table thead th {
        background-color: #f7b801;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
    }

    .invoice-table tbody tr:nth-child(even) {
        background-color: #f9f9f9; /* Zebra striping for readability */
    }

    .invoice-table .subtotal,
    .invoice-table .discount,
    .invoice-table .total {
        background-color: #f7b801; /* Keep the highlighted color */
        color: #fff;
        font-weight: 700; /* Bolder font for totals */
    }
    
    /* Specific styles for the total row */
    .invoice-table tfoot td {
        border-top: 2px solid #f7b801; /* Stronger border for the total row */
        font-weight: 700;
        background-color: #fff; /* Ensure footer background is white */
    }

    .footer {
        text-align: left;
        margin-top: 40px; /* More space above the footer */
        font-size: 14px;
        color: #555;
    }

    .footer .prepared-by {
        font-weight: 700;
        margin-top: 10px; /* Space between "Prepared By" and name */
    }

    /* Print specific styles */
    @media print {
        body {
            -webkit-print-color-adjust: exact; /* For better color reproduction */
            print-color-adjust: exact;
            background-color: #ffffff !important; /* Ensure white background on print */
        }
        .invoice-container {
            box-shadow: none; /* Remove shadow in print */
            border: none; /* Remove border in print */
            margin: 0;
            padding: 0;
            width: 100%; /* Occupy full width on print */
        }
        .no-print {
            display: none; /* Hide download button when printing */
        }
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
                            {{-- Added a class to hide the button during printing --}}
                            <div class="d-flex justify-content-end p-3 no-print"> 
                                <button class="btn btn-danger" onclick="downloadPDF()">Download Invoice PDF</button>
                            </div>

                            <div style="background-color: #fff;">
                                <div class="invoice-container" id="invoiceContent"> {{-- Added ID for easier selection --}}
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
                                            <p>Estimate Date: {{ \Carbon\Carbon::parse($order->sale_date)->format('d-M-Y') }} | Program Date: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d-M-Y') }}</p>
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
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td><strong>Discount:</strong></td>
                                                    <td><strong>{{ number_format($order->discount, 2) }}</strong></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td><strong>Net Amount:</strong></td>
                                                    <td><strong>{{ number_format($order->net_amount, 2) }}</strong></td>
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
</div>

@include('admin_panel.include.footer_include')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        // Select the element with the ID 'invoiceContent' for PDF generation
        const element = document.getElementById('invoiceContent'); 
        const opt = {
            margin: [0.5, 0.5, 0.5, 0.5], // Top, Left, Bottom, Right margins in inches
            filename: 'Invoice_{{ $order->customer_name }}_{{ \Carbon\Carbon::parse($order->sale_date)->format('Ymd') }}.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2, // Increase scale for better image quality in PDF
                logging: true, // Enable logging for debugging
                scrollY: -window.scrollY, // Prevent issues with scrolling
                useCORS: true // Important for images loaded from different origins
            },
            jsPDF: {
                unit: 'pt', // Changed unit to points for more precise control
                format: 'a4', // A4 format is standard
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>