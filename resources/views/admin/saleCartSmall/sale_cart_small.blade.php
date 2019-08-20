@extends('admin.layouts.master')
<style>
    table.dataTable{
    width: auto;
    }
    table.dataTable input{
        width: 70px;
        text-align: right;
    }
    table.dataTable th, table.dataTable td{
        padding: 5px;
        vertical-align: middle !important;
    }
</style>

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Bản Chấm Công Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th rowspan="2" class="text-center">Ngày</th>
                    <th rowspan="2" class="text-center">Thứ</th>
                    <th colspan="{{count($employees)}}" class="text-center">Doanh Số (Phần)</th>
                    <th colspan="{{count($employees)}}" class="text-center">Dư Chỉ Tiêu (Phần)</th>
                    <th colspan="{{count($employees)}}" class="text-center">Thành Tiền</th>
                </tr>
                <tr>
                    @foreach($employees as $employee)
                        <th class="text-center" width="80">{{$employee->name}}</th>
                    @endforeach
                    @foreach($employees as $employee)
                        <th class="text-center" width="80">{{$employee->name}}</th>
                    @endforeach
                    @foreach($employees as $employee)
                        <th class="text-center" width="80">{{$employee->name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <?php $weekNo = 1;?>
                @foreach($infoDays as $index => $day)
                    @if($day->week_no == 1 || $index == 0)
                        <tr style="background-color: #5cd08d;height: 15px;border-top: solid 2px">
                            <td colspan="{{count($employees)*3 + 2}}">
                                Tuần {{$weekNo}}
                            </td>
                        </tr>
                        <?php $weekNo++;?>
                    @endif
                    <tr style="border-top: solid 2px">
                        <td class="text-center">
                            {{$day->date_str}}
                            <input type="hidden" name="sale_date" value="{{$day->date_str}}">
                        </td>
                        <td class="text-center">
                            {{$day->week_day}}
                        </td>
                        @foreach($day->employee_sale_card_smalls as $saleCardSmall)
                            <td class="text-right">
                                <input class="input-sale-card-small" name="qty" value="{{\App\Helpers\AppHelper::formatMoney($saleCardSmall->qty)}}">
                                <input type="hidden" name="employee_id" value="{{$saleCardSmall->employee_id}}">
                            </td>
                        @endforeach
                        @foreach($day->employee_sale_card_smalls as $saleCardSmall)
                            <td class="text-right">
                                <span class="qty-target-{{$saleCardSmall->employee_id}}">
                                    {{\App\Helpers\AppHelper::formatMoney($saleCardSmall->qty_target)}}
                                </span>
                            </td>
                        @endforeach
                        @foreach($day->employee_sale_card_smalls as $saleCardSmall)
                            <td class="text-right">
                                <span class="bonus-amount-{{$saleCardSmall->employee_id}}">
                                    {{\App\Helpers\AppHelper::formatMoney($saleCardSmall->bonus_amount)}}
                                </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Tổng</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/input-sale-cart-small.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('input.input-sale-card-small').on('change',function(){
                InputSaleCartSmallAPI.updateInputDaily(this);
            });
        });
    </script>
@endsection
