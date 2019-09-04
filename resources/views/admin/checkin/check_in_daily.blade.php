@extends('admin.layouts.master')

@section('head.css')
    <style>
        table.dataTable{
            width: auto;
        }
        table.dataTable th, table.dataTable td{
            padding: 3px;
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('body.content')
@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Danh Sách Đặt Hàng Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer table-overflow-x" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th width="80" rowspan="2" class="text-center">Ngày</th>
                    <th width="80" rowspan="2" class="text-center">Thứ</th>
                    @foreach($suppliers as $supplier)
                        <th class="text-center" colspan="2">{{$supplier->supplier_name}}</th>
                        <th class="text-center" colspan="2">Tổng</th>
                    @endforeach
                    <th width="100" rowspan="2">Tổng Chi</th>
                </tr>
                <tr>
                    @foreach($suppliers as $supplier)
                        <th width="80" class="text-center">Số Lượng</th>
                        <th width="100" class="text-center">Thành Tiền</th>
                        <th width="80" class="text-center">Số Lượng</th>
                        <th width="100" class="text-center">Tiền</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    @foreach($infoDays as $index=>$day)
                        @if($day->week_no == 1 || $index == 0)
                            <tr style="background-color: #5cd08d;height: 15px;border-top: solid 2px">
                                <td colspan="{{count($suppliers) + 9}}">
                                    Tuần {{$day->week_of_thing}}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-center">
                                {{$day->date_str}}
                            </td>
                            <td class="text-center">
                                {{$day->week_day}}
                            </td>
                            @foreach($day->suppliers as $supplier)
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($supplier->total_qty)}}
                                </td>
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($supplier->total_amount)}}
                                </td>
                                @if($day->week_no == 1 || $index == 0)
                                    <td class="text-right" rowspan="@if($index == 0 && $day->week_no == 0) 1 @else {{8 - $day->week_no}} @endif">
                                        <?php $valueQty =0; eval('$valueQty=$day->week->total_qty_'.$supplier->supplier_id.';') ?>
                                        {{\App\Helpers\AppHelper::formatMoney($valueQty)}}
                                    </td>
                                    <td class="text-right" rowspan="@if($index == 0 && $day->week_no == 0) 1 @else {{8 - $day->week_no}} @endif ">
                                        <?php $valueAmount =0; eval('$valueAmount=$day->week->total_amount_'.$supplier->supplier_id.';') ?>
                                        {{\App\Helpers\AppHelper::formatMoney($valueAmount)}}
                                    </td>
                                @endif
                            @endforeach
                            @if($day->week_no == 1 || $index == 0)
                                <td class="text-right" rowspan="@if($index == 0 && $day->week_no == 0) 1 @else {{8 - $day->week_no}} @endif">
                                {{\App\Helpers\AppHelper::formatMoney($day->week->sum_total_amount)}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
