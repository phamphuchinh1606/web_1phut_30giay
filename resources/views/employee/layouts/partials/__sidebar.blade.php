<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">
        <ul class="nav">
            @foreach($menus as $menu)
                @if(isset($menu->menu_route) && !empty($menu->menu_route))
                    @can('menu.view', $menu)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route($menu->menu_route)}}">
                            <i class="nav-icon {{$menu->menu_icon_class}}"></i> {{$menu->menu_name}}
                        </a>
                    </li>
                    @endcan
                @elseif(isset($menu->child_menus) && count($menu->child_menus) > 0)
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon {{$menu->menu_icon_class}}"></i> {{$menu->menu_name}}</a>
                        <ul class="nav-dropdown-items">
                            @foreach($menu->child_menus as $menuChild)
                                @can('menu.view', $menuChild)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route($menuChild->menu_route)}}">
                                        <i class="nav-icon {{$menuChild->menu_icon_class}}"></i>
                                        {{$menuChild->menu_name}}
                                    </a>
                                </li>
                                @endcan
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach

{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.home')}}">--}}
{{--                    <i class="nav-icon icon-home"></i> Trang chủ--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            @can('menu.view')--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.input_daily')}}">--}}
{{--                    <i class="nav-icon icon-calendar"></i>--}}
{{--                    Hàng Ngày--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            @endcan--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.sale_card_small')}}">--}}
{{--                    <i class="nav-icon icon-trophy"></i>--}}
{{--                    Xe Nhỏ--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.sale_report')}}">--}}
{{--                    <i class="nav-icon icon-support"></i>--}}
{{--                    Doanh Số--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.check_in.daily')}}">--}}
{{--                    <i class="nav-icon icon-book-open"></i>--}}
{{--                    Đặt Hàng--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.time_keeping')}}">--}}
{{--                    <i class="nav-icon icon-layers"></i>--}}
{{--                    Chấm Công--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.payment_bill')}}">--}}
{{--                    <i class="nav-icon icon-diamond"></i>--}}
{{--                    Phiếu Chi--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="{{route('admin.finance')}}">--}}
{{--                    <i class="nav-icon icon-fire"></i>--}}
{{--                    Tài Chính--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item nav-dropdown">--}}
{{--                <a class="nav-link nav-dropdown-toggle" href="#">--}}
{{--                    <i class="nav-icon icon-settings"></i> Cài Đặt</a>--}}
{{--                <ul class="nav-dropdown-items">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('admin.employee')}}">--}}
{{--                            <i class="nav-icon icon-people"></i>--}}
{{--                            Nhân Viên--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('admin.user')}}">--}}
{{--                            <i class="nav-icon icon-user-following"></i>--}}
{{--                            NV Quản Lý--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('admin.setting.setting_of_day')}}">--}}
{{--                            <i class="nav-icon icon-equalizer"></i>--}}
{{--                            Thiết lặp ngày nhĩ--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('admin.setting.role')}}">--}}
{{--                            <i class="nav-icon icon-directions"></i>--}}
{{--                            Thiết lặp quyền--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}

        </ul>
{{--        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">--}}
{{--            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>--}}
{{--        </div>--}}
{{--        <div class="ps__rail-y" style="top: 0px; height: 708px; right: 0px;">--}}
{{--            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 422px;"></div>--}}
{{--        </div>--}}
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
