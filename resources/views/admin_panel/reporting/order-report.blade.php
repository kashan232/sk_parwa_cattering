<!-- meta tags and other links -->
@include('admin_panel.include.header_include')

<!-- page-wrapper start -->
<div class="page-wrapper default-version">
    <style>
        #ordersTable tfoot tr {
            border-top: 2px solid #dee2e6;
            font-size: 1rem;
        }
    </style>
    @include('admin_panel.include.sidebar_include')
    <!-- sidebar end -->

    <!-- navbar-wrapper start -->
    @include('admin_panel.include.navbar_include')
    <!-- navbar-wrapper end -->

    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                <h6 class="page-title">Orders Reports</h6>
            </div>
            <div class="row mb-none-30">
                <div class="col-lg-12 col-md-12 mb-30">
                    <div class="card">
                        <div class="card-body">
                            <form id="salesFilterForm">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row gy-4 justify-content-end align-items-end">
                                            <div class="col-lg-4">
                                                <label class="required">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" id="start_date" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="required">End Date</label>
                                                <input type="date" class="form-control" name="end_date" id="end_date" required>
                                            </div>

                                            <div class="col-lg-4">
                                                <button class="btn btn--primary h-45 w-100" type="button" id="filterSalesBtn">
                                                    <i class="la la-filter"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-4">
                                            <table class="table table-bordered" id="ordersTable">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Items</th>
                                                        <th>Sale Date</th>
                                                        <th>Delivery Date</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Paid</th>
                                                        <th>Remaining</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="salesTableBody"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card mt-4 shadow-sm border-0 rounded-3" id="totalsCard" style="display: none;">
                                        <div class="card-body py-4">
                                            <h3 class="card-title text-center mb-4">Totals Summary</h3>
                                            <div class="row text-center">
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <h3 class="text-muted mb-2">Total Payable</h3>
                                                    <p class="text-success fw-bold fs-3" id="totalPayableText">0.00</p>
                                                </div>
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <h3 class="text-muted mb-2">Total Paid</h3>
                                                    <p class="text-primary fw-bold fs-3" id="totalPaidText">0.00</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <h3 class="text-muted mb-2">Total Remaining</h3>
                                                    <p class="text-danger fw-bold fs-3" id="totalRemainingText">0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card mt-4">
                                            <div class="card-body">
                                                <h5 class="card-title">Orders Status Chart</h5>
                                                <div id="ordersChart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- bodywrapper__inner end -->
            </div><!-- body-wrapper end -->
        </div>
        @include('admin_panel.include.footer_include')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function renderOrdersChart(data) {
        const totalStatus = {
            Delivered: 0,
            Pending: 0,
            Preparing: 0,
            Cancelled: 0,
        };

        Object.values(data).forEach(d => {
            totalStatus.Delivered += d.Delivered;
            totalStatus.Pending += d.Pending;
            totalStatus.Preparing += d.Preparing;
            totalStatus.Cancelled += d.Cancelled;
        });

        const options = {
            chart: {
                type: 'donut',
                height: 400
            },
            labels: ['Delivered', 'Pending', 'Preparing', 'Cancelled'],
            series: [
                totalStatus.Delivered,
                totalStatus.Pending,
                totalStatus.Preparing,
                totalStatus.Cancelled
            ],
            colors: ['#4ba064', '#f0ad4e', '#5bc0de', '#d9534f'],
            dataLabels: {
                enabled: true
            },
        };

        const chart = new ApexCharts(document.querySelector("#ordersChart"), options);
        chart.render();
    }

    $('#filterSalesBtn').click(function() {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();

        $.ajax({
            url: "{{ route('filter-order-report') }}",
            method: "GET",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                renderOrdersChart(response.graphData);

                let html = '';
                let totalPayable = 0,
                    totalPaid = 0,
                    totalRemaining = 0;

                response.orders.forEach(order => {
                    const items = JSON.parse(order.item_name || '[]'); // handle JSON items
                    let itemList = '<ul>';
                    items.forEach(item => {
                        itemList += `<li>${item}</li>`;
                    });
                    itemList += '</ul>';

                    const remaining = order.payable_amount - order.advance_paid;

                    html += `
        <tr>
            <td>${order.customer_name}</td>
            <td>${itemList}</td>
            <td>${order.sale_date}</td>
            <td>${order.delivery_date}</td>
            <td>${order.order_status}</td>
            <td>${order.payable_amount}</td>
            <td>${order.advance_paid}</td>
            <td>${remaining}</td>
        </tr>
    `;

                    totalPayable += parseFloat(order.payable_amount);
                    totalPaid += parseFloat(order.advance_paid);
                    totalRemaining += parseFloat(remaining);
                });

                $('#totalPayableText').text(totalPayable.toFixed(2));
                $('#totalPaidText').text(totalPaid.toFixed(2));
                $('#totalRemainingText').text(totalRemaining.toFixed(2));
                $('#totalsCard').show(); // show card


                $('#salesTableBody').html(html);

            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
</script>