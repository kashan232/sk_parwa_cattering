@include('admin_panel.include.header_include')

<style>
    .search-container {
        position: relative;
        width: 100%;
        /* Adjust width as needed */
    }

    #productSearch {
        width: 100%;
        padding: 8px;
    }

    #searchResults {
        position: absolute;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .search-result-item {
        padding: 10px;
        cursor: pointer;
    }

    .search-result-item:hover {
        background-color: #f0f0f0;
    }
</style>

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
                    <h6 class="page-title">Add Menu Estimate</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="https://script.viserlab.com//admin/purchase/all"
                            class="btn btn-sm btn-outline--primary">
                            <i class="la la-undo"></i> Back</a>
                    </div>
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
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <form action="{{ route('store-menu') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <!-- Customer Info -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group" id="supplier-wrapper">
                                                <label class="form-label">Clients</label>
                                                <input name="customer_name" type="text" class="form-control bg--white" required>
                                            </div>
                                        </div>

                                        <!-- Order Date -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Estimate Date</label>
                                                <input name="sale_date" type="date" class="form-control bg--white" value="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Program Date</label>
                                                <input type="date" name="delivery_date" class="form-control bg--white" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <!-- Delivery Date -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Venue</label>
                                                <input type="text" name="Venue" class="form-control bg--white" required>

                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>No Of Guest</label>
                                                <input type="number" name="person_program" class="form-control bg--white" required>

                                            </div>
                                        </div>
                                        <!-- Event Type -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Event Type</label>
                                                <input type="text" name="event_type" class="form-control bg--white" required>

                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Service Type </label>
                                                <select name="food_type" id="food_type" class="form-control bg--white">
                                                    <option value="Buffy">Buffy</option>
                                                    <option value="Table">Table</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="number" name="mobile_number" class="form-control bg--white" required>

                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <label>Reference Name</label>
                                                <input type="text" name="reference_name" class="form-control bg--white" required>

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
                                                        <input type="text" id="total_price" name="total_price" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                {{-- NEW: Discount Field --}}
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Discount (Rs)</label>
                                                        <input type="number" id="discount" name="discount" class="form-control" value="0" min="0">
                                                    </div>
                                                </div>
                                                {{-- NEW: Net Amount Field --}}
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Net Amount</label>
                                                        <input type="text" id="net_amount" name="net_amount" class="form-control" readonly>
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


            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->

    </div>
    @include('admin_panel.include.footer_include')

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
                // Trigger calculation when item price changes
                calculateTotal(row);
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

                calculateAllTotals(); // Call new function to calculate all totals
            }

            // --- MODIFIED: Function to calculate total price, discount, and net amount ---
            function calculateAllTotals() {
                var totalPrice = 0;

                $('.total').each(function() {
                    totalPrice += parseFloat($(this).val()) || 0;
                });

                $('#total_price').val(totalPrice.toFixed(2));

                // Get discount amount
                var discount = parseFloat($('#discount').val()) || 0;

                // Calculate Net Amount
                var netAmount = totalPrice - discount;

                // Ensure net amount doesn't go below zero if discount is too high
                if (netAmount < 0) {
                    netAmount = 0;
                }

                $('#net_amount').val(netAmount.toFixed(2));
            }
            // --- END MODIFIED ---

            // Discount change hone par payable amount update karna
            $(document).on('input', '#discount', function() {
                calculateAllTotals(); // Now calls the new combined function
            });

            // Row delete hone par bhi total update hoga
            $('#purchaseItems').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateAllTotals(); // Now calls the new combined function
            });

            // Add a new row
            $('#addRow').click(function() {
                const newRow = createNewRow();
                $('#purchaseItems').append(newRow);
                calculateAllTotals(); // Recalculate totals after adding a new row
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
            // Remove a row (this was duplicated, keeping one)
            // $('#purchaseItems').on('click', '.remove-row', function() {
            //     $(this).closest('tr').remove();
            //     calculateAllTotals(); // Ensure this calls the correct function
            // });

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
                    const listItem = `<li class="list-group-item search-result-item" data-category="${product.category_id}" data-subcategory="${product.subcategory_id}" data-product-name="${product.name}" data-unit="${product.unit}" data-price="${product.price}">
                ${product.name} (${product.category_name} - ${product.subcategory_name}) - Rs. ${product.price}
                </li>`;
                    searchResults.append(listItem);
                });
            }

            // Add searched product as a new row
            $('#searchResults').on('click', '.search-result-item', function() {
                const category_id = $(this).data('category');
                const subcategory_id = $(this).data('subcategory'); // Get subcategory ID
                const productName = $(this).data('product-name');
                const unit = $(this).data('unit');
                const price = $(this).data('price');

                // Create a new row
                const newRowHtml = createNewRow(category_id, subcategory_id, productName, unit, price);
                const newRow = $(newRowHtml);
                $('#purchaseItems').append(newRow);

                // Set selected values for the newly added row
                newRow.find('.item-category').val(category_id).trigger('change'); // Trigger change to load subcategories
                // Wait for subcategories to load before setting subcategory and item
                setTimeout(() => {
                    newRow.find('.item-subcategory').val(subcategory_id).trigger('change'); // Trigger change to load items
                    setTimeout(() => {
                        newRow.find('.item-name').val(productName);
                        newRow.find('.unit').val(unit);
                        newRow.find('.price').val(price);
                        calculateTotal(newRow); // Calculate total for the new row
                    }, 200); // Small delay to ensure items are loaded
                }, 200); // Small delay to ensure subcategories are loaded

                $('#searchResults').html(''); // Clear search results

                calculateAllTotals(); // Recalculate all totals including the new row
            });

            // Initial calculation when the page loads (useful if there are pre-filled rows)
            calculateAllTotals();
        });
    </script>

</body>