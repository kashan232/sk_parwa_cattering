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
                    <h6 class="page-title">Staff Salary</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                    
                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="Staff Salary">
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
                                <table id="example" class="display  table table--light style--two table" style="width:100%">

                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staffs_salaires as $salary)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $salary->staff_name }}</td>
                                                <td>{{ $salary->staff_year }}</td>
                                                <td>{{ $salary->staff_month }}</td>
                                                <td>{{ $salary->staff_date }}</td>
                                                <td>{{ $salary->staff_amount }}</td>
                                                <td>
                                                    @if($salary->staff_status == 'Paid')
                                                    <span class="badge badge--success">Paid</span>
                                                    @else
                                                    <span class="badge badge--danger">Due</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="button--group">
                                                        <button type="button" class="btn btn-sm btn-outline--primary editCategoryBtn" data-salary-id="{{ $salary->id }}" data-salary-name="{{ $salary->staff_name }}" data-salary-year="{{ $salary->staff_year }}" data-salary-month="{{ $salary->staff_month }}" data-salary-date="{{ $salary->staff_date }}" data-salary-amount="{{ $salary->staff_amount }}">
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
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="{{ route('store-StaffSalary') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Select Staff</label>
                                        <select name="staff_name" id="staff_name" class="form-control">
                                            @foreach($staffs as $staff)
                                            <option value="{{$staff->name}}">{{$staff->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="staff_date" id="staff_date" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Select Year</label>
                                        <select name="staff_year" id="staff_year" class="form-control">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Month</label>
                                        <select name="staff_month" id="staff_month" class="form-control">
                                            <option value="">Select Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="staff_amount" id="staff_amount" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="staff_status" id="staff_status" class="form-control">
                                            <option value="Paid">Paid</option>
                                            <option value="Due">Due</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="cuModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="{{ route('store-StaffSalary') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Select Staff</label>
                                        <select name="staff_name" id="staff_name" class="form-control">
                                            @foreach($staffs as $staff)
                                            <option value="{{$staff->name}}">{{$staff->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="staff_date" id="staff_date" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Select Year</label>
                                        <select name="staff_year" id="staff_year" class="form-control">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Month</label>
                                        <select name="staff_month" id="staff_month" class="form-control">
                                            <option value="">Select Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="staff_amount" id="staff_amount" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="staff_status" id="staff_status" class="form-control">
                                            <option value="Paid">Paid</option>
                                            <option value="Due">Due</option>
                                        </select>
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
                                <h5 class="modal-title" id="exampleModalLabel"> </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('update-staff') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Select Staff</label>
                                        <select name="staff_name" id="staff_name" class="form-control">
                                            @foreach($staffs as $staff)
                                            <option value="{{$staff->name}}">{{$staff->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="staff_date" id="staff_date" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Select Year</label>
                                        <select name="staff_year" id="staff_year" class="form-control">
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Month</label>
                                        <select name="staff_month" id="staff_month" class="form-control">
                                            <option value="">Select Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="staff_amount" id="staff_amount" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="staff_status" id="staff_status" class="form-control">
                                            <option value="Paid">Paid</option>
                                            <option value="Due">Due</option>
                                        </select>
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
        </div>
    </div>
    @include('admin_panel.include.footer_include')

    <script>
        $(document).ready(function() {
            // Edit category button click event
            $('.editCategoryBtn').click(function() {
                // Extract category ID and name from data attributes
                var salaryId = $(this).data('salary-id');
                var salaryname = $(this).data('salary-name');
                var salaryyear = $(this).data('salary-year');
                var salarymonth = $(this).data('salary-month');
                var salarydate = $(this).data('salary-date');
                var salaryamount = $(this).data('salary-amount');

                // $('#staff_id').val(staffId);
                // $('#staff_name').val(staffname);
                // $('#staff_email').val(staffemail);
                // $('#staff_username').val(staffusername);
                // $('#staff_username').val(staffusername);
                // $('#staff_username').val(staffusername);

            });
        });
    </script>