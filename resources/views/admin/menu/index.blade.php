@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Danh Sách Menu
            <a class="btn btn-sm btn-primary pull-right" href="{{route('admin.setting.menu.create')}}" >Thêm Menu</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th class="text-center" width="50">STT</th>
                    <th class="text-center">Mã</th>
                    <th class="text-center">Tên</th>
                    <th class="text-center hide-item-sm">Url</th>
                    <th class="text-center">Loại</th>
                    <th class="text-center">Hiển Thị</th>
                    <th class="text-center">Thứ Tự</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($listMenu as $index => $menu)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$menu->menu_id}}</td>
                        <td>{{$menu->menu_name}}</td>
                        <td class="hide-item-sm">
                            {{$menu->menu_url}}
                        </td>
                        <td class="hide-item-sm">
                            {{\App\Common\RoleConstant::menuTypeName($menu->menu_type)}}
                        </td>
                        <td>
                            {{\App\Helpers\AppHelper::isShowName($menu->is_show)}}
                        </td>
                        <td>
                            {{$menu->sort_num}}
                            @if($menu->child_sort_num)
                                <br>Sort-Child : {{$menu->child_sort_num}}
                            @endif
                        </td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{route('admin.setting.menu.update',['id' => $menu->menu_id])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                               data-url="{{route('admin.setting.menu.delete',['id' => $menu->menu_id]) }}"
                               data-name="{{$menu->menu_name}}" href="#deleteModal">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
