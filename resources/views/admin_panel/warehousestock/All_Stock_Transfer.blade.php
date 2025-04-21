@include('admin_panel.include.header_include')

<body>
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">

        <!-- sidebar start -->
        @include('admin_panel.include.sidebar_include')
        <!-- sidebar end -->

        <!-- navbar-wrapper start -->
        @include('admin_panel.include.navbar_include')
        <!-- navbar-wrapper end -->

        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Stock Transfer List</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display  table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Warehouse Name</th>
                                                <th>Category</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Transfer Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($StockTransfers as $key => $stock)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $stock->warehouse_name }}</td>
                                                <td>{{ $stock->category }}</td>
                                                <td>{{ $stock->product_name }}</td>
                                                <td>{{ $stock->quantity }}</td>
                                                <td>{{ $stock->transfer_date }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div>
    @include('admin_panel.include.footer_include')