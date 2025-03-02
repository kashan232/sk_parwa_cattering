<!-- meta tags and other links -->
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
                    <h6 class="page-title">All Order</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                       
                        <a href="{{ route('add-order') }}"
                            class="btn btn-outline--primary">
                            <i class="la la-plus"></i>Add New </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display  table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>Name</th> --}}
                                                <th>Customer_Name  |  Customer_Id</th>
                                                <th>Paid Amount</th>
                                                <th>Due Amount</th>
                                                <th>Total Amount</th>
                                                <th>Order Items</th>
                                                <th>Status</th>
                                                <th>Order Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                {{-- <td>{{ $order->customer->name }}</td> --}}
                                                <td class="long-text">
                                                    <span class="fw-bold text--primary">{{ $order->customer->name }}</span>
                                                    <br>
                                                    <span class="text--small ">{{ $order->customer->identity }}</span>
                                                </td>
                                                <td>
                                                    {{ $order->paid_amount }}
                                                </td>
                                                <td>
                                                    {{ $order->due_amount }}
                                                </td>
                                                <td>
                                                    {{ $order->total_amount }}
                                                </td>
                                                <td>
                                                    {{ $order->orderItems->count() }}
                                                </td>
                                                <td>
                                                    @if ($order->status == "pending")
                                                        <span class="badge bg-danger">Pending</span>
                                                    @else
                                                        <span class="badge bg-success">Delivered</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $order->order_date }}
                                                </td>
                                                {{-- <td>
                                                    <strong class="badge badge--danger">{{ $product->alert_quantity }}</strong>
                                                </td> --}}
                                                {{-- <td>{{ $product->unit }}</td>
                                                <td>{{ $product->wholesale_price }}</td>
                                                <td>{{ $product->retail_price }}</td> --}}
                                                <td>
                                                    <div class="button--group">
                                                        <a href="{{ route('edit-product',['id' => $order->id ]) }}"
                                                            class="btn btn-sm btn-outline--primary ms-1 editBtn"><i
                                                                class="las la-pen"></i> Edit</a>
                                                        <a href="{{ route('all-order-item',$order->id) }}"
                                                            class="btn btn-sm btn-outline--primary ms-1 editBtn"><i
                                                                class="las la-pen"></i> View Items</a>
                                                    </div>
                                                </td>
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
