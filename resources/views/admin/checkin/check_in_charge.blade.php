@extends('admin.layouts.master')

@section('head.css')
    <link href="{{ \App\Helpers\AppHelper::assetPublic('css/admin/plugins/daterangepicker.css')}}" rel="stylesheet">
    <style>
        table.dataTable{
            width: auto;
        }
    </style>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js')}}"></script>
    <script src="{{ \App\Helpers\AppHelper::assetPublic('js/admin/plugins/moment.min.js') }}" type='text/javascript'></script>
    <script src="{{ \App\Helpers\AppHelper::assetPublic('js/admin/plugins/daterangepicker.min.js') }}" type='text/javascript'></script>
    <script src="{{ \App\Helpers\AppHelper::assetPublic('js/admin/date-picker.js') }}" type='text/javascript'></script>
    <script>
        $(document).ready(function(){
            $('.input-qty-price').on('change',function(){
                var qty = InputFortmat.originalDouble($('input[name=qty]').val());
                var price = InputFortmat.originalNumber($('input[name=price]').val());
                $('input[name=amount]').val((qty * price).toLocaleString( "en-US" ));
            });
        });
    </script>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Danh sách đặt hàng thêm trong tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            <form method="post" action="@if(isset($checkIn->id)) {{route('admin.check_in.check_in_charge.update',['id' => $checkIn->id]) }} @else {{route('admin.check_in.check_in_charge.create')}} @endif">
                @csrf
                <input type="hidden" name="branch_id" value="{{$branchId}}">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="check_in_date">Ngày Chi</label>
                            <div class="">
                                <input class="form-control date-picker" autocomplete="off" id="check_in_date" type="text" name="check_in_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="qty">Số Lượng</label>
                            <input class="form-control text-right input-qty-price double" value="{{$checkIn->qty}}" id="qty" type="text" name="qty" placeholder="Nhập số lượng" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="price">Đơn Giá</label>
                            <input class="form-control text-right input-qty-price number" value="{{$checkIn->price}}" id="price" type="text" name="price" required placeholder="Đơn giá" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="amount">Thành Tiền</label>
                            <input class="form-control text-right number" id="amount" value="{{$checkIn->amount}}" name="amount" type="text" placeholder="Thành tiền" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="order_check_in_type">Phí Vận Chuyển</label>
                            <select class="form-control" id="order_check_in_type" name="order_check_in_type" required>
                                <option class="font-weight-bold" value="{{\App\Models\OrderCheckIn::CHECK_IN_TYPE_CHARGE}}" @if(isset($checkIn) && $checkIn->check_in_type == \App\Models\OrderCheckIn::CHECK_IN_TYPE_CHARGE ) selected @endif>
                                    {{\App\Models\OrderCheckIn::CHECK_IN_TYPE_CHARGE_NAME}}
                                </option>
                                <option class="font-weight-bold" value="{{\App\Models\OrderCheckIn::CHECK_INT_TYPE_NOT_CHARGE}}" @if(isset($checkIn) && $checkIn->check_in_type == \App\Models\OrderCheckIn::CHECK_INT_TYPE_NOT_CHARGE ) selected @endif>
                                    {{\App\Models\OrderCheckIn::CHECK_IN_TYPE_NOT_CHARGE_NAME}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="note">Tên mặt hàng</label>
                            <input class="form-control" id="note" value="{{$checkIn->note}}" name="note" type="text" placeholder="Tên mặt hàng" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            @if(isset($checkIn->id))
                                <a class="btn btn-sm btn-danger" href="{{route('admin.check_in.check_in_charge')}}">Hủy</a>
                                <button class="btn btn-sm btn-primary" type="submit">Cập Nhật</button>
                            @else
                                <button class="btn btn-sm btn-primary" type="submit">Thêm</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th class="text-center date">STT</th>
                    <th class="text-center date" width="100">Ngày Mua</th>
                    <th class="text-center" width="100">Số Lượng</th>
                    <th class="text-center" width="100">Đơn Giá(đ)</th>
                    <th class="text-center" width="120">Thành Tiền(đ)</th>
                    <th class="text-center" width="300">Tên Mặt Hàng</th>
                    <td class="text-center" width="120">Phí</td>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($checkIns as $index => $checkInItem)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td class="text-center">
                            {{\App\Helpers\DateTimeHelper::dateFormat($checkInItem->check_in_date,'Y/m/d')}}<br/>
                            <span>{{\App\Helpers\DateTimeHelper::dateToWeek($checkInItem->check_in_date)}}</span>
                        </td>
                        <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($checkInItem->qty)}}</td>
                        <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($checkInItem->price)}}</td>
                        <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($checkInItem->amount)}}</td>
                        <td>{{$checkInItem->note}}</td>
                        <td>{{$checkInItem->check_in_type_name}}</td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{route('admin.check_in.check_in_charge',['id' => $checkInItem->id])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                               data-url="{{route('admin.check_in.check_in_charge.delete',['id' => $checkInItem->id]) }}"
                               data-name="{{$checkInItem->note}}" href="#deleteModal">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr class="text-center font-weight-bold" style="color: red">
                        <td colspan="3">Tổng Tiền</td>
                        <td colspan="5">{{\App\Helpers\AppHelper::formatMoney($totalAmount)}} VNĐ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
