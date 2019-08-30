@extends('employee.layouts.master')

@section('head.css')
    <link href="{{asset('/css/admin/plugins/daterangepicker.css')}}" rel="stylesheet">
    <style>
        table.dataTable{
            width: auto;
        }
    </style>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js')}}"></script>
    <script src="{{asset('js/admin/plugins/moment.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/plugins/daterangepicker.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/date-picker.js') }}" type='text/javascript'></script>
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
            <i class="fa fa-edit"></i> Danh Sách Chi Trong Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            @can('payment_bill.view')

            <form method="post" action="@if(isset($paymentBill->id)) {{route('admin.payment_bill.update',['id' => $paymentBill->id]) }} @else {{route('admin.payment_bill.create')}} @endif">
                @csrf
                <input type="hidden" name="branch_id" value="{{$branchId}}">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="bill_date">Ngày Chi</label>
                            <div class="">
                                <input class="form-control date-picker" id="bill_date" type="text" name="bill_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="qty">Số Lượng</label>
                            <input class="form-control text-right input-qty-price double" value="{{$paymentBill->qty}}" id="qty" type="text" name="qty" placeholder="Nhập số lượng" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="price">Đơn Giá</label>
                            <input class="form-control text-right input-qty-price number" value="{{$paymentBill->price}}" id="price" type="text" name="price" required placeholder="Đơn giá" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="amount">Thành Tiền</label>
                            <input class="form-control text-right number" id="amount" value="{{$paymentBill->amount}}" name="amount" type="text" placeholder="Thành tiền" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="name">Người Chi</label>
                            <select class="form-control" id="product_type" name="user_id" required>
                                @foreach($users as $user)
                                    <option class="font-weight-bold" value="{{$user->id}}" @if(isset($paymentBill->user_id) && $paymentBill->user_id == $user->id ) selected @endif>

                                        {{$user->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="note">Lý Do Chi</label>
                            <input class="form-control" id="note" value="{{$paymentBill->note}}" name="note" type="text" placeholder="Lý do chi" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit">Thêm Phiếu Chi</button>
                        </div>
                    </div>
                </div>
            </form>
            @endcan
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th class="text-center date" width="100">Ngày Chi</th>
                    <th class="text-center" width="100">Số Lượng</th>
                    <th class="text-center" width="100">Đơn Giá(đ)</th>
                    <th class="text-center" width="120">Thành Tiền(đ)</th>
                    <th class="text-center" width="300">Lý Do Chi</th>
                    <th class="text-center" width="150">Người Chi</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($paymentBills as $paymentBill)
                        <tr>
                            <td class="text-center">
                                {{\App\Helpers\DateTimeHelper::dateFormat($paymentBill->bill_date,'Y/m/d')}}<br/>
                                <span>{{\App\Helpers\DateTimeHelper::dateToWeek($paymentBill->bill_date)}}</span>
                            </td>
                            <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($paymentBill->qty)}}</td>
                            <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($paymentBill->price)}}</td>
                            <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($paymentBill->amount)}}</td>
                            <td>{{$paymentBill->note}}</td>
                            <td>@if(isset($paymentBill->user)){{$paymentBill->user->name}}@endif</td>
                            <td class="text-center">
                                <a class="btn btn-info" href="{{route('admin.payment_bill.update',['id' => $paymentBill->id])}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-toggle="modal" class="btn btn-danger anchorClick"
                                   data-url="{{route('admin.payment_bill.delete',['id' => $paymentBill->id]) }}"
                                   data-name="{{$paymentBill->note}}" href="#deleteModal">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
