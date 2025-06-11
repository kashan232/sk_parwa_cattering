@include('admin_panel.include.header_include')
<div class="page-wrapper default-version">
    @include('admin_panel.include.sidebar_include')
    @include('admin_panel.include.navbar_include')
    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                <h6 class="page-title">Estimated Reports</h6>
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

                                <div class="row mb-4" id="estimateSummary" style="display: none;">
                                    <div class="col-md-6">
                                        <div class="card shadow-lg border-0 rounded-4 mb-4">
                                            <div class="card-body">
                                                <h4 class="card-title text-center mb-4 fw-semibold text-uppercase">
                                                    <i class="las la-chart-bar me-2"></i>Estimate Summary
                                                </h4>
                                                <div class="row text-center gy-4">
                                                    <div class="col-md-6 col-12">
                                                        <div class="p-3 border rounded-3 bg-light">
                                                            <h6 class="mb-1 text-muted">Total Estimates</h6>
                                                            <p class="fw-bold fs-4 text-dark mb-0" id="totalEstimates">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="p-3 border rounded-3 bg-light">
                                                            <h6 class="mb-1 text-muted">Total Amount</h6>
                                                            <p class="fw-bold fs-4 text-success mb-0" id="totalAmount">0.00</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="p-3 border rounded-3 bg-light">
                                                            <h6 class="mb-1 text-muted">Confirmed</h6>
                                                            <p class="fw-bold fs-4 text-primary mb-0" id="confirmedEstimates">0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="p-3 border rounded-3 bg-light">
                                                            <h6 class="mb-1 text-muted">Pending</h6>
                                                            <p class="fw-bold fs-4 text-danger mb-0" id="pendingEstimates">0</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- ApexChart -->
                                    <div class="col-md-6">
                                        <div class="card shadow-sm border-0 rounded-3">
                                            <div class="card-body">
                                                <h3 class="card-title text-center mb-3">Estimate Chart</h3>
                                                <div id="estimateChart" class="my-4"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-4" id="estimateTableCard" style="display: none;">
                                    <div class="card-body">
                                        <h3 class="card-title text-center mb-3">Estimate Report Table</h3>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover mb-0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Event Type</th>
                                                        <th>Sale Date</th>
                                                        <th>Delivery Date</th>
                                                        <th>Total</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="estimateTableBody">
                                                    <!-- Data will be injected here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin_panel.include.footer_include')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $('#filterSalesBtn').on('click', function() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();

        $.ajax({
            url: "{{ route('filter-Estimated-report') }}",
            method: "GET",
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                // Update Summary
                $('#totalEstimates').text(response.total_estimates);
                $('#totalAmount').text(response.total_amount.toFixed(2));
                $('#confirmedEstimates').text(response.confirmed_estimates);
                $('#pendingEstimates').text(response.pending_estimates);
                $('#estimateSummary').show();

                // Draw Chart
                drawEstimateChart(response.confirmed_estimates, response.pending_estimates);

                // Build Table
                let tableRows = '';
                response.estimates.forEach(function(est) {
                    let status = est.status == 1 ? '<span class="badge bg-success">Confirmed</span>' : '<span class="badge bg-warning text-dark">Pending</span>';
                    tableRows += `
                        <tr>
                            <td>${est.customer_name}</td>
                            <td>${est.event_type}</td>
                            <td>${est.sale_date}</td>
                            <td>${est.delivery_date}</td>
                            <td>${parseFloat(est.total_price).toFixed(2)}</td>
                            <td>${status}</td>
                        </tr>`;
                });
                $('#estimateTableBody').html(tableRows);
                $('#estimateTableCard').show();
            }
        });
    });

    function drawEstimateChart(confirmed, pending) {
        let options = {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Estimates',
                data: [confirmed, pending]
            }],
            xaxis: {
                categories: ['Confirmed', 'Pending'],
                labels: {
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                }
            },
            colors: ['#4ba064', '#dc3545'], // Confirmed (green), Pending (red)
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 6,
                    columnWidth: '45%'
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            legend: {
                show: false
            }
        };

        let chart = new ApexCharts(document.querySelector("#estimateChart"), options);
        chart.render();

    }
</script>