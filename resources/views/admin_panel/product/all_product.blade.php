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
                    <h6 class="page-title">All Products</h6>
                    <div class="d-flex flex-wrap justify-content-end gap-2 align-items-center breadcrumb-plugins">

                        <a href="{{ route('add-product') }}" class="btn btn-outline--primary">
                            <i class="la la-plus"></i>Add New </a>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card b-radius--10">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="display  table table--light style--two bg--white"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Subcategory</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($all_products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    @if($product->image)
                                                    <img src="{{ asset('product_images/' . $product->image) }}" alt="image" width="50">
                                                    @else
                                                    <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->category ?? 'N/A' }}</td>
                                                <td>{{ $product->subcategory->name ?? 'N/A' }}</td>
                                                <td>{{ $product->unit->unit ?? 'N/A' }}</td>
                                               
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    <div class="button--group">
                                                        <a href="{{ route('edit-product', ['id' => $product->id]) }}" class="btn btn-sm btn-outline--primary ms-1">
                                                            <i class="las la-pen"></i> Edit
                                                        </a>
                                                        <button class="btn btn-danger delete-product" data-id="{{ $product->id }}">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    <!-- table end -->
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.delete-product').forEach(button => {
                button.addEventListener('click', function() {
                    let productId = this.getAttribute('data-id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you really want to delete this product?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('delete.product') }}", {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({
                                        id: productId
                                    })
                                }).then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire("Deleted!",
                                                "The product has been deleted.",
                                                "success")
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire("Error!", data.message, "error");
                                    }
                                }).catch(error => {
                                    console.error("Error:", error);
                                    Swal.fire("Error!", "Something went wrong.",
                                        "error");
                                });
                        }
                    });
                });
            });
        });
    </script>