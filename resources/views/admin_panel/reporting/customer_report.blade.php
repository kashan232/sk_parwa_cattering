@include('admin_panel.include.header_include')
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')

    <div class="body-wrapper">
        <div class="bodywrapper__inner">

            <div class="d-flex mb-4 justify-content-between align-items-center">
                <h4 class="page-title">📊 Customer Reports</h4>
            </div>

            <!-- Customer Selection -->
            <div class="card mb-4">
                <div class="card-body">
                    <label for="CustomerSelect" class="form-label fw-bold">Select Customer</label>
                    <select class="form-select" id="CustomerSelect">
                        <option value="">-- Select Customer --</option>
                        @foreach($Customers as $Customer)
                        <option value="{{ $Customer->id }}">{{ $Customer->name }} (ID: {{ $Customer->id }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Report Section -->
            <div id="reportSection" class="d-none">
                <!-- Summary Cards -->
                <div class="row">
                    @php
                        $statuses = [
                            ['label' => 'Total Orders', 'id' => 'totalOrders', 'color' => 'success', 'icon' => 'fa-list'],
                            ['label' => 'Delivered', 'id' => 'deliveredOrders', 'color' => 'primary', 'icon' => 'fa-truck'],
                            ['label' => 'Pending', 'id' => 'pendingOrders', 'color' => 'warning', 'icon' => 'fa-clock'],
                            ['label' => 'Cancelled', 'id' => 'cancelledOrders', 'color' => 'danger', 'icon' => 'fa-ban'],
                            ['label' => 'Confirmed', 'id' => 'confirmedOrders', 'color' => 'info', 'icon' => 'fa-check-circle'],
                            ['label' => 'Preparing', 'id' => 'preparingOrders', 'color' => 'secondary', 'icon' => 'fa-utensils'],
                        ];
                    @endphp
                    @foreach($statuses as $status)
                    <div class="col-md-4 mb-3">
                        <div class="card border-start border-{{ $status['color'] }} border-4 shadow-sm h-100">
                            <div class="card-body text-center">
                                <h6><i class="fas {{ $status['icon'] }} me-2"></i> {{ $status['label'] }}</h6>
                                <h3 id="{{ $status['id'] }}" class="text-{{ $status['color'] }} fw-bold">0</h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Payment Summary -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-start border-dark border-4 shadow-sm">
                            <div class="card-body text-center">
                                <h6><i class="fas fa-wallet me-2"></i>Total Payable</h6>
                                <h4 id="totalPayable" class="text-dark fw-bold">Rs. 0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-start border-success border-4 shadow-sm">
                            <div class="card-body text-center">
                                <h6><i class="fas fa-money-bill-wave me-2"></i>Total Paid</h6>
                                <h4 id="totalPaid" class="text-success fw-bold">Rs. 0</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3 text-center fw-bold">Order Status Overview</h5>
                        <div id="orderStatusChart"></div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin_panel.include.footer_include')
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.getElementById("CustomerSelect").addEventListener("change", function () {
        let customerId = this.value;
        if (customerId) {
            let url = "{{ route('admin.customer.report.data', ':id') }}".replace(':id', customerId);
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    document.getElementById("reportSection").classList.remove("d-none");
                    document.getElementById("totalOrders").textContent = data.total_orders;
                    document.getElementById("deliveredOrders").textContent = data.delivered;
                    document.getElementById("pendingOrders").textContent = data.pending;
                    document.getElementById("cancelledOrders").textContent = data.cancelled;
                    document.getElementById("confirmedOrders").textContent = data.confirmed;
                    document.getElementById("preparingOrders").textContent = data.preparing;
                    document.getElementById("totalPayable").textContent = "Rs. " + data.total_payable;
                    document.getElementById("totalPaid").textContent = "Rs. " + data.total_paid;

                    let chart = new ApexCharts(document.querySelector("#orderStatusChart"), {
                        chart: {
                            type: 'donut',
                            height: 350
                        },
                        labels: ['Delivered', 'Pending', 'Cancelled', 'Confirmed', 'Preparing'],
                        series: [data.delivered, data.pending, data.cancelled, data.confirmed, data.preparing],
                        colors: ['#4ba064', '#ffc107', '#dc3545', '#0dcaf0', '#6c757d']
                    });
                    chart.render();
                });
        } else {
            document.getElementById("reportSection").classList.add("d-none");
        }
    });
</script>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
