<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <a class="navbar-brand" href="/">
                <span class="logo-text" style="margin-left: auto;margin-right: auto;">
                    <img src="{{asset('plugins/images/logo.png')}}" alt="homepage" class="light-logo" style="margin-left: auto;margin-right: auto;"/>
                </span>
            </a>
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
            </ul>
            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <img src="{{ Auth::user()->profile_photo_url }}" alt="user" class="rounded-circle" width="31"> 
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated">
                        <a class="dropdown-item" href="{{ route('profile.show') }}"><i class="ti-user m-r-5 m-l-5"></i> {{ __('My Profile') }}</a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf 
                            <button type="submit" class="dropdown-item"><i class="fa fa-power-off m-r-5 m-l-5"></i> {{ __('Logout') }}</button>  
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="left-sidebar" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/dashboard" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">{{ __('Dashboard') }}</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-store"></i><span class="hide-menu">{{ __('Store') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="/store-type-product" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">{{ __('Type Items') }}</span></a></li>
                        <li class="sidebar-item"><a href="/store-product" class="sidebar-link"><i class="mdi mdi-barcode"></i><span class="hide-menu">{{ __('Product') }}</span></a></li>
                        <li class="sidebar-item"><a href="/store-stock" class="sidebar-link"><i class="mdi mdi-scale-balance"></i><span class="hide-menu">{{ __('Stock') }}</span></a></li>
                        <li class="sidebar-item"><a href="/store-chasier" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">{{ __('Cashier') }}</span></a></li>
                        <li class="sidebar-item"><a href="/store-customer" class="sidebar-link"><i class="mdi mdi-account-multiple-plus"></i><span class="hide-menu">{{ __('Customer') }}</span></a></li>
                        <li class="sidebar-item"><a href="/store-spending" class="sidebar-link"><i class="mdi mdi-cash"></i><span class="hide-menu">{{ __('Spending') }}</span></a></li>
                        <li class="sidebar-item"><a href="/store-investment" class="sidebar-link"><i class="mdi mdi-timer-sand"></i><span class="hide-menu">{{ __('Investment') }}</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">{{ __('Report') }}</span></a>
                            <ul aria-expanded="false" class="collapse  second-level">
                                <li class="sidebar-item"><a href="/report-store/current-stock" class="sidebar-link"><i class="mdi mdi-clipboard-check"></i><span class="hide-menu">{{ __('Report Current Stock') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report-store/history-stock" class="sidebar-link"><i class="mdi mdi-clipboard-flow"></i><span class="hide-menu">{{ __('Report History Stock') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report-store/revenue" class="sidebar-link"><i class="mdi mdi-currency-usd"></i><span class="hide-menu">{{ __('Report Revenue') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report-store/expense" class="sidebar-link"><i class="mdi mdi-currency-usd-off"></i><span class="hide-menu">{{ __('Report Expense') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-car"></i><span class="hide-menu">{{ __('Workshop') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">{{ __('Master') }}</span></a>
                            <ul aria-expanded="false" class="collapse  second-level">
                                <li class="sidebar-item"><a href="/type-product" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">{{ __('Type Items') }}</span></a></li>
                                <li class="sidebar-item"><a href="/product" class="sidebar-link"><i class="mdi mdi-barcode"></i><span class="hide-menu">{{ __('Items') }}</span></a></li>
                                <li class="sidebar-item"><a href="/service" class="sidebar-link"><i class="mdi mdi-wrench"></i><span class="hide-menu">{{ __('Service') }}</span></a></li>
                                <li class="sidebar-item"><a href="/customer" class="sidebar-link"><i class="mdi mdi-account-multiple-plus"></i><span class="hide-menu">{{ __('Customer') }}</span></a></li>
                                <li class="sidebar-item"><a href="/car" class="sidebar-link"><i class="mdi mdi-car"></i><span class="hide-menu">{{ __('Cars') }}</span></a></li>
                                <li class="sidebar-item"><a href="/car-brand" class="sidebar-link"><i class="mdi mdi-car-wash"></i><span class="hide-menu">{{ __('Car Brands') }}</span></a></li>
                                <li class="sidebar-item"><a href="/car-type" class="sidebar-link"><i class="mdi mdi-car-connected"></i><span class="hide-menu">{{ __('Car Types') }}</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-dropbox"></i><span class="hide-menu">{{ __('Inventory') }}</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="/stock" class="sidebar-link"><i class="mdi mdi-scale-balance"></i><span class="hide-menu">{{ __('Stock') }}</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/order" aria-expanded="false"><i class="mdi mdi-cart"></i><span class="hide-menu">{{ __('Order') }}</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/invoice" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">{{ __('Invoice') }}</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/workorder" aria-expanded="false"><i class="mdi mdi-worker"></i><span class="hide-menu">{{ __('Work Order') }}</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-currency-usd"></i><span class="hide-menu">{{ __('Expense') }}</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="/expense-spending" class="sidebar-link"><i class="mdi mdi-cash"></i><span class="hide-menu">{{ __('Spending') }}</span></a></li>
                                <li class="sidebar-item"><a href="/expense-investment" class="sidebar-link"><i class="mdi mdi-timer-sand"></i><span class="hide-menu">{{ __('Investment') }}</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">{{ __('Report') }}</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="/report/current-stock" class="sidebar-link"><i class="mdi mdi-clipboard-check"></i><span class="hide-menu">{{ __('Report Current Stock') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report/history-stock" class="sidebar-link"><i class="mdi mdi-clipboard-flow"></i><span class="hide-menu">{{ __('Report History Stock') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report/revenue" class="sidebar-link"><i class="mdi mdi-currency-usd"></i><span class="hide-menu">{{ __('Report Revenue') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report/expense" class="sidebar-link"><i class="mdi mdi-currency-usd-off"></i><span class="hide-menu">{{ __('Report Expense') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="hide-menu">{{ __('HRM') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="/mechanic" class="sidebar-link"><i class="mdi mdi-account"></i><span class="hide-menu">{{ __('Employee') }}</span></a></li>
                        <li class="sidebar-item"><a href="/attendance" class="sidebar-link"><i class="mdi mdi-account-check"></i><span class="hide-menu">{{ __('Attendance') }}</span></a></li>
                        <li class="sidebar-item"><a href="/attendance-permit" class="sidebar-link"><i class="mdi mdi-account-remove"></i><span class="hide-menu">{{ __('Attendance Permit') }}</span></a></li>
                        <li class="sidebar-item"><a href="/payroll" class="sidebar-link"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">{{ __('Payroll') }}</span></a></li>
                        <li class="sidebar-item"><a href="/employee-credit" class="sidebar-link"><i class="mdi mdi-account-minus"></i><span class="hide-menu">{{ __('Credit') }}</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"><a class="sidebar-link" href="/setting" aria-expanded="false"><i class="mdi mdi-wrench"></i><span class="hide-menu">{{ __('Setting') }}</span></a></li>
            </ul>
        </nav>
    </div>
</aside>
