<style>
    #style-1::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #1F262D!important;
    }

    #style-1::-webkit-scrollbar
    {
        width: 5px;
        background-color: #1F262D!important;
    }

    #style-1::-webkit-scrollbar-thumb
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #ffffff;
    }
</style>

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
    <div class="scroll-sidebar" style="overflow-y: auto" id="style-1">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/dashboard" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">{{ __('Dashboard') }}</span></a></li>
                @if(Auth::user()->is_store == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-store"></i><span class="hide-menu">{{ __('Store') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="/master-rack" class="sidebar-link"><i class="mdi mdi-table-large"></i><span class="hide-menu">{{ __('Mixing Rack') }}</span></a></li>
                        <li class="sidebar-item"><a href="/mix" class="sidebar-link"><i class="mdi mdi-format-color-fill"></i><span class="hide-menu">{{ __('Mix') }}</span></a></li>
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
                                <li class="sidebar-item"><a href="/report-store/stock-rack" class="sidebar-link"><i class="mdi mdi-clipboard-check"></i><span class="hide-menu">{{ __('Report Current Mixing Rack') }}</span></a></li>
                                <li class="sidebar-item"><a href="/report-store/history-rack" class="sidebar-link"><i class="mdi mdi-clipboard-flow"></i><span class="hide-menu">{{ __('Report History Mixing Rack') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->is_workshop == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-car"></i><span class="hide-menu">{{ __('Workshop') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">{{ __('Master') }}</span></a>
                            <ul aria-expanded="false" class="collapse  second-level">
                                <li class="sidebar-item"><a href="/type-product" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">{{ __('Type Items') }}</span></a></li>
                                <li class="sidebar-item"><a href="/product" class="sidebar-link"><i class="mdi mdi-barcode"></i><span class="hide-menu">{{ __('Items') }}</span></a></li>
                                <li class="sidebar-item"><a href="/type-service" class="sidebar-link"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">{{ __('Type Service') }}</span></a></li>
                                <li class="sidebar-item"><a href="/service-parent" class="sidebar-link"><i class="mdi mdi-wrench"></i><span class="hide-menu">{{ __('Service') }}</span></a></li>
                                <li class="sidebar-item"><a href="/service" class="sidebar-link"><i class="mdi mdi-wrench"></i><span class="hide-menu">{{ __('Service Additional') }}</span></a></li>
                                <li class="sidebar-item"><a href="/customer" class="sidebar-link"><i class="mdi mdi-account-multiple-plus"></i><span class="hide-menu">{{ __('Customer') }}</span></a></li>
                                <li class="sidebar-item"><a href="/car" class="sidebar-link"><i class="mdi mdi-car"></i><span class="hide-menu">{{ __('Cars') }}</span></a></li>
                                <li class="sidebar-item"><a href="/car-brand" class="sidebar-link"><i class="mdi mdi-car-wash"></i><span class="hide-menu">{{ __('Car Brands') }}</span></a></li>
                                <li class="sidebar-item"><a href="/car-type" class="sidebar-link"><i class="mdi mdi-car-connected"></i><span class="hide-menu">{{ __('Car Types') }}</span></a></li>
                                <li class="sidebar-item"><a href="/color-group" class="sidebar-link"><i class="mdi mdi-format-color-fill"></i><span class="hide-menu">{{ __('Color Group') }}</span></a></li>
                                <li class="sidebar-item"><a href="/color" class="sidebar-link"><i class="mdi mdi-format-color-fill"></i><span class="hide-menu">{{ __('Color Code') }}</span></a></li>
                                <li class="sidebar-item"><a href="/color-category" class="sidebar-link"><i class="mdi mdi-format-color-fill"></i><span class="hide-menu">{{ __('Color Category') }}</span></a></li>
                                <li class="sidebar-item"><a href="/color-database" class="sidebar-link"><i class="mdi mdi-format-color-fill"></i><span class="hide-menu">{{ __('Color Database') }}</span></a></li>
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
                @endif
                @if(Auth::user()->is_wash == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-car-wash"></i><span class="hide-menu">{{ __('Prima X Shine') }}</span></a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item"><a href="/wash-service" class="sidebar-link"><i class="mdi mdi-store"></i><span class="hide-menu">{{ __('Services') }}</span></a></li>
                        <li class="sidebar-item"><a href="/wash-product" class="sidebar-link"><i class="mdi mdi-basket"></i><span class="hide-menu">{{ __('Products') }}</span></a></li>
                        <li class="sidebar-item"><a href="/wash-asset" class="sidebar-link"><i class="mdi mdi-archive"></i><span class="hide-menu">{{ __('Assets') }}</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-currency-usd"></i><span class="hide-menu">{{ __('Expenses') }}</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="/wash-expense-service" class="sidebar-link"><i class="mdi mdi-cash"></i><span class="hide-menu">{{ __('Service Spending') }}</span></a></li>
                                <li class="sidebar-item"><a href="/wash-expense-product" class="sidebar-link"><i class="mdi mdi-timer-sand"></i><span class="hide-menu">{{ __('Product Spending') }}</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a href="/wash-sale" class="sidebar-link"><i class="mdi mdi-basket"></i><span class="hide-menu">{{ __('Sales') }}</span></a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->is_hrm == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="hide-menu">{{ __('HRM') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="/mechanic" class="sidebar-link"><i class="mdi mdi-account"></i><span class="hide-menu">{{ __('Employee') }}</span></a></li>
                        <li class="sidebar-item"><a href="/attendance" class="sidebar-link"><i class="mdi mdi-account-check"></i><span class="hide-menu">{{ __('Attendance') }}</span></a></li>
                        <li class="sidebar-item"><a href="/attendance-permit" class="sidebar-link"><i class="mdi mdi-account-remove"></i><span class="hide-menu">{{ __('Attendance Permit') }}</span></a></li>
                        <li class="sidebar-item"><a href="/payroll" class="sidebar-link"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">{{ __('Payroll') }}</span></a></li>
                        <li class="sidebar-item"><a href="/employee-credit" class="sidebar-link"><i class="mdi mdi-account-minus"></i><span class="hide-menu">{{ __('Credit') }}</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">{{ __('Report') }}</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="/report/attendance" class="sidebar-link"><i class="mdi mdi-clipboard-check"></i><span class="hide-menu">{{ __('Report Attendance') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->is_setting == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"><a class="sidebar-link" href="/setting" aria-expanded="false"><i class="mdi mdi-wrench"></i><span class="hide-menu">{{ __('Setting') }}</span></a></li>
                @endif
                @if(Auth::user()->is_user == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="hide-menu">{{ __('Users') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="/user" class="sidebar-link"><i class="mdi mdi-account"></i><span class="hide-menu">{{ __('User List') }}</span></a></li>
                        <li class="sidebar-item"><a href="/user_role" class="sidebar-link"><i class="mdi mdi-account"></i><span class="hide-menu">{{ __('User Role') }}</span></a></li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->is_estimator == 1 || Auth::user()->is_owner == 1)
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/estimator-internal" aria-expanded="false"><i class="mdi mdi-account-settings-variant"></i><span class="hide-menu">{{ __('Estimator Internal') }}</span></a></li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
