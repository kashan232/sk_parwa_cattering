<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="la la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="#" class="sidebar__main-logo">
                <img src="{{ asset('assets\images\logo.jpg') }}" alt="image" style="width: 80px; height:auto; background:#000;border-radius:100px;">
            </a>
        </div>
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            @if(Auth::check() && Auth::user()->usertype == 'admin')
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item ">
                    <a href="{{ route('home') }}" class="nav-link ">
                        <i class="menu-icon la la-home"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                {{-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="" href="javascript:void(0)">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">Manage Staff</span>
                    </a>
                    <div class="sidebar-submenu ">
                        <ul>
                            <li class="sidebar-menu-item ">
                                <a class="nav-link" href="{{ route('staff') }}">
                <i class="menu-icon las la-dot-circle"></i>
                <span class="menu-title">All Staff</span>
                </a>
                </li>

                <li class="sidebar-menu-item ">
                    <a class="nav-link" href="{{ route('StaffSalary') }}">
                        <i class="menu-icon las la-dot-circle"></i>
                        <span class="menu-title">Staff Salary</span>
                    </a>
                </li>

            </ul>
        </div>
        </li> --}}

        <li class="sidebar-menu-item sidebar-dropdown">
            <a href="javascript:void(0)" class="">
                <i class="menu-icon lab la-product-hunt"></i>
                <span class="menu-title">Manage Product</span>
            </a>
            <div class="sidebar-submenu  ">
                <ul>
                    <li class="sidebar-menu-item  ">
                        <a href="{{ route('category') }}" class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item  ">
                        <a href="{{ route('subcategory') }}" class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Sub Categories</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item  ">
                        <a href="{{ route('unit') }}" class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Units</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item  ">
                        <a href="{{ route('all-product') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Products</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('customer') }}" class="nav-link">
                <i class="menu-icon la la-users"></i>
                <span class="menu-title">Customer</span>
            </a>
        </li>

        <li class="sidebar-menu-item ">
            <a href="{{ route('all-order') }}" class="nav-link ">
                <i class="menu-icon la la-warehouse"></i>
                <span class="menu-title">Order</span>
            </a>
        </li>

        <li class="sidebar-menu-item ">
            <a href="{{ route('online-order') }}" class="nav-link ">
                <i class="menu-icon la la-warehouse"></i>
                <span class="menu-title">Online Orders</span>
            </a>
        </li>

        <li class="sidebar-menu-item ">
            <a href="{{ route('all-menu') }}" class="nav-link ">
                <i class="menu-icon la la-warehouse"></i>
                <span class="menu-title">Estimate</span>
            </a>
        </li>

        <!-- <li class="sidebar-menu-item ">
                    <a href="{{ route('product-alerts') }}" class="nav-link ">
                        <i class="menu-icon las la-bell"></i>
                        <span class="menu-title">Stock Alerts</span>
                        {{-- @php
                        $lowStockProductsCount = DB::table('products')
                        ->whereRaw('CAST(stock AS UNSIGNED) <= CAST(alert_quantity AS UNSIGNED)')
                            ->count();
                            @endphp


                            @if($lowStockProductsCount > 0)
                            <small>&nbsp;<i class="fa fa-circle text--danger" aria-hidden="true" aria-label="Returned" data-bs-original-title="Returned"></i></small>
                            @endif --}}
                    </a>
                </li> -->






        {{-- <li class="sidebar-menu-item">
                    <a href="{{ route('supplier') }}" class="nav-link">
        <i class="menu-icon la la-user-friends"></i>
        <span class="menu-title">Supplier</span>
        </a>
        </li> --}}
        {{-- <li class="sidebar-menu-item">
                    <a href="{{ route('supplier') }}" class="nav-link">
        <i class="menu-icon la la-user-friends"></i>
        <span class="menu-title">Vendor</span>
        </a>
        </li> --}}
        <li class="sidebar-menu-item">
            <a href="{{ route('vendor') }}" class="nav-link">
                <i class="menu-icon la la-user-friends"></i>
                <span class="menu-title">Vendor</span>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('vendor') }}" class="nav-link">
                <i class="menu-icon la la-user-friends"></i>
                <span class="menu-title">Give Order to Vendor</span>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('kitchen.inventory') }}" class="nav-link">
                <i class="menu-icon la la-user-friends"></i>
                <span class="menu-title">Kitchen Inventory</span>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('get-passes') }}" class="nav-link">
                <i class="menu-icon la la-user-friends"></i>
                <span class="menu-title">Gate Passes</span>
            </a>
        </li>


        <li class="sidebar-menu-item sidebar-dropdown">
            <a class="" href="javascript:void(0)">
                <i class="menu-icon las la-users"></i>
                <span class="menu-title">Accountant</span>
            </a>
            <div class="sidebar-submenu ">
                <ul>
                    <li class="sidebar-menu-item ">
                        <a class="nav-link" href="{{ route('Accountant') }}">
                            <i class="menu-icon las la-dot-circle"></i>
                            <span class="menu-title">Accountant</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item ">
                        <a class="nav-link" href="{{ route('Accountant-Ledger') }}">
                            <i class="menu-icon las la-dot-circle"></i>
                            <span class="menu-title">Accountant Ledger</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item ">
                        <a class="nav-link" href="{{ route('Accountant-Expense') }}">
                            <i class="menu-icon las la-dot-circle"></i>
                            <span class="menu-title">Accountant Expense</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('item-category') }}" class="nav-link">
                <i class="menu-icon la la-user-friends"></i>
                <span class="menu-title">Item Category</span>
            </a>
        </li>

        <li class="sidebar-menu-item ">
            <a href="{{ route('brand') }}" class="nav-link">
                <i class="menu-icon la la-dot-circle"></i>
                <span class="menu-title">Item Brands</span>
            </a>
        </li>

        <li class="sidebar-menu-item ">
            <a href="{{ route('all-item-product') }}" class="nav-link">
                <i class="menu-icon la la-dot-circle"></i>
                <span class="menu-title">Item Product</span>
            </a>
        </li>


        <li class="sidebar-menu-item ">
            <a href="{{ route('warehouse') }}" class="nav-link ">
                <i class="menu-icon la la-warehouse"></i>
                <span class="menu-title">Warehouse</span>
            </a>
        </li>

        <li class="sidebar-menu-item sidebar-dropdown">
            <a href="javascript:void(0)" class="">
                <i class="menu-icon fas fa-shopping-basket"></i>
                <span class="menu-title">Warehouse Stock</span>
            </a>
            <div class="sidebar-submenu ">
                <ul>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('warehouse-stock') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Add warehouse Stock</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('listing-warehouse-stock') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">All warehouse Stock</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('product-warehouse-stock') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Warehouse Prodct Stock</span>
                        </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="sidebar-menu-item sidebar-dropdown">
            <a href="javascript:void(0)" class="">
                <i class="menu-icon fas fa-shopping-basket"></i>
                <span class="menu-title">Stock Transfer</span>
            </a>
            <div class="sidebar-submenu ">
                <ul>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('warehouse-to-shop-stock') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Stock Transfer</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('All-Stock-Transfer') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">All Stock Transfer</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="sidebar-menu-item sidebar-dropdown">
            <a href="javascript:void(0)" class="">
                <i class="menu-icon fas fa-shopping-basket"></i>
                <span class="menu-title">Purchase</span>
            </a>
            <div class="sidebar-submenu ">
                <ul>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('add-purchase') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Add Purchases</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item ">
                        <a href="{{ route('Purchase') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">All Purchases</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item  ">
                        <a href="{{ route('all-purchase-return') }}"
                            class="nav-link">
                            <i class="menu-icon la la-dot-circle"></i>
                            <span class="menu-title">Purchases Return</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="sidebar-menu-item  ">
            <a href="{{ route('all-purchase-return-damage-item') }}"
                class="nav-link">
                <i class="menu-icon la la-dot-circle"></i>
                <span class="menu-title">Claim Returns</span>
            </a>
        </li>

        <!-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="">
                        <i class="menu-icon la la-shopping-bag"></i>
                        <span class="menu-title">Purchase</span>
                    </a>
                    <div class="sidebar-submenu  ">
                        <ul>
                            <li class="sidebar-menu-item  ">
                                <a href="{{ route('Purchase') }}"
                                    class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title">All Purchases</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item  ">
                                <a href="{{ route('all-purchase-return') }}"
                                    class="nav-link">
                                    <i class="menu-icon la la-dot-circle"></i>
                                    <span class="menu-title">Purchases Return</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->

        <!-- <li class="sidebar-menu-item  ">
                    <a href="{{ route('all-purchase-return-damage-item') }}"
                        class="nav-link">
                        <i class="menu-icon la la-dot-circle"></i>
                        <span class="menu-title">Claim Returns</span>
                    </a>
                </li> -->



        <!-- <li class="sidebar-menu-item">
                    <a href="{{ route('customer-recovires') }}" class="nav-link">
                        <i class="menu-icon la la-users"></i>
                        <span class="menu-title">Customer Recoveries</span>
                    </a>
                </li> -->

        {{-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="">
                        <i class="menu-icon la la-shopping-cart"></i>
                        <span class="menu-title">Sale</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li class="sidebar-menu-item">
                                <a href="{{ route('all-sales') }}" class="nav-link">
        <i class="menu-icon la la-dot-circle"></i>
        <span class="menu-title">All Sales</span>
        </a>
        </li>
        <li class="sidebar-menu-item  ">
            <a href="#"
                class="nav-link">
                <i class="menu-icon la la-dot-circle"></i>
                <span class="menu-title">Sales Return</span>
            </a>
        </li>
        </ul>
    </div>
    </li> --}}
    </ul>
    @endif



    @if(Auth::check() && Auth::user()->usertype == 'staff')
    <ul class="sidebar__menu">
        <li class="sidebar-menu-item active">
            <a href="{{ route('home') }}" class="nav-link ">
                <i class="menu-icon la la-home"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('all-sales') }}" class="nav-link">
                <i class="menu-icon la la-dot-circle"></i>
                <span class="menu-title">All Sales</span>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('customer') }}" class="nav-link">
                <i class="menu-icon la la-users"></i>
                <span class="menu-title">Customer</span>
            </a>
        </li>
    </ul>
    @endif

    @if(Auth::check() && Auth::user()->usertype == 'Accountant')
    <ul class="sidebar__menu">
        <li class="sidebar-menu-item active">
            <a href="{{ route('home') }}" class="nav-link ">
                <i class="menu-icon la la-home"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="sidebar-menu-item sidebar-dropdown">
            <a class="" href="javascript:void(0)">
                <i class="menu-icon las la-users"></i>
                <span class="menu-title">Accountant</span>
            </a>
            <div class="sidebar-submenu ">
                <ul>
                    <li class="sidebar-menu-item ">
                        <a class="nav-link" href="{{ route('Accountant-Expense') }}">
                            <i class="menu-icon las la-dot-circle"></i>
                            <span class="menu-title">Accountant Expense</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
    @endif
    <div class="text-center mb-3 text-uppercase">
        <span class="text--success">SK</span>
        <span class="text--primary">Parwa</span>
        <span class="text--success">Software</span>
    </div>
</div>
</div>
</div>