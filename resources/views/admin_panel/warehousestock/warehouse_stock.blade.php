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
                    <h6 class="page-title">All Purchases</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="{{ route('add-purchase') }}"
                            class="btn btn-outline--primary h-45">
                            <i class="la la-plus"></i>Add New </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10 bg--transparent">
                            <div class="card-body p-0 ">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Date</th>
                                                <th>Warehouse</th>
                                                <th>Category</th>
                                                <th>Item Name</th>
                                                <th>Supplier Name </th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Purchases as $purchase)
                                            <tr>
                                                <td>{{ $purchase->invoice_no }}</td>
                                                <td>{{ $purchase->purchase_date }}</td>
                                                <td>{{ $purchase->warehouse_id }}</td>
                                                <td>{{ str_replace(['[', ']', '"'], '', $purchase->item_category) }}</td>
                                                <td>{{ str_replace(['[', ']', '"'], '', $purchase->item_name) }}</td>
                                                <td>{{ str_replace(['[', ']', '"'], '', $purchase->supplier_name ?? 'Null') }}</td>

                                                <td>{{ str_replace(['[', ']', '"'], '', $purchase->quantity) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div><!-- card end -->
                    </div>
                </div>
            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div>
    @include('admin_panel.include.footer_include')
   