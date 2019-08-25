@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Cập Nhật Role : {{$role->role_name}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form method="post" action="{{route('admin.setting.role.update',['id' => $role->id])}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="screen_id">Màn Hình</label>
                                    <select class="form-control" id="screen_id" name="screen_id">
                                        @foreach($screenMap as $key_screen => $screens)
                                            <optgroup label="{{\App\Common\RoleConstant::screenTypeName($key_screen)}}">
                                                @foreach($screens as $key => $screen)
                                                    <option value="{{$screen->screen_id}}">{{$screen->screen_name}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Chức Năng</label>
                                    <div class="col-md-9 col-form-label">
                                        @foreach($permissions as $permission)
                                            <div class="form-check form-check-inline mr-1">
                                                <input name="permission[]" class="form-check-input" id="inline-checkbox{{$permission->id}}" type="checkbox" value="{{$permission->id}}">
                                                <label class="form-check-label" for="inline-checkbox{{$permission->id}}">{{$permission->permission_name}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Quyền Hạn</label>
                                    <div class="col-md-9 col-form-label">
                                        @foreach($assignPermissions as $key => $assignPermission)
                                            <div class="form-check form-check-inline mr-1">
                                                <input name="assign_permission" class="form-check-input" id="inline-radio{{$key}}" type="radio" value="{{$key}}">
                                                <label class="form-check-label" for="inline-radio{{$key}}">{{$assignPermission}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-user"></i> Thêm Quyền </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Danh Sách Chức Năng
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                                <thead>
                                <tr role="row">
                                    <th class="text-center" >Màn Hình</th>
                                    <th class="text-center">Chức Năng</th>
                                    <th class="text-center">Quyền</th>
                                    <th class="text-center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($rolePermissionScreens as $rolePermissionScreen)
                                        <tr>
                                            <td>
                                                {{$rolePermissionScreen->screen->screen_name}}<br/>
                                                {{$rolePermissionScreen->screen_id}}

                                            </td>
                                            <td>{!! $rolePermissionScreen->permission_str !!}</td>
                                            <td>{{\App\Common\PermissionRoleCommon::getAssignPermissionName($rolePermissionScreen->assign_code)}}</td>
                                            <td>
                                                <a data-toggle="modal" class="btn btn-danger anchorClick"
                                                   data-url="{{route('admin.setting.role.screen.delete',['role_id' => $rolePermissionScreen->role_id, 'screen_id' => $rolePermissionScreen->screen_id]) }}"
                                                   data-name="{{$rolePermissionScreen->screen_id}}" href="#deleteModal">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection