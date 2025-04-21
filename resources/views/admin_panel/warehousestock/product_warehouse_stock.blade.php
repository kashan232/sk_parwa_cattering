@include('admin_panel.include.header_include')

<body>
    <div class="page-wrapper default-version">
        @include('admin_panel.include.sidebar_include')
        @include('admin_panel.include.navbar_include')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="d-flex mb-30 flex-wrap gap-3 justify-content-between align-items-center">
                    <h6 class="page-title">Search Product Warehouse Stock</h6>
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

                                <form id="salesFilterForm">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row gy-4 justify-content-end align-items-end">
                                                <div class="col-lg-3">
                                                    <label class="form-label">Warehouse</label>
                                                    <select name="warehouse_name" class="form-control" id="warehouseSelect" required>
                                                        <option selected disabled>Select One</option>
                                                        @foreach($Warehouses as $Warehouse)
                                                        <option value="{{ $Warehouse->name }}">{{ $Warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category" class="form-control" id="categorySelect" required>
                                                        <option selected disabled>Select One</option>
                                                        @foreach($Categories as $Category)
                                                        <option value="{{ $Category->category }}">{{ $Category->category }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-3">
                                                    <label class="form-label">Product</label>
                                                    <select name="product_name" class="form-control" id="productSelect" required>
                                                        <option selected disabled>Select One</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3">
                                                    <label class="form-label">Model</label>
                                                    <input type="text" class="form-control" name="model">
                                                </div>

                                                <div class="col-lg-3">
                                                    <button class="btn btn--primary h-45 w-100" type="button" id="filterSalesBtn">
                                                        <i class="la la-filter"></i> Filter
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive mt-4">
                                    <table class="table border" id="stockTable">
                                        <thead class="border bg--dark text-white">
                                            <tr>
                                                <th>Warehouse</th>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Model</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Filtered stock data will be appended here -->
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin_panel.include.footer_include')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categorySelect').on('change', function() {
                var categoryName = $(this).val();
                if (categoryName) {
                    $.ajax({
                        url: '{{ route("get-products-by-category") }}',
                        type: 'GET',
                        data: {
                            categoryName: categoryName
                        },
                        dataType: 'json',
                        success: function(data) {
                            var productSelect = $('#productSelect');
                            productSelect.empty().append('<option selected disabled>Select One</option>');

                            $.each(data, function(index, product) {
                                productSelect.append(
                                    '<option value="' + product.product_name + '" data-brand="' + product.brand + '">' +
                                    product.product_name + '</option>'
                                );
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching products:', error);
                        }
                    });
                } else {
                    $('#productSelect').empty().append('<option selected disabled>Select One</option>');
                }
            });

            $('#productSelect').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var brand = selectedOption.data('brand');

                $('input[name="model"]').val(brand); // Assign brand to the model input
            });

            $('#filterSalesBtn').on('click', function() {
                var warehouseName = $('#warehouseSelect').val();
                var categoryName = $('#categorySelect').val();
                var productName = $('#productSelect').val();

                if (warehouseName && categoryName && productName) {
                    $.ajax({
                        url: '{{ route("filter-warehouse-stock") }}',
                        type: 'GET',
                        data: {
                            warehouse_name: warehouseName,
                            category: categoryName,
                            product_name: productName
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#stockTable tbody').empty();

                            $.each(data, function(index, value) {
                                var quantity = value.quantity ? value.quantity : '0'; // Default to '0' if not set
                                var brand = value.brand ? value.brand : 'N/A'; // Handle missing brand

                                $('#stockTable tbody').append(
                                    '<tr>' +
                                    '<td>' + warehouseName + '</td>' +
                                    '<td>' + categoryName + '</td>' +
                                    '<td>' + value.product_name + '</td>' +
                                    '<td>' + brand + '</td>' + // Display brand
                                    '<td>' + quantity + '</td>' +
                                    '</tr>'
                                );
                            });

                            // Show modal after populating data (if applicable)
                            $('#stockModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching stock data:', error);
                        }
                    });
                } else {
                    alert('Please select all fields.');
                }
            });

        });
    </script>