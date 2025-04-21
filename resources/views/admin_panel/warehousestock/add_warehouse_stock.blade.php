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
                    <h6 class="page-title">Add Warehouse Stock</h6>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif

                                <form action="{{ route('store-warehouse-stock') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-xl-4 col-sm-4">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input name="stock_date" type="date" class="datepicker-here form-control bg--white" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Warehouse</label>
                                                <select name="warehouse_id" class="form-control" required>
                                                    <option selected disabled>Select One</option>
                                                    @foreach($Warehouses as $Warehouse)
                                                    <option value="{{ $Warehouse->name }}">{{ $Warehouse->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Supplier Name </label>
                                                <input type="text" class="form-control" placeholder="Enter Name" name="supplier_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="table-responsive">
                                            <table class="productTable table border">
                                                <thead class="border bg--dark">
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Name</th>
                                                        <th>brand</th>
                                                        <th>Quantity<span class="text--danger">*</span></th>
                                                        <th>Price<span class="text--danger">*</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchaseItems">
                                                    <tr>
                                                        <td>
                                                            <select name="item_category[]" class="form-control item-category" required>
                                                                <option value="" disabled selected>Select Category</option>
                                                                @foreach($Category as $Categories)
                                                                <option value="{{ $Categories->category }}">{{ $Categories->category }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="item_name[]" class="form-control item-name" required>
                                                                <option value="" disabled selected>Select Item</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="brand[]" class="form-control brand" readonly> <!-- Readonly brand column -->
                                                        </td>
                                                        <td>
                                                            <input type="number" name="quantity[]" class="form-control quantity" required>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger remove-row">Delete</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-primary mt-4 mb-4" id="addRow">Add More</button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div>
    @include('admin_panel.include.footer_include')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const purchaseItems = document.getElementById('purchaseItems');

            // Event delegation for category selection
            purchaseItems.addEventListener('change', function(e) {
                if (e.target.classList.contains('item-category')) {
                    const categoryId = e.target.value;
                    const row = e.target.closest('tr');
                    const itemSelect = row.querySelector('.item-name');

                    if (categoryId) {
                        fetch(`{{ route('get-items-by-category-product', ':categoryId') }}`.replace(':categoryId', categoryId))
                            .then(response => response.json())
                            .then(items => {
                                itemSelect.innerHTML = '<option value="" disabled selected>Select Item</option>';
                                items.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.product_name;
                                    option.textContent = item.product_name;
                                    itemSelect.appendChild(option);
                                });
                                itemSelect.disabled = false; // Enable item selection
                            })
                            .catch(error => console.error('Error fetching items:', error));
                    } else {
                        itemSelect.innerHTML = '<option value="" disabled selected>Select Item</option>';
                        itemSelect.disabled = true; // Disable item selection
                    }
                }
            });

            // Event delegation for product selection to populate brand
            purchaseItems.addEventListener('change', function(e) {
                if (e.target.classList.contains('item-name')) {
                    const productId = e.target.value;
                    const row = e.target.closest('tr');
                    const brandInput = row.querySelector('.brand');

                    if (productId) {
                        fetch(`{{ route('get-brand-by-itemproduct', ':productId') }}`.replace(':productId', productId))
                            .then(response => response.json())
                            .then(product => {
                                brandInput.value = product.brand ? product.brand : ''; // Handle cases where the brand is not found
                            })
                            .catch(error => console.error('Error fetching brand:', error));
                    }
                }
            });

            // Adding a new row dynamically
            const addRowButton = document.getElementById('addRow');
            addRowButton.addEventListener('click', function() {
                const newRow = `
                <tr>
                    <td>
                        <select name="item_category[]" class="form-control item-category" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($Category as $Categories)
                                <option value="{{ $Categories->category }}">{{ $Categories->category }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="item_name[]" class="form-control item-name" required>
                            <option value="" disabled selected>Select Item</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="brand[]" class="form-control brand" readonly>
                    </td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control quantity" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger remove-row">Delete</button>
                    </td>
                </tr>`;
                purchaseItems.insertAdjacentHTML('beforeend', newRow);
            });

            // Event delegation for removing a row
            purchaseItems.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

        });
    </script>