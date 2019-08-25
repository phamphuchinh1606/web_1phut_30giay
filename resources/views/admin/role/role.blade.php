@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Quản Lý Role Hệ Thống
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th class="text-center" width="50">STT</th>
                    <th class="text-center" width="300">Tên Role</th>
                    <th class="text-center" width="100">Loại Role</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $role)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$role->role_name}}</td>
                            <td>{{$role->role_type->role_type_name}}</td>
                            <td>
                                <a class="btn btn-info" href="{{route('admin.setting.role.update',['id' => $role->id])}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-toggle="modal" class="btn btn-danger anchorClick"
                                   data-url="{{route('admin.setting.role.delete',['id' => $role->id]) }}"
                                   data-name="{{$role->role_name}}" href="#deleteModal">
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