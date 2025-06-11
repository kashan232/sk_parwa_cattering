@include('admin_panel.include.header_include')
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')

    <div class="body-wrapper">
        <div class="bodywrapper__inner">

            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h4 class="page-title">📊 Vendor Ledger Reports</h4>
            </div>

            <!-- Vendor Selection -->
            <div class="card mb-4">
                <div class="card-body">
                    <label for="VendorSelect" class="form-label fw-bold">Select Vendor</label>
                    <select class="form-select" id="VendorSelect">
                        <option value="">-- Select Vendor --</option>
                        @foreach($Vendors as $Vendors)
                        <option value="{{ $Vendors->id }}">{{ $Vendors->name }} (ID: {{ $Vendors->id }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="reportSection" class="d-none">

            </div>
        </div>
        @include('admin_panel.include.footer_include')
    </div>
</div>
<script>
    $('#VendorSelect').on('change', function() {
        const vendorId = $(this).val();
        if (!vendorId) return;

        $.ajax({
            url: "{{ route('admin.vendor.report') }}",
            method: 'POST',
            data: {
                vendor_id: vendorId,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                $('#reportSection').removeClass('d-none').html(renderVendorReport(res));
            }
        });
    });

    function renderVendorReport(data) {
        let html = `
    <div class="card">
        <div class="card-header bg-primary text-white fw-bold">
            Vendor Ledger: ${data.vendor.name}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Date Received</th>
                    </tr>
                </thead>
                <tbody>`;

        data.ledgerEntries.forEach(entry => {
            html += `
            <tr>
                <td>${entry.order_id ?? 'N/A'}</td>
                <td>${entry.item_name ?? 'N/A'}</td>
                <td>${entry.quantity}</td>
                <td>${entry.amount ?? 'Pending'}</td>
                <td>${entry.received_date}</td>
            </tr>`;
        });

        html += `
                </tbody>
            </table>

            <div class="mt-4 border-top pt-3">
                <h6><strong>Total Quantity:</strong> ${data.summary.total_quantity}</h6>
                <h6><strong>Total Amount:</strong> Rs. ${data.summary.total_amount ?? 0}</h6>
            </div>
        </div>
    </div>`;
        return html;
    }
</script>