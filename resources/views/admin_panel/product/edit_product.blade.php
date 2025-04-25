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
                    <h6 class="page-title">Edit Product</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">
                        <a href="{{ route('all-product') }}"
                            class="btn btn-sm btn-outline--primary">
                            <i class="la la-undo"></i> Back</a>
                    </div>
                </div>
                <div class="row mb-none-30">
                    <div class="col-lg-12 col-md-12 mb-30">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('success') }}.
                                </div>
                                @endif
                                <form action="{{ route('update-product',['id'=> $product_details->id ]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="image-upload">
                                                    <div class="thumb">
                                                        <div class="avatar-preview">
                                                            <div class="profilePicPreview" style="background-image: url({{ asset('product_images/' . $product_details->image) }})">
                                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="avatar-edit">
                                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                            <label for="profilePicUpload1" class="bg--success">Upload Image</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $product_details->name }}">

                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="form-group" id="category-wrapper">
                                                            <label class="form-label">Category</label>
                                                            <select name="category" class="form-control" id="categorySub" onchange="ll()" required>
                                                                <option value="" disabled>Select One</option>
                                                                @foreach($all_category as $category)
                                                                <option value="{{ $category->id }}" {{ $product_details->category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->category }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class=" col-sm-6">
                                                    <div class="form-group">
                                                        <div class="form-group" id="brand-wrapper">
                                                            <label class="form-label">Sub Category</label>
                                                            <select name="subcategory_id" class="form-control" required id="subCategorySub" data-selected="{{ $product_details->subcategory_id }}">
                                                                <option value="" disabled selected>First Select Category</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Unit(UoM)</label>
                                                        <select name="unit_id" class="select2-basic form-control" required>
                                                            <option value="" disabled>Select One</option>
                                                            @foreach($all_unit as $unit)
                                                            <option value="{{ $unit->id }}" {{ $product_details->unit_id == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->unit }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="number" name="price" class="form-control" value="{{ $product_details->price }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                    </div>
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
            let preSelectedCategory = "{{ $product_details->category_id }}";
            let preSelectedSubcategory = $('#subCategorySub').data('selected');

            function loadSubCategories(categoryId, callback) {
                var url = "{{ route('get.subcategories', ':id') }}".replace(':id', categoryId);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#subCategorySub').empty().append('<option value="" disabled>Select Sub Category</option>');
                        $.each(data, function(key, value) {
                            $('#subCategorySub').append('<option value="' + value.id + '" ' + (value.id == preSelectedSubcategory ? 'selected' : '') + '>' + value.name + '</option>');
                        });
                        if (callback) callback();
                    }
                });
            }

            // On category change (manual user change)
            $('#categorySub').change(function() {
                let selectedCat = $(this).val();
                loadSubCategories(selectedCat);
            });

            // On load, if editing and category is pre-selected
            if (preSelectedCategory) {
                $('#categorySub').val(preSelectedCategory).trigger('change');
                loadSubCategories(preSelectedCategory);
            }
        });
    </script>