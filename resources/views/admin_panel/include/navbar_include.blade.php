<nav class="navbar-wrapper bg--dark">
    <div class="navbar__left">
        <button type="button" class="res-sidebar-open-btn me-3"><i class="las la-bars"></i></button>
        <form class="navbar-search">
            <input type="search" name="#0" class="navbar-search-field" id="searchInput" autocomplete="off"
                placeholder="Search here...">
            <i class="las la-search"></i>
            <ul class="search-list"></ul>
        </form>
    </div>
    <div class="navbar__right">
        <ul class="navbar__action-list">
        @if(Auth::check() && in_array(Auth::user()->usertype, ['admin', 'super admin']))

            <li class="nav-item">
                @php
                // Get today's date
                $today = \Carbon\Carbon::today();

                // Get the date 5 days later without modifying the original `$today` variable
                $fiveDaysLater = $today->copy()->addDays(5);

                // Get the orders where the delivery date is within 5 days from today
                $ordersAlertCount = DB::table('orders')
                ->whereRaw('DATE(delivery_date) <= ?', [$fiveDaysLater->toDateString()])
                    ->whereRaw('DATE(delivery_date) >= ?', [$today->toDateString()])
                    ->count();
                    @endphp

                    <a class="nav-link" href="#">
                        <!-- Notifications -->
                        <i class="las la-bell" style="font-size: 25px; color:#fff;"></i>
                        <span class="badge badge-danger" style="padding: .5em .15em!important;">
                            @if($ordersAlertCount > 0)
                            {{ $ordersAlertCount }} <!-- Show count of orders with upcoming delivery -->
                            @endif
                        </span>
                    </a>
            </li>
            @endif


            <li class="dropdown">
                <button type="button" class="" data-bs-toggle="dropdown" data-display="static"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="navbar-user">
                        <span class="navbar-user__thumb">
                            <img src="assets/admin/images/user.png" alt="image"></span>
                        <span class="navbar-user__info">

                            @if(Auth::check() && Auth::user()->usertype == 'super admin')
                            <span class="navbar-user__name">Super Admin</span>
                            @elseif(Auth::check() && Auth::user()->usertype == 'admin')
                            <span class="navbar-user__name">Admin</span>
                            @elseif(Auth::check() && Auth::user()->usertype == 'staff')
                            <span class="navbar-user__name">User</span>
                            @elseif(Auth::check() && Auth::user()->usertype == 'Accountant')
                            <span class="navbar-user__name">Accountant</span>
                            @endif
                        </span>
                        <span class="icon"><i class="las la-chevron-circle-down"></i></span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu--sm p-0 border-0 box--shadow1 dropdown-menu-right">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                            <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                            <span class="dropdown-menu__caption">Logout</span>
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>