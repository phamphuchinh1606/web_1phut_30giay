@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Nhập Thông Tin Nhân Viên</strong>

            <a class="btn btn-sm btn-secondary pull-right" href="{{route('admin.employee')}}" >Quay lại</a>
        </div>
        <form action="{{route('admin.employee.create')}}" method="post">
            @csrf
            <input type="hidden" value="{{$branchId}}" name="branch_id">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Tên Nhân Viên</label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="Tên nhân viên" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số Điện Thoại</label>
                            <input class="form-control" id="phone" name="phone" type="text" placeholder="Số điện thoại">
                        </div>
                        <div class="form-group">
                            <label for="email">Địa Chỉ Email</label>
                            <input class="form-control" id="email" name="email" type="text" placeholder="Địa chỉ email">
                        </div>
                        <div class="form-group">
                            <label for="identity_card">Số Chứng Minh Nhân Dân</label>
                            <input class="form-control" id="identity_card" name="identity_card" type="text" placeholder="Số CMND">
                        </div>
                        <div class="form-group">
                            <label for="price_first_hour">Lương 3 Giờ Đầu</label>
                            <input class="form-control number" id="price_first_hour" name="price_first_hour" type="text" placeholder="Lương 3 giờ đầu">
                        </div>
                        <div class="form-group">
                            <label for="price_last_hour">Lương 2 Giờ Sau</label>
                            <input class="form-control number" id="price_last_hour" name="price_last_hour" type="text" placeholder="Lương 2 giờ sau">
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
                                            <input name="selected_branch[]" class="form-check-input" id="branch_id_{{$branch->id}}" type="checkbox" value="{{$branch->id}}">
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
                                            <input class="form-check-input" name="default_branch_id" @if($branch->id == 1) checked @endif id="inline-checkbox_{{$branch->id}}" type="radio" value="{{$branch->id}}">
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
                                            <input class="switch-input" type="checkbox" name="assign_employee">
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
                    <i class="fa fa-dot-circle-o"></i> Thêm Mới Nhân Viên</button>
            </div>
        </form>
    </div>
@endsection
