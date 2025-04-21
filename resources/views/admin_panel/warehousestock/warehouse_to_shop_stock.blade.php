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
                    <h6 class="page-title">Warehouse To Office</h6>
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

                                @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    <strong>Opps!</strong> {{ session('error') }}.
                                </div>
                                @endif

                                <form action="{{ route('store-warehouse-to-shop') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
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
                                            <label class="form-label">Current Stock</label>
                                            <input type="text" class="form-control" id="currentStock" readonly>
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="form-label">Transfer Quantity</label>
                                            <input type="number" name="quantity" class="form-control" required min="1">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="form-label">Transfer Date</label>
                                            <input type="date" name="transfer_date" class="form-control" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 h-45">Transfer</button>
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
        $(document).ready(function() {
            $('#productSelect').on('change', function() {
                var stock = $(this).find(':selected').data('stock');
                $('#currentStock').val(stock);
            });
        });

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


            $('#warehouseSelect, #categorySelect, #productSelect').on('change', function() {
                var warehouse = $('#warehouseSelect').val();
                var category = $('#categorySelect').val();
                var product = $('#productSelect').val();

                if (warehouse && category && product) {
                    $.ajax({
                        url: '{{ route("get-stock") }}',
                        type: 'GET',
                        data: {
                            warehouse: warehouse,
                            category: category,
                            product: product
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#currentStock').val(data.stock); // Stock quantity update karein
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching stock:', error);
                        }
                    });
                }
            });


        });
    </script>