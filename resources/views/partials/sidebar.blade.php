<body>
<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">

    <div class="container-fluid">
        <nav class="navbar navbar-vertical navbar-expand-xl navbar-light">
            <div class="d-flex align-items-center">
                <div class="toggle-icon-wrapper">
                    <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-toggle="tooltip" data-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
                </div><a class="navbar-brand" href="index.html">
                    <div class="d-flex align-items-center py-3"><img class="mr-2" src="{{ asset('assets/img/illustrations/falcon.png') }}" alt="" width="40" /><span class="text-sans-serif">inventory</span></div>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                <div class="navbar-vertical-content perfect-scrollbar scrollbar">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('home') }}">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text"> Dashboard</span></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-copy"></span></span><span class="nav-link-text">Inventory</span></div>
                            </a>
                        </li>
                        <li class="nav-item my-margin">
                            <a class="nav-link {{ Request::is('product/create') ? 'active' : '' }}" href="{{ route('product.create') }}">
                                New Product
                            </a>
                        </li>
                        <li class="nav-item my-margin">
                            <a class="nav-link {{ Request::is('product') ? 'active' : '' }}" href="{{ route('product.index') }}">
                                Product List
                            </a>
                        </li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('category') ? 'active' : '' }}" href="{{ route('category.index') }}">Category</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('unit') ? 'active' : '' }}" href="{{ route('unit.index') }}">Unit</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('stocks') ? 'active' : '' }}" href="{{ route('stocks.index') }}">Stock Manage</a></li>

                        <div class="navbar-vertical-divider">
                            <hr class="navbar-vertical-hr my-2" />
                        </div>

                        <li class="nav-item">
                            <a class="nav-link">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fab fa-trello"></span></span>
                                    <span class="nav-link-text">Vendors</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('vendors/create') ? 'active' : '' }}" href="{{ route('vendors.create') }}">New Vendor</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('vendors') ? 'active' : '' }}" href="{{ route('vendors.index') }}">Vendors List</a></li>

                        <li class="nav-item">
                            <a class="nav-link">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fas fa-cart-arrow-down"></span>
                                    </span><span class="nav-link-text">Purchase</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('purchase/create') ? 'active' : '' }}" href="{{ route('purchase.create') }}">New Purchase</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('purchase') ? 'active' : '' }}" href="{{ route('purchase.index') }}">Purchase List</a></li>

                        <div class="navbar-vertical-divider">
                            <hr class="navbar-vertical-hr my-2" />
                        </div>

                        <li class="nav-item">
                            <a class="nav-link">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fas fa-user-friends"></span>
                                    </span><span class="nav-link-text">Customers</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('customers/create') ? 'active' : '' }}" href="{{ route('customers.create') }}">New Customer</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('customers') ? 'active' : '' }}" href="{{ route('customers.index') }}">Customers List</a></li>
                        <li class="nav-item">
                            <a class="nav-link">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fas fa-cart-plus"></span>
                                    </span><span class="nav-link-text">Sales</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('sales/create') ? 'active' : '' }}" href="{{ route('sales.create') }}">New Sales</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('sales') ? 'active' : '' }}" href="{{ route('sales.index') }}">Sales List</a></li>
                    </ul>
                    <div class="navbar-vertical-divider">
                        <hr class="navbar-vertical-hr my-2" />
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fas fa-poll"></span>
                                    </span><span class="nav-link-text">Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('report/sales') ? 'active' : '' }}" href="{{ route('report.sales') }}">Sales Report</a></li>
                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('report/purchase') ? 'active' : '' }}" href="{{ route('report.purchase') }}">Purchase Report</a></li>
{{--                        <li class="nav-item my-margin"><a class="nav-link {{ Request::is('sales') ? 'active' : '' }}" href="{{ route('sales.index') }}">Profit Report</a></li>--}}
                    </ul>
                    <div class="settings px-3 px-xl-0">
                        <div class="navbar-vertical-divider px-0">
                            <hr class="navbar-vertical-hr my-3" />
                        </div>
                        <a class="btn btn-sm btn-block btn-purchase mb-3" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
