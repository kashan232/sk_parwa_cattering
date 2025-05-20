<!-- meta tags and other links -->
@include('admin_panel.include.header_include')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display table table--light style--two bg--white" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Order No#</th>
                                                <th>Customer Name | Customer ID</th>
                                                <th>Advance</th>
                                                <th>Remaining</th>
                                                <th>Payable Amount</th>
                                                <th>Discount</th>
                                                <th>Total Amount</th>
                                                <th>Order Items</th>
                                                <th>Status</th>
                                                <th>Payment Status</th>
                                                <th>Asiged Status</th>
                                                <th>Order Date</th>
                                                <th>Program Date | Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td class="long-text">
                                                    <span class="fw-bold text--primary">{{ $order->customer_name }}</span>
                                                    <br>
                                                    <span class="text--small ">{{ $order->customer_id }}</span>
                                                </td>
                                                <td>{{ number_format($order->advance_paid, 2) }}</td>
                                                <td>{{ number_format($order->remaining_amount, 2) }}</td>
                                                <td>{{ number_format($order->payable_amount, 2) }}</td>
                                                <td>{{ number_format($order->discount, 2) }}</td>
                                                <td>{{ number_format($order->total_price, 2) }}</td>
                                                <td>
                                                    @php
                                                    $items = json_decode($order->item_name, true);
                                                    @endphp
                                                    @if(is_array($items))
                                                    {{ implode(', ', $items) }}
                                                    @else
                                                    {{ $order->item_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                    $statusColors = [
                                                    'Pending' => 'bg-danger',
                                                    'Confirmed' => 'bg-warning',
                                                    'Preparing' => 'bg-info',
                                                    'Delivered' => 'bg-success',
                                                    'Cancelled' => 'bg-secondary'
                                                    ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$order->order_status] ?? 'bg-dark' }}">
                                                        {{ ucfirst($order->order_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                    $statusColors = [
                                                    'Paid' => 'bg-success',
                                                    'Unpaid' => 'bg-danger',
                                                    ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$order->payment_status] ?? 'bg-dark' }}">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($order->vendorOrderAssigns->isNotEmpty())
                                                    <br>
                                                    <small class="badge bg-info mt-1">
                                                        Assigned Vendors:
                                                    </small>
                                                    <ul class="mt-1" style="padding-left: 10px;">
                                                        @foreach($order->vendorOrderAssigns as $assignment)
                                                        @if($assignment->vendor)
                                                        <li>{{ $assignment->vendor->name }}</li>
                                                        @endif
                                                        @endforeach
                                                    </ul>
                                                    @else
                                                    <span class="badge bg-warning">No Vendor Assigned</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->sale_date)->format('d M Y') }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                                        <br>
                                                    {{ \Carbon\Carbon::parse($order->delivery_time)->format('h:i:s A') }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#assignVendorsModal"
                                                        data-order-id="{{ $order->id }}">
                                                        <i class="fas fa-user-tag"></i> Assign Vendors
                                                    </button>
                                                    <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file-invoice"></i> Invoice
                                                    </a>
                                                    @if($order->payment_status != 'Paid')
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#paymentModal"
                                                        data-id="{{ $order->id }}"
                                                        data-remaining="{{ $order->remaining_amount }}"
                                                        data-paid="{{ $order->advance_paid }}">
                                                        <i class="fas fa-dollar-sign"></i> Payment
                                                    </button>
                                                    @endif

                                                    <a href="{{ route('Voucher.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file-invoice"></i> Payment Voucher
                                                    </a>
                                                    <!-- Gate Pass Button -->
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#gatePassModal"
                                                        data-order-id="{{ $order->id }}">
                                                        <i class="fas fa-truck"></i> Get Pass
                                                    </button>
                                                    <!-- Order Status Update Button -->
                                                    <button class="btn btn-info btn-sm update-status-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-current-status="{{ $order->order_status }}">
                                                        <i class="fas fa-sync"></i> Update Status
                                                    </button>

                                                </td>
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
    <div class="modal fade" id="assignVendorsModal" tabindex="-1" aria-labelledby="assignVendorsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignVendorsModalLabel">Assigned Vendors and Quantities</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="vendorAssignmentsContent" class="p-3">
                        <!-- Vendor Assignments Data will be dynamically populated here -->
                        <p class="text-center">Loading...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm">
                        @csrf
                        <input type="hidden" id="order_id" name="order_id">

                        <div class="mb-3">
                            <label for="remaining_amount" class="form-label">Remaining Amount</label>
                            <input type="text" class="form-control" id="remaining_amount" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="paid_amount" class="form-label">Paid Amount</label>
                            <input type="number" class="form-control" id="paid_amount" name="paid_amount">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Gate Pass Modal -->
    <div class="modal fade" id="gatePassModal" tabindex="-1" aria-labelledby="gatePassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generate Gate Pass</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gatepass.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" id="gatepassOrderId">

                        <div class="mb-3">
                            <label class="form-label">Select Inventory Items</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Stock</th>
                                        <th>Send Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="inventorySelection">
                                    <!-- Dynamic Rows Will Be Added Here -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success btn-sm" id="addMoreInventory">
                                <i class="fas fa-plus"></i> Add More
                            </button>
                        </div>

                        <button type="submit" class="btn btn-warning">Generate Gate Pass</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    @include('admin_panel.include.footer_include')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var paymentModal = document.getElementById("paymentModal");

            paymentModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                var orderId = button.getAttribute("data-id");
                var remainingAmount = parseFloat(button.getAttribute("data-remaining")) || 0;

                document.getElementById("order_id").value = orderId;
                document.getElementById("remaining_amount").value = remainingAmount.toFixed(2);
                document.getElementById("original_remaining").value = remainingAmount.toFixed(2); // Hidden Field
                document.getElementById("paid_amount").value = "";
            });

            document.getElementById("paid_amount").addEventListener("input", function() {
                var originalRemaining = parseFloat(document.getElementById("original_remaining").value); // Safe value
                var paid = parseFloat(this.value) || 0;
                var newRemaining = originalRemaining - paid;

                document.getElementById("remaining_amount").value = newRemaining >= 0 ? newRemaining.toFixed(2) : "0.00";
            });

            document.getElementById("paymentForm").addEventListener("submit", function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch("{{ route('order.payment') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                                confirmButtonColor: '#d33'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: 'Something went wrong while processing the payment!',
                            confirmButtonColor: '#d33'
                        });
                        console.error('Error:', error);
                    });
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let gatePassModal = document.getElementById("gatePassModal");

            gatePassModal.addEventListener("show.bs.modal", function(event) {
                let button = event.relatedTarget;
                let orderId = button.getAttribute("data-order-id");
                document.getElementById("gatepassOrderId").value = orderId;

                fetch("{{ route('get.order.inventory', ':id') }}".replace(':id', orderId))
                    .then(response => response.json())
                    .then(data => {
                        let inventorySelection = document.getElementById("inventorySelection");
                        inventorySelection.innerHTML = "";

                        data.forEach(item => {
                            let row = `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.quantity}</td>
                            <td><input type="number" name="inventory[${item.id}]" min="1" max="${item.quantity}" class="form-control send-qty" data-stock="${item.quantity}" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    `;
                            inventorySelection.innerHTML += row;
                        });
                    });
            });

            // Remove row functionality
            document.getElementById("inventorySelection").addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-row") || e.target.closest(".remove-row")) {
                    e.target.closest("tr").remove();
                }
            });

            // Add more functionality
            document.getElementById("addMoreInventory").addEventListener("click", function() {
                let inventorySelection = document.getElementById("inventorySelection");
                let newRow = `
            <tr>
                <td><input type="text" name="new_item_name[]" class="form-control" placeholder="Item Name"></td>
                <td>N/A</td>
                <td><input type="number" name="new_item_quantity[]" min="1" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
                inventorySelection.innerHTML += newRow;
            });
        });

        $(document).ready(function() {
            $('.update-status-btn').click(function() {
                let orderId = $(this).data('order-id');

                Swal.fire({
                    title: 'Change Order Status',
                    input: 'select',
                    inputOptions: {
                        Confirmed: 'Confirmed',
                        Preparing: 'Preparing',
                        Delivered: 'Delivered',
                        Cancelled: 'Cancelled'
                    },
                    inputPlaceholder: 'Select status',
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                }).then(result => {
                    if (result.isConfirmed) {
                        let selectedStatus = result.value;

                        // Send AJAX request
                        $.ajax({
                            url: "{{ route('order.updateStatus') }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                order_id: orderId,
                                status: selectedStatus
                            },
                            success: function(response) {
                                Swal.fire('Success', 'Order status updated!', 'success').then(() => {
                                    location.reload(); // Refresh table
                                });
                            },
                            error: function() {
                                Swal.fire('Error', 'Something went wrong!', 'error');
                            }
                        });
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const assignVendorsModal = document.getElementById('assignVendorsModal');

            assignVendorsModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const orderId = button.getAttribute('data-order-id');
                const vendorAssignmentsContent = document.getElementById('vendorAssignmentsContent');

                console.log('Order ID:', orderId);

                vendorAssignmentsContent.innerHTML = '<p class="text-center">Loading...</p>';

                axios.post('{{ route("fetch-vendor-assignments") }}', {
                        order_id: orderId
                    })
                    .then(response => {
                        console.log('Response Data:', response.data);

                        const assignments = response.data.assignments;

                        if (assignments.length > 0) {
                            let htmlContent = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Vendor Name</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            assignments.forEach(assignment => {
                                htmlContent += `
                            <tr>
                                <td>${assignment.vendor_name}</td>
                                <td>${assignment.item_name}</td>
                                <td>${assignment.quantity}</td>
                            </tr>`;
                            });

                            htmlContent += `</tbody></table>`;
                            vendorAssignmentsContent.innerHTML = htmlContent;
                        } else {
                            vendorAssignmentsContent.innerHTML = '<p class="text-center text-muted">No assignments found for this order.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error Fetching Assignments:', error);
                        vendorAssignmentsContent.innerHTML = '<p class="text-center text-danger">Error fetching assignments.</p>';
                    });
            });
        });
    </script>