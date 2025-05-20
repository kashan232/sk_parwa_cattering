@include('admin_panel.include.header_include')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10 p-4 shadow">
                            <h3 class="mb-4 text-center">Assign Items to Vendors</h3>

                            <!-- Order Selection -->
                            <div class="mb-3">
                                <label for="orderSelect" class="form-label">Select Order</label>
                                <select class="form-select" id="orderSelect" required>
                                    <option value="">-- Select Order --</option>
                                    @foreach($orders as $order)
                                    <option value="{{ $order->id }}">
                                        Order #{{ $order->id }} - {{ $order->customer_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Order Details and Item Assignment -->
                            <div id="orderDetails" style="display: none;">
                                <h5 class="mb-3">Order Items</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity/Unit</th>
                                            <th>Select Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsContainer">
                                    </tbody>
                                </table>

                                <div class="d-grid">
                                    <button type="button" class="btn btn-success" onclick="assignItemsToVendors()">Assign Items to Vendors</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')

    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('orderSelect').addEventListener('change', function() {
            let orderId = this.value;
            if (orderId) {
                fetchOrderDetails(orderId);
            } else {
                document.getElementById('orderDetails').style.display = 'none';
            }
        });

        function fetchOrderDetails(orderId) {
            axios.post('{{ route("fetch-order-details") }}', {
                    order_id: orderId
                })
                .then(response => {
                    const itemsContainer = document.getElementById('itemsContainer');
                    itemsContainer.innerHTML = '';

                    response.data.items.forEach(item => {
                        let vendorOptions = '<option value="">-- Select Vendor --</option>';
                        @foreach($Vendors as $vendor)
                        vendorOptions += `<option value="{{ $vendor->id }}">{{ $vendor->name }} ({{ $vendor->identity }})</option>`;
                        @endforeach

                        itemsContainer.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.quantity} ${item.unit}</td>
                        <td>
                            <input type="number" class="form-control" name="quantity[${item.id}]" placeholder="Enter Quantity" min="1">
                        </td>
                        <td>
                            <select class="form-select" name="vendor[${item.id}]">
                                ${vendorOptions}
                            </select>
                        </td>
                    </tr>
                `;
                    });

                    document.getElementById('orderDetails').style.display = 'block';
                })
                .catch(error => {
                    console.error(error);
                    alert('Error fetching order details.');
                });
        }

        function assignItemsToVendors() {
            const orderId = document.getElementById('orderSelect').value;
            const vendorAssignments = {};
            let allFieldsFilled = true;

            document.querySelectorAll('select[name^="vendor"]').forEach(select => {
                const itemId = select.name.match(/\[(\d+)\]/)[1];
                const vendorId = select.value;
                const quantityInput = document.querySelector(`input[name="quantity[${itemId}]"]`);
                const quantity = quantityInput ? quantityInput.value : 0;

                if (!vendorId || quantity <= 0) {
                    allFieldsFilled = false;
                }

                vendorAssignments[itemId] = {
                    vendor_id: vendorId,
                    quantity: quantity
                };
            });

            if (!allFieldsFilled) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please fill all quantities and select vendors for each item.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107'
                });
                return; // Stop the function execution
            }

            if (Object.keys(vendorAssignments).length > 0 && orderId) {
                axios.post('{{ route("assign-order-to-vendor") }}', {
                        order_id: orderId,
                        assignments: vendorAssignments
                    })
                    .then(response => {
                        Swal.fire({
                            title: 'Success!',
                            text: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#4ba064'
                        });
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error assigning items.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#dc3545'
                        });
                    });
            }
        }
    </script>

</body>