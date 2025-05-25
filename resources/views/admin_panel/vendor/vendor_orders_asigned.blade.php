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
                    <h6 class="page-title">Vendor Order Asigned</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                <div class="table-responsive p-3">
                                    @foreach($orders as $order)
                                    <div class="border mb-4 p-3 rounded shadow-sm">
                                        <h5>Order: {{ $order->order_name }} | Customer: {{ $order->customer_name }}</h5>
                                        <p><strong>Event Type:</strong> {{ $order->event_type }} | <strong>Venue:</strong> {{ $order->Venue }}</p>
                                        <p><strong>Delivery Date:</strong> {{ $order->delivery_date }} | <strong>Delivery Time:</strong> {{ $order->delivery_time }}</p>

                                        @php
                                        $vendorGroups = $order->vendorOrderAssigns->groupBy('vendor_id');
                                        @endphp

                                        @foreach($vendorGroups as $vendorId => $assignments)
                                        @php
                                        $vendor = $assignments->first()->vendor;
                                        @endphp

                                        <div class="border p-3 mb-3 bg-light rounded">
                                            <h6>Vendor: {{ $vendor->name }} ({{ $vendor->phone }})</h6>

                                            <form action="{{ route('vendor.ledger.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Item ID</th>
                                                            <th>Assigned Quantity</th>
                                                            <th>Assign Date</th>
                                                            <th>Enter Amount</th>
                                                            <th>Enter Received Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($assignments as $assign)
                                                        @php
                                                        $ledgerEntry = $ledgers->firstWhere(function($ledger) use ($assign, $order, $vendor) {
                                                        return $ledger->order_id == $order->id &&
                                                        $ledger->vendor_id == $vendor->id &&
                                                        $ledger->item_id == $assign->item_id &&
                                                        $ledger->amount !== null &&
                                                        $ledger->received_date !== null;
                                                        });
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $order->items[$assign->item_id - 1] ?? 'N/A' }}</td>
                                                            <td>{{ $assign->quantity }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($assign->assign_date)->format('d-m-Y') }}</td>

                                                            <td>
                                                                <input
                                                                    type="number"
                                                                    step="0.01"
                                                                    name="amounts[{{ $assign->id }}]"
                                                                    class="form-control"
                                                                    value="{{ $ledgerEntry->amount ?? '' }}"
                                                                    {{ $ledgerEntry ? 'readonly' : '' }}>
                                                            </td>
                                                            <td>
                                                                <input
                                                                    type="date"
                                                                    name="dates[{{ $assign->id }}]"
                                                                    class="form-control"
                                                                    value="{{ $ledgerEntry ? \Carbon\Carbon::parse($ledgerEntry->received_date)->format('Y-m-d') : '' }}"
                                                                    {{ $ledgerEntry ? 'readonly' : '' }}>
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                                @if(!$assignments->every(function($assign) use ($order, $vendor, $ledgers) {
                                                return $ledgers->contains(function($ledger) use ($assign, $order, $vendor) {
                                                return $ledger->order_id == $order->id &&
                                                $ledger->vendor_id == $vendor->id &&
                                                $ledger->item_id == $assign->item_id &&
                                                $ledger->amount !== null &&
                                                $ledger->received_date !== null;
                                                });
                                                }))
                                                <button type="submit" class="btn btn-sm btn-primary mt-1 mb-1">Save Vendor Details</button>
                                                @else
                                                <button class="btn btn-sm btn-success mt-1 mb-1">Action Taken</button>
                                                @endif

                                            </form>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>