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
                    <h6 class="page-title">All Customer</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <form action="" method="GET" class="d-flex gap-2">
                            <div class="input-group w-auto">
                                <input type="search" name="search" class="form-control bg--white" placeholder="Username" value="">
                                <button class="btn btn--primary" type="submit"><i class="la la-search"></i></button>
                            </div>

                        </form>
                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="Add New Customer">
                            <i class="las la-plus"></i>Add New </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        @if (session()->has('success'))
                        <div class="alert alert-success">
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                        @endif
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--sm table-responsive">
                                    <table class="table--light style--two table">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Unique Identity</th>
                                                <th>Phone </th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Customers as $Customer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $Customer->name }}</td>
                                                <td>{{ $Customer->identity }}</td>
                                                <td>{{ $Customer->phone }}</td>
                                                <td>{{ $Customer->address }}</td>
                                                {{-- <td><strong>{{ $Customer->closing_balance ?? '0' }}</strong></td> <!-- Display the closing balance --> --}}
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editcustomerbtn" data-toggle="modal" data-target="#exampleModal" data-customer-id="{{ $Customer->id }}" data-customer-name="{{ $Customer->customer_name }}" data-customer-phone="{{ $Customer->customer_phone }}"
                                                            data-customer-address="{{ $Customer->address }}">
                                                            <i class="la la-pencil"></i>Edit </button>
                                                    </div>



                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Create Update Modal -->
                <div class="modal fade" id="cuModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="{{ route('store-customer') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="customer_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="customer_phone">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="customer_address">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-customer') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="hidden" name="customer_id" id="customer_id">
                                        <input type="text" class="form-control" name="customer_name" id="edit_customer_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="customer_phone" id="edit_customer_phone">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="edit_customer_address" name="customer_address">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>
    @include('admin_panel.include.footer_include')

    <script>
        $(document).ready(function() {
            // Edit category button click event
            $('.editcustomerbtn').click(function() {
                // Extract category ID and name from data attributes
                var customerId = $(this).data('customer-id');
                var customername = $(this).data('customer-name');
                var customerphone = $(this).data('customer-phone');
                var customeraddress = $(this).data('customer-address');

                console.log(customerId, customername, customeremail, customerphone, customeraddress);

                $('#customer_id').val(customerId);
                $('#edit_customer_name').val(customername);
                $('#edit_customer_phone').val(customerphone);
                $('#edit_customer_address').val(customeraddress);

            });
        });

        $(document).ready(function() {
            $('.customerRecoveryBtn').click(function() {
                var customerId = $(this).data('customer-id');
                var customerName = $(this).data('customer-name');
                var closingBalance = parseFloat($(this).data('closing-balance'));

                $('#recovery_customer_id').val(customerId);
                $('#recovery_customer_name').val(customerName);
                $('#recovery_closing_balance').val(closingBalance);
                $('#updated_closing_balance').val(closingBalance); // Set initial updated balance

                // Clear previous inputs
                $('#recovery_amount').val('');
                $('#recovery_date').val('');
            });

            // Calculate updated closing balance on recovery amount change
            $('#recovery_amount').on('input', function() {
                var closingBalance = parseFloat($('#recovery_closing_balance').val());
                var recoveryAmount = parseFloat($(this).val()) || 0;
                var updatedBalance = closingBalance - recoveryAmount;

                $('#updated_closing_balance').val(updatedBalance);
            });
        });

        $(document).ready(function() {
            $('.customerCreditBtn').click(function() {
                var customerId = $(this).data('customer-id');
                var customerName = $(this).data('customer-name');

                $('#credit_customer_id').val(customerId);
                $('#credit_customer_name').val(customerName);

                $('#credit_amount').val(''); // Clear previous input
            });
        });
    </script>