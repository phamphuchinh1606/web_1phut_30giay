@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Nhập Thông Tin Nhân Viên</strong>
        </div>
        <form action="{{route('admin.employee.update',['id' => $employee->id])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Tên Nhân Viên</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Tên nhân viên" value="{{$employee->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số Điện Thoại</label>
                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Số điện thoại" value="{{$employee->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Địa Chỉ Email</label>
                            <input class="form-control" id="email" name="email" type="text" placeholder="Địa chỉ email" value="{{$employee->email}}">
                        </div>
                        <div class="form-group">
                            <label for="identity_card">Số Chứng Minh Nhân Dân</label>
                            <input class="form-control" id="identity_card" name="identity_card" type="text" placeholder="Số CMND" value="{{$employee->identity_card}}">
                        </div>
                        <div class="form-group">
                            <label for="price_first_hour">Lương 3 Giờ Đầu</label>
                            <input class="form-control number text-right" id="price_first_hour" name="price_first_hour" type="text" placeholder="Lương 3 giờ đầu" value="{{$employee->price_first_hour}}">
                        </div>
                        <div class="form-group">
                            <label for="price_last_hour">Lương 2 Giờ Sau</label>
                            <input class="form-control number text-right" id="price_last_hour" name="price_last_hour" type="text" placeholder="Lương 2 giờ sau" value="{{$employee->price_last_hour}}">
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
                                            <input name="selected_branch[]" @if($employee->checkAssetBranch($branch->id)) checked @endif class="form-check-input" id="branch_id_{{$branch->id}}" type="checkbox" value="{{$branch->id}}">
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
                                            <input class="form-check-input" name="default_branch_id" @if($employee->default_branch_id == $branch->id) checked @endif id="inline-checkbox_{{$branch->id}}" type="radio" value="{{$branch->id}}">
                                            <label class="form-check-label" for="inline-checkbox_{{$branch->id}}">{{$branch->branch_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <strong>Phụ Trách Xe Nhỏ</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-group row p-2">
                                    <label class="col-md-3 col-4 col-form-label" for="text-input">Bật Phụ Trách</label>
                                    <div class="col-md-9 col-8">
                                        <label class="switch switch-label switch-outline-primary-alt">
                                            <input class="switch-input" type="checkbox" {{$employee->is_check_assign}} name="assign_employee">
                                            <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                    </div>
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
                    <form action="{{route('admin.employee.add_role',['id' => $employee->id])}}" method="post">
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
                            @foreach($employeeRoles as $key => $employeeRole)
                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>
                                    <td>{{$employeeRole->role->role_name}}</td>
                                    <td>
                                        <a data-toggle="modal" class="btn btn-danger anchorClick"
                                           data-url="{{route('admin.employee.delete_role',['id' => $employee->id, 'employee_role_id' => $employeeRole->id]) }}"
                                           data-name="{{$employeeRole->role->role_name}}" href="#deleteModal">
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
