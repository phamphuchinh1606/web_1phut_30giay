@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Cập Nhật Thông Tin Nhân Viên Quản Lý</strong>
        </div>
        <form action="{{route('admin.user.update',['id' => $user->id])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Tên Nhân Viên</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Tên nhân viên" value="{{$user->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số Điện Thoại</label>
                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Số điện thoại" value="{{$user->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Địa Chỉ Email</label>
                            <input class="form-control" id="email" name="email" type="text" placeholder="Địa chỉ email" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label for="identity_card">Số Chứng Minh Nhân Dân</label>
                            <input class="form-control" id="identity_card" name="identity_card" type="text" placeholder="Số CMND" value="{{$user->identity_card}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <strong>Chi Nhánh Làm Việc</strong>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    @foreach($branches as $branch)
                                        <div class="form-check checkbox">
                                            <input name="selected_branch[]" @if($user->checkAssetBranch($branch->id)) checked @endif class="form-check-input" id="branch_id_{{$branch->id}}" type="checkbox" value="{{$branch->id}}">
                                            <label class="form-check-label" for="branch_id_{{$branch->id}}">{{$branch->branch_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <strong>Chi Nhánh Mặc Định</strong>
                            </div>
                            <div class="card-body">
                                <div class="col-md-9 col-form-label">
                                    @foreach($branches as $branch)
                                        <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" name="default_branch_id" @if($user->default_branch_id == $branch->id) checked @endif id="inline-checkbox_{{$branch->id}}" type="radio" value="{{$branch->id}}">
                                            <label class="form-check-label" for="inline-checkbox_{{$branch->id}}">{{$branch->branch_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i> Cập Nhật</button>
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <strong>Quyền Nhân Viên</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{route('admin.user.add_role',['id' => $user->id])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="role_id">Quyền</label>
                            <select class="form-control" id="role_id" name="role_id">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}">{{$role->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fa fa-dot-circle-o"></i> Thêm Quyền</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 p-3">
                    <table class="table dataTable table-responsive-sm table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th width="50">STT</th>
                            <th>Quyền</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($userRoles as $key => $userRole)
                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>{{$userRole->role->role_name}}</td>
                                    <td>
                                        <a data-toggle="modal" class="btn btn-danger anchorClick"
                                           data-url="{{route('admin.user.delete_role',['id' => $user->id, 'user_role_id' => $userRole->id]) }}"
                                           data-name="{{$userRole->role->role_name}}" href="#deleteModal">
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
@endsection
