<style>
    #style-1::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #1F262D !important;
    }

    #style-1::-webkit-scrollbar {
        width: 5px;
        background-color: #1F262D !important;
    }

    #style-1::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #ffffff;
    }
</style>

<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <a class="navbar-brand" href="/">
                <span class="logo-text" style="margin-left: auto;margin-right: auto;">
                    <img src="{{asset('plugins/images/logo.png')}}" alt="homepage" class="light-logo"
                        style="margin-left: auto;margin-right: auto;" />
                </span>
            </a>
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light"
                        href="javascript:void(0)" data-sidebartype="mini-sidebar"><i
                            class="mdi mdi-menu font-24"></i></a></li>
            </ul>
            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href="" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <img src="{{ Auth::user()->profile_photo_url }}" alt="user"
                            class="rounded-circle" width="31">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated">
                        <a class="dropdown-item" href="{{ route('profile.show') }}"><i class="ti-user m-r-5 m-l-5"></i>
                            {{ __('My Profile') }}</a>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fa fa-power-off m-r-5 m-l-5"></i> {{
                                __('Logout') }}</button>
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
                @foreach ($userMenus as $menu)
                @if ($menu['parent'] == 0)
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link {{ !empty($menu['url']) ? $menu['url'] : 'has-arrow' }}"
                        href="{{ !empty($menu['url']) ? $menu['url'] : 'javascript:void(0)' }}" aria-expanded="false">
                        <i class="{!! $menu['icon'] !!}"></i><span class="hide-menu">{{ $menu['name'] }}</span>
                    </a>

                    @php
                    $children = collect($userMenus)->where('parent', $menu['id']);
                    @endphp

                    @if ($children->isNotEmpty())
                    <ul aria-expanded="false" class="collapse first-level">
                        @foreach ($children as $child)
                        <li class="sidebar-item">
                            <a href="{{ !empty($child['url']) ? $child['url'] : 'javascript:void(0)' }}"
                                class="sidebar-link {{ !empty($child['url']) ? $child['url'] : 'has-arrow' }}"
                                aria-expanded="false">
                                <i class="{{ $child['icon'] }}"></i><span class="hide-menu">{{ $child['name'] }}</span>
                            </a>

                            @php
                            $subChildren = collect($userMenus)->where('parent', $child['id']);
                            @endphp

                            @if ($subChildren->isNotEmpty())
                            <ul aria-expanded="false" class="collapse second-level">
                                @foreach ($subChildren as $subChild)
                                <li class="sidebar-item">
                                    <a href="{{ !empty($subChild['url']) ? $subChild['url'] : 'javascript:void(0)' }}"
                                        class="sidebar-link {{ !empty($subChild['url']) ? $subChild['url'] : 'has-arrow' }}">
                                        <i class="{{ $subChild['icon'] }}"></i><span class="hide-menu">{{
                                            $subChild['name'] }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>