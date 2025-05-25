@include('admin_panel.include.header_include')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
        padding: 10px 0px;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #1cc88a, #138d66);
        padding: 10px 0px;

    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6c23e, #e0a800);
        padding: 10px 0px;

    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc, #1e9db7);
        padding: 10px 0px;
    }


    .hover-card {
        transition: 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .card h6 {
        font-size: 14px;
        color: #333;
    }
</style>

<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Dashboard</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    </div>
                </div>
                <!-- Order Payments Heading -->
                <div class="mb-3">
                    <h4 class="fw-bold">📦 Order Payments</h4>
                    <hr>
                </div>
                <div class="row">
                    <!-- Total Order Amount -->
                    <div class="col-md-3">
                        <div class="card text-white bg-gradient-primary shadow rounded-3 border-0 hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-1 text-white">Total Order Amount</h6>
                                        <h3 class="fw-bold mb-0 text-white">Rs. 500,000</h3>
                                    </div>
                                    <div class="icon bg-white text-primary rounded-circle p-3">
                                        <i class="fas fa-file-invoice-dollar fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paid Amount -->
                    <div class="col-md-3">
                        <div class="card text-white bg-gradient-success shadow rounded-3 border-0 hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-1 text-white">Paid Amount</h6>
                                        <h3 class="fw-bold mb-0 text-white">Rs. 350,000</h3>
                                    </div>
                                    <div class="icon bg-white text-success rounded-circle p-3">
                                        <i class="fas fa-hand-holding-usd fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remaining Amount -->
                    <div class="col-md-3">
                        <div class="card text-white bg-gradient-warning shadow rounded-3 border-0 hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-1 text-white">Remaining Amount</h6>
                                        <h3 class="fw-bold mb-0 text-white">Rs. 150,000</h3>
                                    </div>
                                    <div class="icon bg-white text-warning rounded-circle p-3">
                                        <i class="fas fa-wallet fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Estimated Amount -->
                    <div class="col-md-3">
                        <div class="card text-white bg-gradient-info shadow rounded-3 border-0 hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-1 text-white">Pending Estimated</h6>
                                        <h3 class="fw-bold mb-0 text-white">Rs. 600,000</h3>
                                    </div>
                                    <div class="icon bg-white text-info rounded-circle p-3">
                                        <i class="fas fa-chart-line fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 mb-3">
                    <h4 class="fw-bold">🚚 Order Status</h4>
                    <hr>
                </div>

                <div class="row">
                    <!-- Delivered Orders -->
                    <div class="col-md-2">
                        <div class="card bg-light shadow-sm border-0 text-center hover-card">
                            <div class="card-body">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <h6 class="fw-bold">Delivered</h6>
                                <p class="fs-5 fw-semibold">120</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="col-md-2">
                        <div class="card bg-light shadow-sm border-0 text-center hover-card">
                            <div class="card-body">
                                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                <h6 class="fw-bold">Pending</h6>
                                <p class="fs-5 fw-semibold">80</p>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmed Orders -->
                    <div class="col-md-2">
                        <div class="card bg-light shadow-sm border-0 text-center hover-card">
                            <div class="card-body">
                                <i class="fas fa-check-double fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">Confirmed</h6>
                                <p class="fs-5 fw-semibold">60</p>
                            </div>
                        </div>
                    </div>

                    <!-- Preparing Orders -->
                    <div class="col-md-2">
                        <div class="card bg-light shadow-sm border-0 text-center hover-card">
                            <div class="card-body">
                                <i class="fas fa-utensils fa-2x text-info mb-2"></i>
                                <h6 class="fw-bold">Preparing</h6>
                                <p class="fs-5 fw-semibold">45</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="col-md-2">
                        <div class="card bg-light shadow-sm border-0 text-center hover-card">
                            <div class="card-body">
                                <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                <h6 class="fw-bold">Cancelled</h6>
                                <p class="fs-5 fw-semibold">20</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card bg-light shadow-sm border-0 text-center hover-card">
                            <div class="card-body">
                                <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">Total Estimates</h6>
                                <p class="fs-5 fw-semibold">85</p> {{-- Replace 85 with your dynamic count if needed --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 mb-3">
                    <h4 class="fw-bold">🚚 Orders</h4>
                    <hr>
                </div>

                <div class="mb-3">
                    <label for="orderFilter" class="form-label fw-bold">Filter By:</label>
                    <select id="orderFilter" class="form-select w-auto">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <div id="orderStatusChart" style="height: 400px;" class="bg-white"></div>

                <div class="mt-5 mb-3">
                    <h4 class="fw-bold">🚚 Orders Payment</h4>
                    <hr>
                </div>
                <div class="mb-3">
                    <label for="paymentFilter" class="form-label fw-bold">Filter By:</label>
                    <select id="paymentFilter" class="form-select" style="max-width: 200px;">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <!-- Chart Container -->
                <div id="paymentStatusChart" class="bg-white"></div>

                <div class="mt-5 mb-3">
                    <h4 class="fw-bold">🚚 Purchase Status</h4>
                    <hr>
                </div>
                <div class="container mt-4">
                    <!-- Heading for Purchase Items -->
                    <!-- First row: Total Categories, Total Brands, Total Products -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Categories</h5>
                                    <p class="card-text display-6" id="totalCategories">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Brands</h5>
                                    <p class="card-text display-6" id="totalBrands">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-warning">
                                <div class="card-body">
                                    <h5 class="card-title">Total Products</h5>
                                    <p class="card-text display-6" id="totalProducts">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second row: Purchase Amounts -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Total Purchase Amount</h5>
                                    <p class="card-text display-6" id="totalPurchaseAmount">PKR 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-danger">
                                <div class="card-body">
                                    <h5 class="card-title">Total Purchase Return Amount</h5>
                                    <p class="card-text display-6" id="totalPurchaseReturnAmount">PKR 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-secondary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Claim Return Amount</h5>
                                    <p class="card-text display-6" id="totalClaimReturnAmount">PKR 0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @include('admin_panel.include.footer_include')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Static dummy data filled in for demonstration
        const orderStats = {
            daily: {
                categories: ['2025-03-07', '2025-03-08', '2025-03-09', '2025-03-10'],
                series: [{
                        name: 'Delivered',
                        data: [2, 4, 1, 3]
                    },
                    {
                        name: 'Pending',
                        data: [1, 3, 2, 4]
                    },
                    {
                        name: 'Preparing',
                        data: [0, 2, 3, 1]
                    },
                    {
                        name: 'Canceled',
                        data: [1, 0, 2, 1]
                    }
                ]
            },
            weekly: {
                categories: ['Week 1 of March', 'Week 2 of March', 'Week 3 of March'],
                series: [{
                        name: 'Delivered',
                        data: [7, 10, 5]
                    },
                    {
                        name: 'Pending',
                        data: [3, 5, 2]
                    },
                    {
                        name: 'Preparing',
                        data: [4, 6, 3]
                    },
                    {
                        name: 'Canceled',
                        data: [2, 1, 3]
                    }
                ]
            },
            monthly: {
                categories: ['January 2025', 'February 2025', 'March 2025'],
                series: [{
                        name: 'Delivered',
                        data: [25, 30, 40]
                    },
                    {
                        name: 'Pending',
                        data: [10, 15, 20]
                    },
                    {
                        name: 'Preparing',
                        data: [8, 12, 18]
                    },
                    {
                        name: 'Canceled',
                        data: [5, 7, 6]
                    }
                ]
            }
        };

        // Chart config
        const options = {
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    endingShape: 'rounded'
                }
            },
            colors: ['#4CAF50', '#FFC107', '#17A2B8', '#DC3545'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: orderStats.daily.series,
            xaxis: {
                categories: orderStats.daily.categories,
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top'
            },
        };

        const chart = new ApexCharts(document.querySelector("#orderStatusChart"), options);
        chart.render();

        // Filter change handler
        document.getElementById('orderFilter').addEventListener('change', function() {
            const selected = this.value;
            chart.updateOptions({
                series: orderStats[selected].series,
                xaxis: {
                    categories: orderStats[selected].categories
                }
            });
        });
    </script>


    <script>
        const paymentStats = {
            daily: {
                categories: ['ORD001', 'ORD002', 'ORD003'],
                series: [{
                        name: 'Advance Paid',
                        data: [500, 700, 400]
                    },
                    {
                        name: 'Remaining',
                        data: [1000, 300, 600]
                    },
                    {
                        name: 'Discount',
                        data: [100, 50, 80]
                    },
                    {
                        name: 'Payable Amount',
                        data: [1400, 1100, 1000]
                    },
                    {
                        name: 'Total Amount',
                        data: [1500, 1150, 1080]
                    }
                ]
            },
            weekly: {
                categories: ['Week 1', 'Week 2', 'Week 3'],
                series: [{
                        name: 'Advance Paid',
                        data: [1200, 800, 900]
                    },
                    {
                        name: 'Remaining',
                        data: [400, 700, 600]
                    },
                    {
                        name: 'Discount',
                        data: [100, 120, 90]
                    },
                    {
                        name: 'Payable Amount',
                        data: [1600, 1500, 1400]
                    },
                    {
                        name: 'Total Amount',
                        data: [1700, 1620, 1490]
                    }
                ]
            },
            monthly: {
                categories: ['March 2025', 'April 2025'],
                series: [{
                        name: 'Advance Paid',
                        data: [2000, 1800]
                    },
                    {
                        name: 'Remaining',
                        data: [1000, 1200]
                    },
                    {
                        name: 'Discount',
                        data: [150, 200]
                    },
                    {
                        name: 'Payable Amount',
                        data: [2800, 2800]
                    },
                    {
                        name: 'Total Amount',
                        data: [2950, 3000]
                    }
                ]
            }
        };

        const paymentChartOptions = {
            chart: {
                type: 'bar',
                height: 500,
                toolbar: {
                    show: true
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            colors: ['#4CAF50', '#DC3545', '#FFC107', '#17A2B8', '#6c757d'],
            xaxis: {
                categories: paymentStats.daily.categories,
                labels: {
                    style: {
                        fontSize: '14px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Amount (PKR)',
                    style: {
                        fontWeight: 600,
                        fontSize: '14px'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(val) {
                        return "PKR " + val.toLocaleString();
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center',
                fontSize: '14px',
                fontWeight: 500,
                markers: {
                    radius: 10
                }
            },
            series: paymentStats.daily.series
        };

        const paymentChart = new ApexCharts(document.querySelector("#paymentStatusChart"), paymentChartOptions);
        paymentChart.render();

        // Filter change
        document.getElementById('paymentFilter').addEventListener('change', function() {
            const selected = this.value;
            paymentChart.updateOptions({
                series: paymentStats[selected].series,
                xaxis: {
                    categories: paymentStats[selected].categories
                }
            });
        });
    </script>




</body>