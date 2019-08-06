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
        width: 80px;
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
                                        <input class="input-daily" name="qty_in" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_in)}}">
                                    </td>
                                    <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($material->amount_in)}}</td>
                                    <td>
                                        <input class="input-daily" name="qty_in_move" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_in_move)}}">
                                    </td>
                                    <td>
                                        <input class="input-daily" name="qty_out_move" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_out_move)}}">
                                    </td>
                                    <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($material->qty_out)}}</td>
                                    <td>
                                        <input class="input-daily" name="qty_cancel" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_cancel)}}">
                                    </td>
                                    <td>
                                        <input class="input-daily" name="qty_last" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_last)}}">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right">Tổng Tiền Nhập</td>
                        <td class="text-right">{{0}}</td>
                        <td colspan="2" class="text-right">Tổng Tiền Xuất</td>
                        <td class="text-right">{{0}}</td>
                    </tr>
                </tfoot>
            </table>
            <div>
                <h2>Bản Chấm Công</h2>
                <table class="table table-striped table-bordered datatable dataTable no-footer" style="float:left">
                    <thead>
                    <tr role="row">
                        <th rowspan="2" class="text-center" width="50px">Mã NV</th>
                        <th rowspan="2" class="text-center" width="150px">Tên Nhân Viên</th>
                        <th rowspan="2" class="text-center" width="100px">3 Giờ Đầu</th>
                        <th rowspan="2" class="text-center" width="100px">2 Giờ Sau</th>
                        <th rowspan="2" class="text-center name">Tổng</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->name}}</td>
                                <td>
                                    <input>
                                </td>
                                <td>
                                    <input>
                                </td>
                                <td class="text-right">{{0}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-center">Tổng Giờ Công</td>
                            <td class="text-right">{{0}}</td>
                            <td class="text-right">{{0}}</td>
                            <td class="text-right">{{0}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">Thành Tiền</td>
                            <td class="text-right">{{0}}</td>
                            <td class="text-right">{{0}}</td>
                            <td class="text-right">{{0}}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-striped table-bordered datatable dataTable no-footer" style="margin-left: 50px;float: left">
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
                            <tr>
                                <td>{{$product->product_name}}</td>
                                <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($product->price)}}</td>
                                <td>
                                    <input>
                                </td>
                                <td class="text-right">{{0}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-center">Doanh Thu</td>
                            <td class="text-right">{{0}}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Tiền Thực Thu</td>
                            <td class="text-right">
                                <input>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Tiền Thiếu</td>
                            <td class="text-right">{{0}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('input.input-daily').on('change',function(){
                var data = 'name=' + $(this).attr('name') +
                    '&value='+$(this).val() +
                    '&price=' + $(this).closest('tr').find('input[name=price]').val() +
                    '&date=' + $('input[name=current_date]').val() +
                    "&material_id="+$(this).closest('tr').find('input[name=material_id]').val();
                var $body = $(document.body),
                    params = {
                        type: 'POST',
                        url: 'input-daily/update-daily.js',
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {
                            // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
                        },
                        success: function(cart) {
                            // if ((typeof callback) === 'function') {
                            //     callback(cart);
                            // }
                            // else {
                            //     HaravanAPI.onCartUpdate(cart);
                            // }
                            // $body.trigger('afterUpdateCartNote.ajaxCart', [note, cart]);
                        },
                        error: function(XMLHttpRequest, textStatus) {
                            // $body.trigger('errorUpdateCartNote.ajaxCart', [XMLHttpRequest, textStatus]);
                            // HaravanAPI.onError(XMLHttpRequest, textStatus);
                        },
                        complete: function(jqxhr, text) {
                            // $body.trigger('completeUpdateCartNote.ajaxCart', [this, jqxhr, text]);
                        }
                    };
                jQuery.ajax(params);
            })
        });
    </script>
@endsection

