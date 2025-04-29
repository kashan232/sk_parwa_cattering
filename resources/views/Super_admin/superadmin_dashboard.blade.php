@include('admin_panel.include.header_include')

<body>
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        <!-- sidebar end -->

        <!-- navbar-wrapper start -->
        @include('admin_panel.include.navbar_include')
        <!-- navbar-wrapper end -->

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Dashboard</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    </div>
                </div>

                <div class="row gy-4 mb-30">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="widget-two box--shadow2 b-radius--5 bg--white">
                            <i class="las la-shopping-bag overlay-icon text--success"></i>
                            <div class="widget-two__icon b-radius--5   bg--info  ">
                                <i class="las la-shopping-bag"></i>
                            </div>
                            <div class="widget-two__content">
                                <h3>2</h3>
                                <p>Categories</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="widget-two box--shadow2 b-radius--5 bg--white">
                            <i class="las la-shopping-bag overlay-icon text--success"></i>

                            <div class="widget-two__icon b-radius--5   bg--success  ">
                                <i class="las la-shopping-bag"></i>
                            </div>

                            <div class="widget-two__content">
                                <h3>2</h3>
                                <p>Sub-Categories</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="widget-two box--shadow2 b-radius--5 bg--white">
                            <i class="las la-share overlay-icon text--danger"></i>

                            <div class="widget-two__icon b-radius--5   bg--danger  ">
                                <i class="las la-share"></i>
                            </div>

                            <div class="widget-two__content">
                                <h3>3</h3>
                                <p>Products</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="widget-two box--shadow2 b-radius--5 bg--white">
                            <i class="las la-shopping-cart overlay-icon text--primary"></i>

                            <div class="widget-two__icon b-radius--5   bg--primary  ">
                                <i class="las la-shopping-cart"></i>
                            </div>

                            <div class="widget-two__content">
                                <h3>3</h3>
                                <p>Orders</p>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Payment Summary</h5>
                        <canvas id="ordersChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Orders by Month</h5>
                        <canvas id="monthOrdersChart" height="100"></canvas>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Payment Amount by Month</h5>
                        <canvas id="paymentAmountChart" height="100"></canvas>
                    </div>
                </div>

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>

    @include('admin_panel.include.footer_include')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Orders Payment Summary Chart
    const ctx = document.getElementById('ordersChart').getContext('2d');

    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Hafiz Zain Shaikh', 'Kashan', 'Waleed Raza'], // order_name or customer_name
            datasets: [
                {
                    label: 'Payable Amount',
                    data: [13750, 13500, 13750],
                    backgroundColor: 'rgba(75, 160, 100, 0.7)',
                    borderRadius: 8,
                },
                {
                    label: 'Advance Paid',
                    data: [3750, 1000, 13750],
                    type: 'line',
                    borderColor: '#ff6b6b',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: '#ff6b6b',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#333',
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        afterLabel: function(context) {
                            const remaining = [10000, 12500, 0];
                            return 'Remaining: ' + remaining[context.dataIndex];
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Customer Orders Overview',
                    color: '#444',
                    font: {
                        size: 18
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#444',
                        font: {
                            size: 13
                        }
                    }
                },
                y: {
                    ticks: {
                        color: '#444',
                        beginAtZero: true
                    }
                }
            }
        }
    });

    // Orders by Month Chart
    const monthOrdersCtx = document.getElementById('monthOrdersChart').getContext('2d');
    const monthOrdersChart = new Chart(monthOrdersCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August'], // example months
            datasets: [{
                label: 'Number of Orders',
                data: [25, 30, 45, 20, 50, 65, 80, 75], // Example number of orders per month
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Orders by Month',
                    color: '#444',
                    font: {
                        size: 18
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#444',
                        font: {
                            size: 13
                        }
                    }
                },
                y: {
                    ticks: {
                        color: '#444',
                        beginAtZero: true
                    }
                }
            }
        }
    });

    // Payment Amount by Month Chart
    const paymentAmountCtx = document.getElementById('paymentAmountChart').getContext('2d');
    const paymentAmountChart = new Chart(paymentAmountCtx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August'], // example months
            datasets: [{
                label: 'Total Payment Amount',
                data: [100000, 150000, 200000, 120000, 250000, 300000, 350000, 400000], // Example total payment per month
                borderColor: 'rgba(75, 160, 100, 1)',
                backgroundColor: 'rgba(75, 160, 100, 0.2)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(75, 160, 100, 1)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Payment Amount by Month',
                    color: '#444',
                    font: {
                        size: 18
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#444',
                        font: {
                            size: 13
                        }
                    }
                },
                y: {
                    ticks: {
                        color: '#444',
                        beginAtZero: true
                    }
                }
            }
        }
    });
    </script>
</body>
