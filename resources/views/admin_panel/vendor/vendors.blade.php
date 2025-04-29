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
                    <h6 class="page-title">All Vendors</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <form action="" method="GET" class="d-flex gap-2">
                            <div class="input-group w-auto">
                                <input type="search" name="search" class="form-control bg--white" placeholder="Username" value="">
                                <button class="btn btn--primary" type="submit"><i class="la la-search"></i></button>
                            </div>

                        </form>
                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                            data-bs-toggle="modal" data-bs-target="#cuModal" data-modal_title="Add New Vendor">
                            <i class="las la-plus"></i> Add New
                        </button>

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
                                            @foreach($Vendors as $Vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $Vendor->name }}</td>
                                                <td>{{ $Vendor->identity }}</td>
                                                <td>{{ $Vendor->phone }}</td>
                                                <td>{{ $Vendor->address }}</td>
                                                {{-- <td><strong>{{ $Customer->closing_balance ?? '0' }}</strong></td> <!-- Display the closing balance --> --}}
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editVendorBtn"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            data-id="{{ $Vendor->id }}"
                                                            data-name="{{ $Vendor->name }}"
                                                            data-phone="{{ $Vendor->phone }}"
                                                            data-address="{{ $Vendor->address }}">
                                                            <i class="la la-pencil"></i>Edit
                                                        </button>
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
                                <h5 class="modal-title">Add Vendor</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="{{ route('store-vendor') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="vendor_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="vendor_phone">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="vendor_address">
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Vendor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-vendor') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="vendor_id" id="edit_vendor_id">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="vendor_name" id="edit_vendor_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" name="vendor_phone" id="edit_vendor_phone">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="vendor_address" id="edit_vendor_address">
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
        $(document).on('click', '.editVendorBtn', function() {
            const button = $(this);
            $('#edit_vendor_id').val(button.data('id'));
            $('#edit_vendor_name').val(button.data('name'));
            $('#edit_vendor_phone').val(button.data('phone'));
            $('#edit_vendor_address').val(button.data('address'));
        });
    </script>