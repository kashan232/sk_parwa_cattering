@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10 p-4 shadow">
                            <h3 class="mb-4 text-center">Assign Order to Vendor</h3>

                            <form method="POST" action="{{ route('assign-order-to-vendor') }}">
                                @csrf

                                <!-- Vendor Select -->
                                <div class="mb-3">
                                    <label for="vendorSelect" class="form-label">Select Vendor</label>
                                    <select class="form-select" id="vendorSelect" name="vendor_id" required>
                                        <option value="">-- Select Vendor --</option>
                                        @foreach($Vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }} ({{ $vendor->identity }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Order Select -->
                                <div class="mb-3">
                                    <label for="orderSelect" class="form-label">Select Order</label>
                                    <select class="form-select" id="orderSelect" name="order_id" required onchange="showOrderDetails()">
                                        <option value="">-- Select Order --</option>
                                        @foreach($orders as $order)
                                        <option
                                            value="{{ $order->id }}"
                                            data-venue="{{ $order->Venue }}"
                                            data-person="{{ $order->person_program }}"
                                            data-event="{{ $order->event_type }}"
                                            data-name="{{ $order->order_name ?? 'N/A' }}">
                                            Order #{{ $order->id }} - {{ $order->customer_name }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- Order Details -->
                                <div id="orderDetails" style="display: none;">
                                    <div class="mb-2">
                                        <strong>Venue:</strong> <span id="venueText"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Person Program:</strong> <span id="personText"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Event Type:</strong> <span id="eventTypeText"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Order Name:</strong> <span id="orderNameText"></span>
                                    </div>
                                </div>

                                <!-- Assign Date -->
                                <div class="mb-3 mt-4">
                                    <label for="assignDate" class="form-label">Assign Date</label>
                                    <input type="date" class="form-control" id="assignDate" name="assign_date" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Assign Order</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- Yahan Modal Bana Sakte hain agar baad me chaho to --}}
            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')

    <script>
        function showOrderDetails() {
            var select = document.getElementById('orderSelect');
            var selectedOption = select.options[select.selectedIndex];

            if (select.value !== "") {
                document.getElementById('orderDetails').style.display = 'block';
                document.getElementById('venueText').innerText = selectedOption.getAttribute('data-venue') || 'N/A';
                document.getElementById('personText').innerText = selectedOption.getAttribute('data-person') || 'N/A';
                document.getElementById('eventTypeText').innerText = selectedOption.getAttribute('data-event') || 'N/A';
                document.getElementById('orderNameText').innerText = selectedOption.getAttribute('data-name') || 'N/A';
            } else {
                document.getElementById('orderDetails').style.display = 'none';
            }
        }
    </script>
</body>