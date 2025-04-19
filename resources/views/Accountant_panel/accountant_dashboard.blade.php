@include('admin_panel.include.header_include')
<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">{{ @Auth::user()->name  }} Accountant Dashboard</h6>
                </div>

                <!-- Cash in Hand Card -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-lg text-white bg-danger rounded-3">
                            <div class="card-body d-flex justify-content-between align-items-center p-4">
                                <div>
                                    <h4 class="mb-2 text-white">Cash in Hand</h4>
                                    <h2 class="text-white">Rs. {{ $cashInHand }}</h2>
                                </div>
                                <div>
                                    <i class="las la-wallet" style="font-size: 50px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Expense Chart -->
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-3">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="mb-0">Monthly Expenses (Static)</h5>
                            </div>
                            <div class="card-body">
                                <div id="expenseChart" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>

    @include('admin_panel.include.footer_include')

    <!-- ApexCharts Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js"></script>

    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            series: [{
                name: 'Expense',
                data: [1200, 900, 1100, 750, 950, 1300, 1000, 1050, 900, 950, 800, 1200, 1150, 990, 1250]
            }],
            xaxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'],
                title: { text: 'Day of Month' }
            },
            colors: ['#4ba064'],
            yaxis: {
                title: { text: 'Amount (Rs)' }
            }
        };

        var chart = new ApexCharts(document.querySelector("#expenseChart"), options);
        chart.render();
    </script>
</body>
