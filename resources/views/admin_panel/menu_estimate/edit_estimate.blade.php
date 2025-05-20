<!-- meta tags and other links -->
@include('admin_panel.include.header_include')

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
                    <h6 class="page-title">Edit Menu Estimate</h6>
                </div>

                <div class="row gy-3">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> {{ session('error') }}.
                                </div>
                                @endif
                                <form action="{{ route('menu-estimate.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">
                                        <!-- Customer Info -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group" id="supplier-wrapper">
                                                <label class="form-label">Clients</label>
                                                <input name="customer_name" type="text" class="form-control bg--white" value="{{ $order->customer_name }}">
                                            </div>
                                        </div>

                                        <!-- Order Date -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Estimate Date</label>
                                                <input name="sale_date" type="date" class="form-control bg--white" value="{{ $order->sale_date }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Program Date</label>
                                                <input type="date" name="delivery_date" class="form-control bg--white" value="{{ $order->delivery_date }}" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <!-- Delivery Date -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Venue</label>
                                                <input type="text" name="Venue" class="form-control bg--white" value="{{ $order->Venue }}">

                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Person Program</label>
                                                <input type="number" name="person_program" class="form-control bg--white" value="{{ $order->person_program }}">

                                            </div>
                                        </div>
                                        <!-- Event Type -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Event Type</label>
                                                <input type="text" name="event_type" class="form-control bg--white" value="{{ $order->event_type }}">

                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Food Type </label>
                                                <select name="food_type" id="food_type" class="form-control bg--white">
                                                    <option value="Buffy" {{ $order->food_type == 'Buffy' ? 'selected' : '' }}>Buffy</option>
                                                    <option value="Table" {{ $order->food_type == 'Table' ? 'selected' : '' }}>Table</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="table-responsive">
                                            <table class="productTable table border">
                                                <thead class="border bg--dark">
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Sub-Category</th>
                                                        <th>Item</th>
                                                        <th>Unit</th>
                                                        <th>Quantity<span class="text--danger">*</span></th>
                                                        <th>Price<span class="text--danger">*</span></th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchaseItems">
                                                    @php
                                                    use App\Models\Category;
                                                    use App\Models\Subcategory;

                                                    $categories = json_decode($order->item_category);
                                                    $subcategories = json_decode($order->item_subcategory);
                                                    $items = json_decode($order->item_name);
                                                    $units = json_decode($order->unit);
                                                    $quantities = json_decode($order->quantity);
                                                    $prices = json_decode($order->price);
                                                    $totals = json_decode($order->total);
                                                    @endphp
                                                    @foreach($items as $index => $item)
                                                    <tr>
                                                        {{-- Category Dropdown --}}
                                                        <td>
                                                            <select name="item_category[]" style="width:120px;" class="form-control item-category">
                                                                @foreach($Category as $cat)
                                                                <option value="{{ $cat->id }}" {{ $cat->id == $categories[$index] ? 'selected' : '' }}>
                                                                    {{ $cat->category }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        {{-- Subcategory Dropdown --}}
                                                        <td>
                                                            <select name="item_subcategory[]" style="width:120px;" class="form-control item-subcategory">
                                                                @foreach(App\Models\Subcategory::where('category_id', $categories[$index])->get() as $sub)
                                                                <option value="{{ $sub->id }}" {{ $sub->id == $subcategories[$index] ? 'selected' : '' }}>
                                                                    {{ $sub->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        {{-- Product (Item) Dropdown --}}
                                                        <td>
                                                            <select name="item_name[]" style="width:120px;" class="form-control item-name">
                                                                @foreach($all_product as $product)
                                                                <option value="{{ $product->name }}" {{ $product->name == $items[$index] ? 'selected' : '' }}>
                                                                    {{ $product->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        {{-- Other Inputs --}}
                                                        <td><input type="text" name="unit[]" style="width:120px;" class="form-control unit" value="{{ $units[$index] }}"></td>
                                                        <td><input type="number" name="quantity[]" style="width:120px;" class="form-control quantity" value="{{ $quantities[$index] }}"></td>
                                                        <td><input type="number" name="price[]" style="width:120px;" class="form-control price" value="{{ $prices[$index] }}"></td>
                                                        <td><input type="text" name="total[]" style="width:120px;" class="form-control total" value="{{ $totals[$index] }}" readonly></td>
                                                        <td><button type="button" class="btn btn-danger remove-row">X</button></td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>


                                            </table>
                                            <button type="button" class="btn btn-primary mt-4 mb-4" id="addRow">Add More</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 col-sm-6">
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Total Price</label>
                                                        <input type="text" id="total_price" name="total_price" class="form-control" value="{{ $order->total_price }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </form>
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

    <script>
        $(document).ready(function() {
            $(document).on('change', '.item-category', function() {
                var category_id = $(this).val();
                var subCategoryDropdown = $(this).closest('tr').find('.item-subcategory');

                if (category_id) {
                    var url = "{{ route('get.subcategories', ':id') }}".replace(':id', category_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            subCategoryDropdown.empty().append('<option value="" selected disabled>Select Sub Category</option>');
                            $.each(data, function(index, subcategory) {
                                subCategoryDropdown.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Subcategory select hone per items fetch karna
            $(document).on('change', '.item-subcategory', function() {
                var subCategory_id = $(this).val();
                var category_id = $(this).closest('tr').find('.item-category').val();
                var itemDropdown = $(this).closest('tr').find('.item-name');

                if (category_id && subCategory_id) {
                    var url = "{{ route('get.items', [':category', ':subcategory']) }}"
                        .replace(':category', category_id)
                        .replace(':subcategory', subCategory_id);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            itemDropdown.empty().append('<option value="" selected disabled>Select Item</option>');
                            $.each(data, function(index, item) {
                                itemDropdown.append('<option value="' + item.name + '" data-unit="' + item.unit + '" data-price="' + item.price + '">' + item.name + '</option>');
                            });
                        }
                    });
                }
            });


            // Item select hone par unit aur price set karna
            $(document).on('change', '.item-name', function() {
                var selectedOption = $(this).find(":selected");
                var unit = selectedOption.data('unit');
                var price = selectedOption.data('price');

                var row = $(this).closest('tr');
                row.find('.unit').val(unit);
                row.find('.price').val(price);
            });

            $(document).on('input', '.quantity, .price', function() {
                var row = $(this).closest('tr');
                calculateTotal(row);
            });

            // Function to calculate row-wise total
            function calculateTotal(row) {
                var quantity = parseFloat(row.find('.quantity').val()) || 0;
                var price = parseFloat(row.find('.price').val()) || 0;
                var total = quantity * price;

                row.find('.total').val(total.toFixed(2));

                calculateTotalPrice();
            }

            // Function to calculate total price and payable amount
            function calculateTotalPrice() {
                var totalPrice = 0;

                $('.total').each(function() {
                    totalPrice += parseFloat($(this).val()) || 0;
                });

                $('#total_price').val(totalPrice.toFixed(2));

                var discount = parseFloat($('#discount').val()) || 0;
                var payableAmount = totalPrice - discount;
                $('#payable_amount').val(payableAmount.toFixed(2));
            }

            // Discount change hone par payable amount update karna
            $(document).on('input', '#discount', function() {
                calculateTotalPrice();
            });

            // Row delete hone par bhi total update hoga
            $('#purchaseItems').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotalPrice();
            });

            // Add a new row
            $('#addRow').click(function() {
                const newRow = createNewRow();
                $('#purchaseItems').append(newRow);
            });

            // Function to create a new row
            function createNewRow(category = '', subCategory = '', productName = '', unit = '', price = '') {
                return `
            <tr>
                <td>
                    <select name="item_category[]" class="form-control item-category" style="width:120px;" required>
                        <option value="" disabled ${category ? '' : 'selected'}>Select Category</option>
                        @foreach($Category as $Categories)
                            <option value="{{ $Categories->id }}">{{ $Categories->category }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="item_subcategory[]" class="form-control item-subcategory" style="width:120px;" required>
                        <option value="" disabled ${subCategory ? '' : 'selected'}>Select Sub Category</option>
                    </select>
                </td>
                <td>
                    <select name="item_name[]" class="form-control item-name" style="width:120px;" required>
                        <option value="" disabled ${productName ? '' : 'selected'}>Select Item</option>
                    </select>
                </td>
                <td><input type="text" name="unit[]" class="form-control unit" style="width:120px;" readonly></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" style="width:120px;" required></td>
                <td><input type="number" name="price[]" class="form-control price" style="width:120px;" required></td>
                <td><input type="number" name="total[]" class="form-control total" style="width:120px;" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">Delete</button>
                </td>
            </tr>`;
            }
            // Remove a row
            $('#purchaseItems').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateTotalPrice();
            });

            // Search product functionality
            $('#productSearch').on('keyup', function() {
                const query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('search-products') }}",
                        type: 'GET',
                        data: {
                            q: query
                        },
                        success: displaySearchResults,
                        error: function(error) {
                            console.error('Error in product search:', error);
                        }
                    });
                } else {
                    $('#searchResults').html('');
                }
            });

            // Display search results
            function displaySearchResults(products) {
                const searchResults = $('#searchResults');
                searchResults.html('');
                products.forEach(product => {
                    const listItem = `<li class="list-group-item search-result-item" data-category="${product.category}" data-product-name="${product.product_name}" data-price="${product.retail_price}">
                    ${product.category} - ${product.product_name} - ${product.retail_price}
                </li>`;
                    searchResults.append(listItem);
                });
            }

            // Add searched product as a new row
            $('#searchResults').on('click', '.search-result-item', function() {
                const category = $(this).data('category');
                const productName = $(this).data('product-name');
                const price = $(this).data('price');

                const newRow = createNewRow(category, productName, price);
                $('#purchaseItems').append(newRow);
                $('#searchResults').html('');
                calculateTotalPrice();
            });
        });
    </script>