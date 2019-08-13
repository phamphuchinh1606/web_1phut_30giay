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
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Doanh Số Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th width="80" rowspan="2">Ngày</th>
                    <th width="80" rowspan="2">Thứ</th>
                    <th colspan="{{count($products)}}" class="text-center sale-num">Số Lượng Bán</th>
                    <th rowspan="2" class="text-center" width="80">Tổng Phần</th>
                    <th rowspan="2" class="text-center" width="80">Tổng Tiền</th>
                    <th rowspan="2" class="text-center" width="80">Tiền Thu Thực Tế</th>
                    <th rowspan="2" class="text-center" width="80">Tiền Thiếu</th>
                    <th rowspan="2" colspan="2"></th>
                </tr>
                <tr>
                    @foreach($products as $product)
                        <th class="text-center" width="120">{{$product->product_name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    @foreach($infoDays as $index=>$day)
                        @if($day->week_no == 1 || $index == 0)
                            <tr style="background-color: #5cd08d;height: 15px;border-top: solid 2px">
                                <td colspan="{{count($products) + 8}}">
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
                            @foreach($day->sale_products as $saleProduct)
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($saleProduct->qty)}}
                                </td>
                            @endforeach
                            <td class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($day->sum_qty)}}
                            </td>
                            <td class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($day->sum_amount)}}
                            </td>
                            <td  class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($day->real_amount)}}
                            </td>
                            <td  class="text-right">
                                {{\App\Helpers\AppHelper::formatMoney($day->lack_amount)}}
                            </td>
                            @if($day->week_no == 1 || $index == 0)
                                <td style="border-left: solid 2px">Doanh Thu</td>
                                <td class="text-right" width="80">
                                    {{\App\Helpers\AppHelper::formatMoney($day->week->sum_real_amount)}}
                                </td>
                            @elseif($day->week_no == 2 || $index == 1)
                                <td style="border-left: solid 2px">Tiền Công</td>
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($day->week->sum_time_keeping_amount)}}
                                </td>
                            @elseif($day->week_no == 3 || $index == 2)
                                <td style="border-left: solid 2px">Tiền Đặt Hàng</td>
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($day->week->sum_check_in_amount)}}
                                </td>
                            @elseif($day->week_no == 4 || $index == 3)
                                <td style="border-left: solid 2px">Tiền Chi</td>
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($day->week->sum_payment_bill_amount)}}
                                </td>
                            @elseif($day->week_no == 5 || $index == 4)
                                <td style="border-left: solid 2px">Lợi Nhuận</td>
                                <td class="text-right">
                                    {{\App\Helpers\AppHelper::formatMoney($day->week->sum_profit_amount)}}
                                </td>
                            @else
                                <td style="border-left: solid 2px" colspan="2"></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
