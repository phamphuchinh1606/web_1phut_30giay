@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Cập Nhật Menu
            <a class="btn btn-sm btn-dark pull-right" href="{{route('admin.setting.menu')}}" >Quay Lại</a>
        </div>
        <form action="{{route('admin.setting.menu.update',['id' => $menu->menu_id])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="menu_id">Mã Menu</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->menu_id}}" readonly id="menu_id" name="menu_id" type="text" placeholder="Mã menu" required>
                        </div>
                        <div class="form-group">
                            <label for="menu_name">Tên Menu</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->menu_name}}" id="menu_name" name="menu_name" type="text" placeholder="Tên menu">
                        </div>
                        <div class="form-group">
                            <label for="menu_url">Link Url</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->menu_url}}" id="menu_url" name="menu_url" type="text" placeholder="Link url">
                        </div>
                        <div class="form-group">
                            <label for="menu_route">Tên Route</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->menu_route}}" id="menu_route" name="menu_route" type="text" placeholder="Tên route">
                        </div>
                        <div class="form-group">
                            <label for="menu_icon_class">Icon Class</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->menu_icon_class}}" id="menu_icon_class" name="menu_icon_class" type="text" placeholder="Icon class">
                        </div>
                        <div class="form-group">
                            <label for="sort_num">Thứ Tự</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->sort_num}}" id="sort_num" name="sort_num" type="text" placeholder="Thứ tự">
                        </div>
                        <div class="form-group">
                            <label for="screen_name">Loại Menu</label>
                            <div class="col-form-label pl-2">
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="menu_type_1" @if($menu->menu_type == \App\Models\Menu::MENU_TYPE_ADMIN_CODE) checked @endif type="radio" value="{{\App\Models\Menu::MENU_TYPE_ADMIN_CODE}}" name="menu_type">
                                    <label class="form-check-label" for="menu_type_1">Admin</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="menu_type_2" @if($menu->menu_type == \App\Models\Menu::MENU_TYPE_EMPLOYEE_CODE) checked @endif type="radio" value="{{\App\Models\Menu::MENU_TYPE_EMPLOYEE_CODE}}" name="menu_type">
                                    <label class="form-check-label" for="menu_type_2">Employee</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="screen_parent_id">Menu Cha</label>
                            <select class="form-control" id="parent_menu_id" name="parent_menu_id">
                                <option value="">Chọn menu cha</option>
                                @foreach($menuMap as $key_menu => $menusItem)
                                    <optgroup label="{{\App\Common\RoleConstant::menuTypeName($key_menu)}}">
                                        @foreach($menusItem as $key => $menuItem)
                                            <option value="{{$menuItem->menu_id}}" @if($menu->parent_menu_id == $menuItem->menu_id) selected @endif >{{$menuItem->menu_name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="child_sort_num">Thứ Tự Con</label>
                            <input autocomplete="off" class="form-control" value="{{$menu->child_sort_num}}" id="child_sort_num" name="child_sort_num" type="text" placeholder="Thứ tự con">
                        </div>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-lg btn-primary" type="submit">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>
@endsection
