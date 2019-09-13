@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header text-center">
            <h1 class="font-weight-bold">Phiếu Lương</h1>
        </div>
        <div class="card-body">
            <div class="row font-2xl">
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Tên Nhân Viên : </label>
                        <div class="col-7">
                            <label class="col-form-label font-weight-bold">{{$employee->name}}</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Tháng : </label>
                        <div class="col-9">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row font-2xl">
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Tổng Giờ : </label>
                        <div class="col-7">
                            <label class="col-form-label font-weight-bold">{{$employee->total_first_hour + $employee->total_last_hour}} giờ</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">Thành Tiền : </label>
                        <div class="col-8">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\AppHelper::formatMoney($employee->total_first_amount + $employee->total_last_amount)}} VNĐ</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row font-2xl">
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Chuyên Cần : </label>
                        <div class="col-7">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\AppHelper::formatMoney($employee->diligence_amount)}} VNĐ</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">Phụ Cấp : </label>
                        <div class="col-8">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\AppHelper::formatMoney($employee->allowance_amount)}} VNĐ</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row font-2xl">
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Thưởng : </label>
                        <div class="col-7">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\AppHelper::formatMoney($employee->bonus_amount)}} VNĐ</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-5 col-form-label">Thưởng xe nhỏ : </label>
                        <div class="col-7">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\AppHelper::formatMoney($employee->extra_allowance_amount)}} VNĐ</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row font-3xl">
                <div class="col-12">
                    <div class="form-group row">
                        <label class="col-5 col-form-label font-weight-bold">Tổng Lương </label>
                        <div class="col-7">
                            <label class="col-form-label font-weight-bold">{{\App\Helpers\AppHelper::formatMoney($employee->salary_amount)}} VNĐ</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        @foreach($infoDays as $index => $day)
                            @if($day->week_no == 1 || $index == 0)
                                <tr class="text-center">
                                    <td class="font-2xl">Tuần {{$day->week_of_thing}}</td>
                            @endif
                                    <td>
                                        {{$day->week_day}}<br/>
                                        {{$day->date_str}}<br/>
                                        <span class="font-2xl">
                                            {{$day->total_first_hour + $day->total_last_hour}}
                                        </span>
                                        giờ
                                    </td>
                            @if($day->week_no == 0)
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
