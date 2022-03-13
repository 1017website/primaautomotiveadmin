<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <a class="navbar-brand" href="index.html">
                <b class="logo-icon p-l-10">
                    <img src="{{asset('plugins/images/logo-icon.png')}}" alt="homepage" class="light-logo" />
                    
                </b>
                <span class="logo-text">
                        <img src="{{asset('plugins/images/logo-text.png')}}" alt="homepage" class="light-logo" />
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
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">{{ __('Master') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="/type-product" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">{{ __('Type Product') }}</span></a></li>
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="mdi mdi-barcode"></i><span class="hide-menu">{{ __('Product') }}</span></a></li>
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="mdi mdi-wrench"></i><span class="hide-menu">{{ __('Service') }}</span></a></li>
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="mdi mdi-clipboard-account"></i><span class="hide-menu">{{ __('Mechanic') }}</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-dropbox"></i><span class="hide-menu">{{ __('Stock') }}</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="mdi mdi-clipboard-arrow-down"></i><span class="hide-menu">{{ __('Stock In') }}</span></a></li>
                        <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="mdi mdi-scale-balance"></i><span class="hide-menu">{{ __('Adjustment Stock') }}</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false"><i class="mdi mdi-cart"></i><span class="hide-menu">{{ __('Booking') }}</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">{{ __('Invoice') }}</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false"><i class="mdi mdi-worker"></i><span class="hide-menu">{{ __('Work Order') }}</span></a></li>
            </ul>
        </nav>
    </div>
</aside>
