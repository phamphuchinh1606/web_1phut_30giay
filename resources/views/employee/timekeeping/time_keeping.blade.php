@extends('employee.layouts.master')

<style>
    table.dataTable{
        width: auto;
    }
    table.dataTable input{
        width: 100px;
        text-align: right;
    }
    table.dataTable th, table.dataTable td{
        padding: 3px;
        vertical-align: middle !important;
    }
    table.dataTable .date{
        width: 100px;
    }
    table.dataTable .employee{
        width: 80px;
    }
    table.dataTable .name{
        width: 100px;
    }
    table.dataTable .total-employee-hour{
        width: 80px;
    }
    table.dataTable .total-employee-amount{
        width: 100px;
    }
    table.dataTable .total-amount{
        width: 100px;
    }
    table.dataTable .total-week-amount{
        width: 100px;
    }
</style>

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Bản Chấm Công Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer table-overflow-x" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th rowspan="2" class="text-center date"></th>
                    <th rowspan="2" class="text-center employee">Nhân viên</th>
                    @foreach($employees as $employee)
                        <th class="text-center name">{{$employee->id}}</th>
                    @endforeach
                    <th rowspan="2" class="text-center total-employee-hour">Tổng Giờ</th>
                    <th rowspan="2" class="text-center total-employee-amount">Thành Tiền</th>
                    <th rowspan="2" class="text-center total-amount">Tổng Tiền</th>
                    <th rowspan="2" class="text-center total-week-amount">Tổng Tuần</th>
                </tr>
                <tr>
                    @foreach($employees as $employee)
                        <th class="text-center">{{$employee->name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <?php $weekNo = 1;?>
                    @foreach($infoDays as $index => $day)
                        @if($day->week_no == 1 || $index == 0)
                            <tr style="background-color: #5cd08d;height: 15px;border-top: solid 2px">
                                <td colspan="{{count($employees) + 6}}">
                                    Tuần {{$weekNo}}
                                </td>
                            </tr>
                            <?php $weekNo++;?>
                        @endif
                        <tr style="border-top: solid 2px">
                            <td rowspan="2" class="text-center">
                                {{$day->week_day}}<br/>
                                {{$day->date_str}}
                            </td>
                            <td class="text-center">Giờ Đầu</td>
                            @foreach($day->employeeDailies as $employee)
                                <td class="text-right">{{$employee->first_hours}}</td>
                            @endforeach
                            <td class="text-right">{{$day->total_first_hour}}</td>
                            <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($day->total_first_amount)}}</td>
                            <td rowspan="2" class="text-right">{{\App\Helpers\AppHelper::formatMoney($day->total_amount)}}</td>
                            @if($day->week_no == 1 || $index == 0)
                                @if($index == 0 && $day->week_no == 0)
                                    <td rowspan="2" class="text-right">{{\App\Helpers\AppHelper::formatMoney($day->total_week_amount)}}</td>
                                @else
                                    <td rowspan="{{(8 - $day->week_no)*2}}" class="text-right">{{\App\Helpers\AppHelper::formatMoney($day->total_week_amount)}}</td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td class="text-center">Giờ Sau</td>
                            @foreach($day->employeeDailies as $employee)
                                <td class="text-right">{{$employee->last_hours}}</td>
                            @endforeach
                            <td class="text-right">{{$day->total_last_hour}}</td>
                            <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($day->total_last_amount)}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #5cd08d;">
                        <td colspan="{{count($employees) + 6}}">
                            &nbsp;
                        </td>
                    </tr>
                    <tr role="row">
                        <th colspan="2" class="text-center employee">NV</th>
                        @foreach($employees as $employee)
                            <th class="text-center">
                                {{$employee->name}}
                            </th>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td rowspan="2" class="text-center employee">Tổng Giờ</td>
                        <td>Giờ Đầu</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                {{$employee->total_first_hour}}
                                <input type="hidden" name="total_first_hour" value="{{$employee->total_first_hour}}">
                                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td>Giờ Sau</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                {{$employee->total_last_hour}}
                                <input type="hidden" name="total_last_hour" value="{{$employee->total_last_hour}}">
                                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td rowspan="2" class="text-center employee">Tổng Tiền</td>
                        <td>Giờ Đầu</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($employee->total_first_amount)}}
                                <input type="hidden" name="total_first_amount" value="{{$employee->total_first_amount}}">
                                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td>Giờ Sau</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($employee->total_last_amount)}}
                                <input type="hidden" name="total_last_amount" value="{{$employee->total_last_amount}}">
                                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Thành Tiền</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($employee->total_first_amount + $employee->total_last_amount)}}
                                <input type="hidden" name="total_last_amount" value="{{$employee->total_first_amount + $employee->total_last_amount}}">
                                <input type="hidden" name="employee_id" value="{{$employee->id}}">
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Chuyên Cần</td>
                        @foreach($employees as $employee)
                            <td>
                                @can('time_keeping.update')
                                    <input class="input-time-keeping form-control number" name="diligence_amount" value="{{\App\Helpers\AppHelper::formatMoney($employee->diligence_amount)}}">
                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                @else
                                    <span>{{\App\Helpers\AppHelper::formatMoney($employee->diligence_amount)}}</span>
                                @endcan
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Phụ Cấp</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                @can('time_keeping.update')
                                    <input class="input-time-keeping form-control number" name="allowance_amount" value="{{\App\Helpers\AppHelper::formatMoney($employee->allowance_amount)}}">
                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                @else
                                    <span>{{\App\Helpers\AppHelper::formatMoney($employee->allowance_amount)}}</span>
                                @endcan
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Thưởng</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                @can('time_keeping.update')
                                    <input class="input-time-keeping form-control number" name="bonus_amount" value="{{\App\Helpers\AppHelper::formatMoney($employee->bonus_amount)}}">
                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                @else
                                    <span>{{\App\Helpers\AppHelper::formatMoney($employee->bonus_amount)}}</span>
                                @endcan
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">Phụ Cấp Thêm</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                @can('time_keeping.update')
                                    <input class="input-time-keeping form-control number" name="extra_allowance_amount" value="{{\App\Helpers\AppHelper::formatMoney($employee->extra_allowance_amount)}}">
                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                @else
                                    <span>{{\App\Helpers\AppHelper::formatMoney($employee->extra_allowance_amount)}}</span>
                                @endcan
                            </td>
                        @endforeach
                        <th colspan="4" class="text-center"></th>
                    </tr>
                    <tr style="color: red">
                        <td colspan="2" class="text-center">Lương Nhân Viên</td>
                        @foreach($employees as $employee)
                            <td class="text-right">
                                <span class="salary-amount-{{$employee->id}}">
                                    {{\App\Helpers\AppHelper::formatMoney($employee->salary_amount)}}
                                </span>
                            </td>
                        @endforeach
                        <td colspan="4" class="text-center">
                           <span class="total-salary-amount">{{\App\Helpers\AppHelper::formatMoney($totalSalaryAmount)}}</span>
                            VNĐ
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/time-keeping.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('input.input-time-keeping').on('change',function(){
                TimeKeepingAPI.updateTimeKeeping(this);
            });
        });
    </script>
@endsection
