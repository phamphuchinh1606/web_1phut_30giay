@extends('admin.layouts.master')

<style>
    table.dataTable{
        width: auto;
    }
    table.dataTable input{
        width: 100px;
        text-align: right;
    }
    table.dataTable th{
        background-color: #4aa0e6;
    }
    table.dataTable th, table.dataTable td{
        padding: 2px;
        vertical-align: middle !important;
    }
    table.dataTable .no{
        width: 20px;
    }
    table.dataTable .name{
        width: 120px;
    }
    table.dataTable .unit{
        width: 60px;
    }
    table.dataTable .price{
        width: 80px;
    }
    table.dataTable .first-qty{
        width: 80px;
    }
    table.dataTable .check-in{
        width: 100px;
    }
    table.dataTable .amount-in{
        width: 100px;
    }
    table.dataTable .move-in{
        width: 100px;
    }
    table.dataTable .move-out{
        width: 100px;
    }
    table.dataTable .last-qty{
        width: 100px;
    }
    table.dataTable .check-out{
        width: 100px;
    }
    table.dataTable .cancel{
        width: 100px;
    }
</style>

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Số Lượng Bán Ngày : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y/m/d')}}
            <input name="current_date" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m-d')}}">
            <hr>
            <nav class="nav nav-pills flex-column flex-sm-row">
                @foreach($infoDays as $day)
                    <?php $isCurrent = \App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m-d') == $day->date_str; ?>
                    @if($isCurrent)
                        <a class="flex-sm-fill text-sm-center nav-link active" href="#">
                            {{$day->date_str}} <span style="color: red">({{$day->week_day}})</span>
                        </a>
                    @else
                        <a class="flex-sm-fill text-sm-center nav-link" href="{{route('admin.input_daily',['date' => $day->date_str])}}">
                            {{$day->date_str}} <span style="color: red">({{$day->week_day}})</span>
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th rowspan="2" class="text-center no">MSP</th>
                    <th rowspan="2" class="text-center name">Tên Sản Phẩm</th>
                    <th rowspan="2" class="text-center unit">Đơn Vị</th>
                    <th rowspan="2" class="text-center price">Đơn Giá</th>
                    <th rowspan="2" class="text-center first-qty">Tồn Đầu</th>
                    <th rowspan="2" class="text-center check-in">Nhập</th>
                    <th rowspan="2" class="text-center amount-in">Thành Tiền</th>
                    <th rowspan="2" class="text-center move-in">Nhập Chuyển</th>
                    <th rowspan="2" class="text-center move-out">Xuất Chuyển</th>
                    <th colspan="2" class="text-center">Xuất</th>
                    <th rowspan="2" class="text-center last-qty">Tồn Cuối</th>
                </tr>
                <tr>
                    <th class="text-center check-out">Xuất</th>
                    <th class="text-center cancel">Hủy</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materialTypes as $materialType)
                    <tr role="row" style="background-color: yellowgreen">
                        <td colspan="12" class="font-weight-bold">{{$materialType->material_type_name}}</td>
                    </tr>
                    @if(isset($materials))
                        @foreach($materials as $material)
                            @if($material->material_type_id == $materialType->id)
                                <tr role="row">
                                    <td class="hide">
                                        <input type="hidden" value="{{$material->id}}" name="material_id">
                                        <input type="hidden" value="{{$material->price}}" name="price">
                                    </td>
                                    <td class="text-center">{{$material->id}}</td>
                                    <td>{{$material->material_name}}</td>
                                    <td>{{$material->unit->unit_name}}</td>
                                    <td class="text-right">
                                        {{\App\Helpers\AppHelper::formatMoney($material->price)}}
{{--                                        <input class="input-daily" name="price_{{$material->id}}" value="{{\App\Helpers\AppHelper::formatMoney($material->price)}}">--}}
                                    </td>
                                    <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($material->qty_first)}}</td>
                                    <td>
                                        <input class="input-daily double" name="qty_in" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_in)}}">
                                    </td>
                                    <td class="text-right"><span class="amount_in">{{\App\Helpers\AppHelper::formatMoney($material->amount_in)}}</span></td>
                                    <td>
                                        <input class="input-daily double" name="qty_in_move" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_in_move)}}">
                                    </td>
                                    <td>
                                        <input class="input-daily double" name="qty_out_move" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_out_move)}}">
                                    </td>
                                    <td class="text-right"><span class="qty_out">{{\App\Helpers\AppHelper::formatMoney($material->qty_out)}}</span></td>
                                    <td>
                                        <input class="input-daily double" name="qty_cancel" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_cancel)}}">
                                    </td>
                                    <td>
                                        <input class="input-daily double" name="qty_last" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_last)}}">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-center" style="background-color: #5cd08d">Tổng Tiền Nhập</td>
                        <td class="text-right" style="color: red"><span class="total-amount-check-in">{{\App\Helpers\AppHelper::formatMoney($totalAmountCheckIn)}}</span></td>
                        <td colspan="2" class="text-center" style="background-color: #5cd08d">Tổng Tiền Xuất</td>
                        <td class="text-right" style="color: red"><span class="total-amount-check-out">{{\App\Helpers\AppHelper::formatMoney($totalAmountCheckOut)}}</span></td>
                    </tr>
                </tfoot>
            </table>
            <div>
                <h2>Bản Chấm Công</h2>
                <table class="table table-striped table-bordered datatable dataTable no-footer" style="float:left">
                    <thead>
                    <tr role="row">
                        <th rowspan="2" class="text-center" width="70px">Mã NV</th>
                        <th rowspan="2" class="text-center" width="150px">Tên Nhân Viên</th>
                        <th rowspan="2" class="text-center" width="100px">3 Giờ Đầu</th>
                        <th rowspan="2" class="text-center" width="100px">2 Giờ Sau</th>
                        <th rowspan="2" class="text-center name">Tổng</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td class="hide">
                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                </td>
                                <td class="text-center">{{$employee->id}}</td>
                                <td>{{$employee->name}}</td>
                                <td>
                                    <input class="input-employee double" name="first_hours" value="{{$employee->first_hours}}">
                                </td>
                                <td>
                                    <input class="input-employee double" name="last_hours" value="{{$employee->last_hours}}">
                                </td>
                                <td class="text-right"><span class="total-amount-employee">{{\App\Helpers\AppHelper::formatMoney($employee->total_amount_employee)}}</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-center">Tổng Giờ Công</td>
                            <td class="text-right"><span class="total-first-hour">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->first_hours_total)}}</span></td>
                            <td class="text-right"><span class="total-last-hour">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->last_hours_total)}}</span></td>
                            <td class="text-right"><span class="total-hour">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->first_hours_total + $sumEmployeeTotal->last_hours_total)}}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">Thành Tiền</td>
                            <td class="text-right"><span class="total-first-amount">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->amount_first_total)}}</span></td>
                            <td class="text-right"><span class="total-last-amount">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->amount_last_total)}}</span></td>
                            <td class="text-right"><span class="total-amount">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->amount_first_total + $sumEmployeeTotal->amount_last_total)}}</span></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-striped table-bordered datatable dataTable no-footer" id="table-bill" style="margin-left: 50px;float: left">
                    <thead>
                    <tr role="row">
                        <th rowspan="2" class="text-center" width="150px">Sản Phẩm</th>
                        <th rowspan="2" class="text-center" width="100px">Đơn Giá</th>
                        <th rowspan="2" class="text-center" width="100px">Số Lượng</th>
                        <th rowspan="2" class="text-center" width="100px">Thành Tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr id="{{$product->id}}">
                                <td>{{$product->product_name}}</td>
                                <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($product->price)}}</td>
                                <td class="text-right">
                                    @if($product->id > 4)
                                        <input class="input-sale double" name="product_{{$product->id}}" value="{{\App\Helpers\AppHelper::formatMoney($product->qty)}}">
                                        <input type="hidden" name="product_the_same_id" value="{{$product->product_the_same_id}}">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                    @else
                                        <span class="product-{{$product->id}}">{{\App\Helpers\AppHelper::formatMoney($product->qty)}}</span>
                                    @endif
                                </td>
                                <td class="text-right"><span class="product-amount">{{\App\Helpers\AppHelper::formatMoney($product->amount)}}</span></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-center">Doanh Thu</td>
                            <td class="text-right"><span class="total-amount">{{\App\Helpers\AppHelper::formatMoney($orderBill->total_amount)}}</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Tiền Thực Thu</td>
                            <td class="text-right">
                                <input class="input-bill double" value="{{\App\Helpers\AppHelper::formatMoney($orderBill->real_amount)}}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Tiền Thiếu</td>
                            <td class="text-right"><span class="lack-amount">{{\App\Helpers\AppHelper::formatMoney($orderBill->lack_amount)}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/input-daily.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('input.input-daily').on('change',function(){
                InputDailyAPI.updateInputDaily(this);
            });

            $('input.input-sale').on('change',function(){
                InputDailyAPI.updateSaleDaily(this);
            });

            $('input.input-bill').on('change',function(){
                InputDailyAPI.updateBillDaily(this);
            });

            $('input.input-employee').on('change',function(){
                InputDailyAPI.updateEmployeeDaily(this);
            });
        });
    </script>
@endsection

