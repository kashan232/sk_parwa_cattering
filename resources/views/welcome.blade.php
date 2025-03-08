<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>SK PARWA</title>
    <link rel="icon" type="image/png" href="order_page/assets/images/favicon.png">
    <link rel="stylesheet" href="order_page/assets/css/all.min.css">
    <link rel="stylesheet" href="order_page/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="order_page/assets/css/nice-select.css">
    <link rel="stylesheet" href="order_page/assets/css/slick.css">
    <link rel="stylesheet" href="order_page/assets/css/venobox.min.css">
    <link rel="stylesheet" href="order_page/assets/css/ranger_slider.css">
    <link rel="stylesheet" href="order_page/assets/css/animate.css">
    <link rel="stylesheet" href="order_page/assets/css/scroll_button.css">
    <link rel="stylesheet" href="order_page/assets/css/custom_spacing.css">
    <link rel="stylesheet" href="order_page/assets/css/select2.min.css">
    <link rel="stylesheet" href="order_page/assets/css/colorfulTab.min.css">
    <link rel="stylesheet" href="order_page/assets/css/jquery.animatedheadline.css">
    <link rel="stylesheet" href="order_page/assets/css/animated_barfiller.css">
    <link rel="stylesheet" href="order_page/assets/css/style.css">
    <link rel="stylesheet" href="order_page/assets/css/responsive.css">
    <style>
        .btn-close {
            filter: invert(1);
        }
    </style>
</head>

