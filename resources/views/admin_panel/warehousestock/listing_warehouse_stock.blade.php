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
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Warehouse Stocks</h6>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <div class="table-responsive--sm table-responsive">
                                    <table id="example" class="display  table table--light style--two bg--white" style="width:100%">
                                        <thead class="border bg--dark text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Warehouse</th>
                                                <th>Supplier</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($WarehouseStocks as $key => $stock)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $stock->stock_date }}</td>
                                                <td>{{ $stock->warehouse_name }}</td>
                                                <td>{{ $stock->supplier_name }}</td>
                                                <td>{{ $stock->category }}</td>
                                                <td>{{ $stock->product_name }}</td>
                                                <td>{{ $stock->model }}</td>
                                                <td>{{ $stock->quantity }}</td>
                                            </tr>
                                            @endforeach

                                            @if($WarehouseStocks->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center text-danger">
                                                    No warehouse stock entries found!
                                                </td>
                                            </tr>
                                            @endif
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