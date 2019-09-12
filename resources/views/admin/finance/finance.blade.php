@extends('admin.layouts.master')

@section('head.css')
    <link href="{{\App\Helpers\AppHelper::assetPublic('/css/admin/plugins/daterangepicker.css')}}" rel="stylesheet">
    <style>
        table.dataTable{
            width: auto;
        }
    </style>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/moment.min.js') }}" type='text/javascript'></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/daterangepicker.min.js') }}" type='text/javascript'></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/date-picker.js') }}" type='text/javascript'></script>
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
            <i class="fa fa-edit"></i> Tài Chính Trong Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">

            <span class="pull-right">
                <a class="btn btn-sm btn-primary" href="{{route('admin.finance.get_sale_amount')}}">Nhập Tiền Bán</a>
            </span>
        </div>
        <div class="card-body">
            <form method="post" action="@if(isset($finance->id)) {{route('admin.finance.update',['id' => $finance->id]) }} @else {{route('admin.finance.create')}} @endif">
                @csrf
                <input type="hidden" name="branch_id" value="{{$branchId}}">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="date_daily">Ngày</label>
                            <div>
                                <input class="form-control date-picker" autocomplete="off" id="date_daily" type="text" name="date_daily" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="amount_in">Tiền Thu</label>
                            <input class="form-control text-right number" value="{{$finance->amount_in}}" id="amount_in" type="text" name="amount_in" required placeholder="Tiền thu" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="amount_out">Tiền Chi</label>
                            <input class="form-control text-right number" value="{{$finance->amount_out}}" id="amount_out" type="text" name="amount_out" required placeholder="Tiền chi" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="note">Ghi chú</label>
                            <input class="form-control" id="note" value="{{$finance->note}}" name="note" type="text" placeholder="Ghi chú" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit">@if(isset($finance->id)) Cập Nhật Thu Chi @else Thêm Thu Chi @endif </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-bordered datatable dataTable no-footer table-overflow-x" id="DataTables_Table_0"
                           role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                        <thead>
                        <tr role="row">
                            <th class="text-center date" width="80">Ngày</th>
                            <th class="text-center" width="90">Tền Thu</th>
                            <th class="text-center" width="90">Tiền Chi</th>
                            <th class="text-center" width="300">Ghi Chú</th>
                            <th class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($finances as $financeItem)
                            @if($financeItem->amount_in != 0 || $financeItem->amount_out != 0)
                            <tr>
                                <td class="text-center">
                                    {{\App\Helpers\DateTimeHelper::dateFormat($financeItem->date_daily,'Y/m/d')}}<br/>
                                    <span>{{\App\Helpers\DateTimeHelper::dateToWeek($financeItem->date_daily)}}</span>
                                </td>
                                <td class="text-right">@if($financeItem->amount_in != 0) {{\App\Helpers\AppHelper::formatMoney($financeItem->amount_in)}} @endif</td>
                                <td class="text-right">@if($financeItem->amount_out != 0){{\App\Helpers\AppHelper::formatMoney($financeItem->amount_out)}} @endif</td>
                                <td>{{$financeItem->note}}</td>
                                <td class="text-center">
                                    <a class="btn btn-info" href="{{route('admin.finance.update',['id' => $financeItem->id])}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a data-toggle="modal" class="btn btn-danger anchorClick"
                                       data-url="{{route('admin.finance.delete',['id' => $financeItem->id]) }}"
                                       data-name="{{$financeItem->note}}" href="#deleteModal">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                           role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                        <thead>
                        <tr role="row">
                            <th class="text-center date">Tổng Thu</th>
                            <th class="text-center">Tổng Chi</th>
                            <th class="text-center">Còn Lại</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{\App\Helpers\AppHelper::formatMoney($totalAmountIn)}} VNĐ</td>
                                <td>{{\App\Helpers\AppHelper::formatMoney($totalAmountOut)}} VNĐ</td>
                                <td>{{\App\Helpers\AppHelper::formatMoney($totalAmountIn - $totalAmountOut)}} VNĐ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
