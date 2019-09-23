@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Danh Sách Màn Hình
            <a class="btn btn-sm btn-primary pull-right" href="{{route('admin.setting.screen.create')}}" >Thêm Màn Hình</a>
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
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($screens as $index => $screen)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$screen->screen_id}}</td>
                        <td>{{$screen->screen_name}}</td>
                        <td class="hide-item-sm">
                            {{$screen->screen_url}}
                        </td>
                        <td class="hide-item-sm">
                            {{\App\Common\RoleConstant::screenTypeName($screen->screen_type)}}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{route('admin.setting.screen.update',['id' => $screen->screen_id])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                               data-url="{{route('admin.setting.screen.delete',['id' => $screen->screen_id]) }}"
                               data-name="{{$screen->screen_name}}" href="#deleteModal">
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
