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
                    <h6 class="page-title">Orders Delivery Alerts</h6>
                    <span class="badge badge-warning">
                        Orders Alert: {{ $ordersAlertCount }} orders with delivery within 5 days.
                    </span>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display  table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Delivery Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ordersWithAlert as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->customer_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d-m-Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- table end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin_panel.include.footer_include')
</body>
