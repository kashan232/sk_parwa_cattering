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
                    <h6 class="page-title">All Staff</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    
                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="Add New Staff">
                            <i class="las la-plus"></i>Add New </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <div class="table-responsive--sm table-responsive">
                                <table id="example" class="display  table table--light style--two" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staffs as $staff)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $staff->username }}</td>
                                                <td>{{ $staff->name }}</td>
                                                <td><a href="#" class="__cf_email__" data-cfemail="d6a5a2b7b0b096a5bfa2b3f8b5b9bb">{{ $staff->email }}</a>
                                                </td>
                                                <td>
                                                    <span class="badge badge--success">Staff</span>
                                                </td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editCategoryBtn" data-toggle="modal" data-target="#exampleModal" data-staff-id="{{ $staff->id }}" data-staff-name="{{ $staff->name }}" data-staff-username="{{ $staff->username }}" data-staff-email="{{ $staff->email }}">
                                                            <i class="la la-pencil"></i>Edit </button>

                                                        <a class="btn btn-sm btn-outline--dark" href="#" target="_blank">
                                                            <i class="las la-sign-in-alt"></i>Login </a>

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

                            <form action="{{ route('store-staff') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="usertype" class="form-control" required>
                                            <option disabled selected>Select One</option>
                                            <option value="staff">Staff</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input class="form-control" name="password" type="text" required>
                                            <button class="input-group-text generatePassword" type="button">Generate</button>
                                        </div>
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
                                <h5 class="modal-title" id="exampleModalLabel">Edit Staff</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-staff') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="hidden" name="staff_id" id="staff_id">
                                        <input type="text" class="form-control" name="name" id="staff_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" id="staff_username" >
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="staff_email" >
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
            $('.editCategoryBtn').click(function() {
                // Extract category ID and name from data attributes
                var staffId = $(this).data('staff-id');
                var staffname = $(this).data('staff-name');
                var staffusername = $(this).data('staff-username');
                var staffemail = $(this).data('staff-email');

                console.log(staffId,staffname,staffusername,staffemail);
                $('#staff_id').val(staffId);
                $('#staff_name').val(staffname);
                $('#staff_email').val(staffemail);
                $('#staff_username').val(staffusername);

            });
        });
    </script>