<body>

    <!--==========================
        HEADER START
    ===========================-->
    <header>
        <div class="container container_large">
            <div class="row">
                <div class="col-xl-12 col-md-12 d-none d-md-block">
                    <div class="header_left text-center">
                        <p>Welcome To SK Parwa</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--==========================
        HEADER END
    ===========================-->


    <!--==========================
        MENU START
    ===========================-->
    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container container_large">
            <a class='navbar-brand' href='index.html'>
                <img src="order_page/assets/images/logo.png" alt="RESTINA" class="img-fluid w-100">
            </a>
        </div>
    </nav>
    <!--==========================
        MENU END
    ===========================-->


    <!--==========================
        BREADCRUMB AREA START
    ===========================-->
    <section class="breadcrumb_area" style="background: url(order_page/assets/images/breadcrumb_bg.jpg);">
        <div class="container">
            <div class="row wow fadeInUp">
                <div class="col-12">
                    <div class="breadcrumb_text text-center">
                        <h1>Welcome To SK Parwa <br> Online Order</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==========================
        BREADCRUMB AREA END
    ===========================-->


    <!--==========================
        MENU STYLE 03 START
    ===========================-->
    <section class="menu_grid_view mt_120 xs_mt_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 order-2 wow fadeInLeft">
                    <div class="menu_sidebar sticky_sidebar">
                        <div class="sidebar_wizard sidebar_category mt_25">
                            <h2>Categories</h2>
                            <ul>
                                @foreach($all_categories as $category)
                                <li>
                                    <a href="#">
                                        {{ $category->category }} <span>({{ $category->products_count }})</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-2">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-xl-4 col-sm-6 wow fadeInUp">
                            <div class="single_menu">
                                <div class="single_menu_img">
                                    <img src="order_page/assets/images/menu_img_2.jpg" alt="menu" class="img-fluid w-100">
                                </div>
                                <div class="single_menu_text">
                                    <a class="category" href="#">{{ $product->category->category }}</a>
                                    <a class="title" href="#">
                                        {{ $product->name }} <span class="unit">({{ $product->unit->unit }})</span>
                                        <br> <span class="text-danger">{{ $product->subcategory->name ?? '' }} </span>
                                    </a>
                                    <p class="descrption">{{ $product->description }}</p>
                                    <div class="d-flex flex-wrap align-items-center">
                                        <a class="add_to_cart btn btn-danger text-white" href="#" data-bs-toggle="modal" data-bs-target="#cartModal">Order Now</a>
                                        <h3>Pkr:{{ $product->price }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
    <footer class="pt_100 mt_120 xs_mt_100">
        <div class="container">
            <div class="row justify-content-between wow fadeInUp">
                <div class="col-lg-12 col-md-12">
                    <div class="footer_info">
                        <a class='footer_logo' href='#'>
                            <img src="order_page/assets/images/logo.png" alt="RESTINA">
                        </a>
                        <p>Cras incident lobotids feudist makes viramas sagittas eu valuta.</p>
                        <ul>
                            <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a class="linkedin" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="footer_copyright">
                        <p>Copyright © SK Parwa 2025. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--==========================
        FOOTER END
    ===========================-->
    <!-- Order Table Modal -->
    <!-- Order Now Modal -->
    <!-- Order Now Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="font-family: 'Poppins', sans-serif;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title text-white" id="cartModalLabel">Order Summary</h5>
                    <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
                        ✖
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Order Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Client Name</label>
                            <input type="text" class="form-control" placeholder="Enter Client Name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Order Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Order Name</label>
                            <input type="text" class="form-control" placeholder="Enter Order Name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Program Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Delivery Time</label>
                            <input type="time" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Venue</label>
                            <input type="text" class="form-control" placeholder="Enter Venue">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Person Program</label>
                            <input type="text" class="form-control" placeholder="Enter Person Name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Event Type</label>
                            <input type="text" class="form-control" placeholder="Enter Event Type">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Special Instructions</label>
                            <textarea class="form-control" rows="1" placeholder="Enter Special Instructions"></textarea>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <table class="table table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Unit</th>
                                <th>Price (PKR)</th>
                                <th style="width: 100px;">Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <!-- Items will be dynamically added here -->
                        </tbody>
                    </table>

                    <!-- Subtotal -->
                    <div class="text-end mt-3">
                        <h4><strong>Subtotal: <h1 id="subtotal" class="text-success">PKR 0</h1></strong></h4>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>




    <!--==========================
        SCROLL BUTTON START
    ===========================-->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!--==========================
        SCROLL BUTTON END
    ===========================-->


    <!--jquery library js-->
    <script src="order_page/assets/js/jquery-3.7.1.min.js"></script>
    <!--bootstrap js-->
    <script src="order_page/assets/js/bootstrap.bundle.min.js"></script>
    <!--font-awesome js-->
    <script src="order_page/assets/js/Font-Awesome.js"></script>
    <!--nice select js-->
    <script src="order_page/assets/js/jquery.nice-select.min.js"></script>
    <!--marquee js-->
    <script src="order_page/assets/js/jquery.marquee.min.js"></script>
    <!--slick js-->
    <script src="order_page/assets/js/slick.min.js"></script>
    <!--countup js-->
    <script src="order_page/assets/js/jquery.waypoints.min.js"></script>
    <script src="order_page/assets/js/jquery.countup.min.js"></script>
    <!--venobox js-->
    <script src="order_page/assets/js/venobox.min.js"></script>
    <!--scroll button js-->
    <script src="order_page/assets/js/scroll_button.js"></script>
    <!--price ranger js-->
    <script src="order_page/assets/js/ranger_jquery-ui.min.js"></script>
    <script src="order_page/assets/js/ranger_slider.js"></script>
    <!--select 2 js-->
    <script src="order_page/assets/js/select2.min.js"></script>
    <!--aos js-->
    <script src="order_page/assets/js/wow.min.js"></script>
    <!--colorfulTab js-->
    <script src="order_page/assets/js/colorfulTab.min.js"></script>
    <!--sticky sidebar js-->
    <script src="order_page/assets/js/sticky_sidebar.js"></script>
    <!--animated barfiller js-->
    <script src="order_page/assets/js/animated_barfiller.js"></script>
    <!--animatedheadline js-->
    <script src="order_page/assets/js/jquery.animatedheadline.min.js"></script>
    <!--script/custom js-->
    <script src="order_page/assets/js/script.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cartItems = document.getElementById("cartItems");
            let subtotalElement = document.getElementById("subtotal");

            document.querySelectorAll(".add_to_cart").forEach(button => {
                button.addEventListener("click", function() {
                    let productCard = this.closest(".single_menu_text");
                    let itemName = productCard.querySelector(".title").textContent.trim();
                    let category = productCard.querySelector(".category").textContent.trim();
                    let subcategory = productCard.querySelector(".text-danger").textContent.trim();
                    let unit = productCard.querySelector(".unit")?.textContent.trim() || 'N/A';
                    let price = parseFloat(productCard.querySelector("h3").textContent.replace("Pkr:", "").trim());
                    let quantity = 1;
                    let total = price * quantity;

                    let newRow = `
                    <tr>
                        <td>${itemName}</td>
                        <td>${category}</td>
                        <td>${subcategory}</td>
                        <td>${unit}</td>
                        <td>${price}</td>
                        <td>
                            <input type="number" class="form-control quantity-input text-center" value="${quantity}" min="1" data-price="${price}" style="width: 70px;">
                        </td>
                        <td class="item-total">${total}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-item">X</button>
                        </td>
                    </tr>`;

                    cartItems.insertAdjacentHTML("beforeend", newRow);
                    updateTotals();
                });
            });

            // Function to update subtotal
            function updateTotals() {
                let subtotal = 0;
                document.querySelectorAll(".item-total").forEach(cell => {
                    subtotal += parseFloat(cell.textContent);
                });
                subtotalElement.textContent = `PKR ${subtotal.toFixed(2)}`;
            }

            // Event delegation for quantity change and delete button
            cartItems.addEventListener("input", function(event) {
                if (event.target.classList.contains("quantity-input")) {
                    let quantityInput = event.target;
                    let price = parseFloat(quantityInput.getAttribute("data-price"));
                    let quantity = parseInt(quantityInput.value) || 1;

                    let totalCell = quantityInput.closest("tr").querySelector(".item-total");
                    totalCell.textContent = (price * quantity).toFixed(2);

                    updateTotals();
                }
            });

            cartItems.addEventListener("click", function(event) {
                if (event.target.classList.contains("delete-item")) {
                    event.target.closest("tr").remove();
                    updateTotals();
                }
            });

        });
    </script>

</body>

</html>