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
                                        <div class="col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="product_name" class="form-control" value="{{ $product_details->product_name }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Category</label>
                                                        <select name="category" class="form-control" required>
                                                            <option value="" disabled>Select One</option>
                                                            @foreach($all_category as $category)
                                                            <option value="{{ $category->category }}" {{ $product_details->category == $category->category ? 'selected' : '' }}>
                                                                {{ $category->category }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Brand</label>
                                                        <select name="brand" class="form-control" required>
                                                            <option value="" disabled>Select One</option>
                                                            @foreach($all_brand as $brand)
                                                            <option value="{{ $brand->brand }}" {{ $product_details->brand == $brand->brand ? 'selected' : '' }}>
                                                                {{ $brand->brand }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>



                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Alert Quantity</label>
                                                        <input type="number" name="alert_quantity" class="form-control" value="{{ $product_details->alert_quantity }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Retail Price</label>
                                                        <input type="text" name="retail_price" class="form-control" value="{{ $product_details->retail_price }}">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn--primary w-100 h-45">Update</button>
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