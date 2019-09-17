@extends('admin.layouts.master')

<style>
    table.dataTable{
        width: auto;
    }
    table.dataTable input{
        width: 80px;
        text-align: right;
        font-size: medium;
    }
    table.dataTable th{
        background-color: #4aa0e6;
    }
    table.dataTable th, table.dataTable td{
        padding: 2px;
        vertical-align: middle !important;
    }
    table.dataTable th.no{
        width: 20px;
    }
    table.dataTable th.name{
        width: 120px;
    }
    table.dataTable th.unit{
        width: 60px;
    }
    table.dataTable th.price{
        width: 80px;
    }
    table.dataTable th.first-qty{
        width: 80px;
    }
    table.dataTable th.check-in{
        width: 80px;
    }
    table.dataTable th.amount-in{
        width: 100px;
    }
    table.dataTable th.move-in{
        width: 80px;
    }
    table.dataTable th.move-out{
        width: 80px;
    }
    table.dataTable th.last-qty{
        width: 80px;
    }
    table.dataTable th.check-out{
        width: 80px;
    }
    table.dataTable th.cancel{
        width: 80px;
    }
    @media (max-width: 575.98px){
        table.dataTable .name{
            width: 80px;
        }
    }
</style>

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Số Lượng Bán Ngày : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y/m/d')}}
            <span class="pull-right">
                <a data-toggle="collapse" href="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <i class="fa icon-arrow-down-circle"></i>
                </a>
            </span>
            @can('input_daily.canOfDay')
                <span class="pull-right pr-3">
                    @if($isOfDay)
                        <span class="badge badge-danger">Không bán</span>
                    @elseif(\App\Helpers\DateTimeHelper::truncateTime($currentDate) >= \App\Helpers\DateTimeHelper::now(true))
                        <label class="switch switch-label switch-outline-danger-alt">
                        <input class="switch-input is-off-day" type="checkbox" @if(!$isOfDay) checked="checked" @endif>
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                    @endif
                </span>
            @endcan
            <input name="current_date" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m-d')}}">
            <hr class="multi-collapse collapse" id="multiCollapseExample1">
            <nav class="nav nav-pills flex-column flex-sm-row multi-collapse collapse" id="multiCollapseExample1">
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

            <table class="table table-striped table-bordered datatable dataTable no-footer table-input-sm table-overflow-x" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                <tr role="row">
                    <th rowspan="2" class="text-center hide-item-sm no">MSP</th>
                    <th rowspan="2" class="text-center name">
                        Tên Sản Phẩm
                    </th>
                    <th rowspan="2" class="text-center hide-item-sm unit">Đơn Vị</th>
                    <th rowspan="2" class="text-center hide-item-sm price">Đơn Giá</th>
                    <th rowspan="2" class="text-center first-qty">
                        Tồn Đầu
                        @if($agent->isMobile())
                            <i class="fa fa-chevron-circle-left fa-lg show-price-in"></i>
                        @endif
                    </th>
                    <th rowspan="2" class="text-center check-in">
                        Nhập
                        @if($agent->isMobile())
                            <i class="fa fa-chevron-circle-right fa-lg show-amount-in"></i>
                        @endif
                    </th>
                    <th rowspan="2" class="text-center amount-in hide-item-sm">Thành Tiền</th>
                    <th colspan="2" class="text-center">Xuất</th>
                    <th rowspan="2" class="text-center last-qty">
                        <span>Tồn Cuối</span>
                        @if($agent->isMobile())
                            <i class="fa fa-chevron-circle-right fa-lg show-move-in-out"></i>
                        @endif
                    </th>
                    <th rowspan="2" class="text-center hide-item-sm move-in">Nhập Chuyển</th>
                    <th rowspan="2" class="text-center hide-item-sm move-out">Xuất Chuyển</th>
                </tr>
                <tr>
                    <th class="text-center check-out">Xuất</th>
                    <th class="text-center cancel">Hủy</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materialTypes as $materialType)
                    <tr role="row" style="background-color: yellowgreen">
                        <td colspan="12" class="font-weight-bold calculator-colspan">{{$materialType->material_type_name}}</td>
                    </tr>
                    @if(isset($materials))
                        @foreach($materials as $material)
                            @if($material->material_type_id == $materialType->id)
                                <tr role="row" id="{{$material->id}}">
                                    <td class="hide">
                                        <input type="hidden" value="{{$material->id}}" name="material_id">
                                        <input type="hidden" value="{{$material->price}}" name="price">
                                    </td>
                                    <td class="text-center hide-item-sm">{{$material->id}}</td>
                                    <td>
                                        @if($agent->isMobile())
                                            {{$material->material_short_name}}
                                        @else
                                            {{$material->material_name}}
                                        @endif
                                    </td>
                                    <td class="hide-item-sm">{{$material->unit->unit_name}}</td>
                                    <td class="text-right hide-item-sm price">
                                        @can('input_daily.update', $currentDate)
                                            <a data-toggle="modal" class="changePricePopupClick"
                                               data-url="{{route('input_daily.update_daily')}}"
                                               price-current="{{\App\Helpers\AppHelper::formatMoney($material->price)}}"
                                               price="{{$material->price}}"
                                               material-name="{{$material->material_name}}"
                                               material-id="{{$material->id}}"
                                               qty-in="{{$material->qty_in}}"
                                               href="#changePriceModal">
                                                {{\App\Helpers\AppHelper::formatMoney($material->price)}}
                                            </a>
                                        @else
                                            <span>{{\App\Helpers\AppHelper::formatMoney($material->price)}}</span>
                                        @endcan
                                    </td>
                                    <td class="text-right">{{\App\Helpers\AppHelper::formatMoney($material->qty_first)}}</td>
                                    <td>
                                        <input style="background-color: #B9D3EE;font-weight: bold" autocomplete="off" class="input-daily form-control double" name="qty_in" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_in)}}">
                                    </td>
                                    <td class="text-right hide-item-sm amount-in"><span class="amount_in">{{\App\Helpers\AppHelper::formatMoney($material->amount_in)}}</span></td>
                                    <td class="text-right"><span class="qty_out">{{\App\Helpers\AppHelper::formatMoney($material->qty_out)}}</span></td>
                                    <td>
                                        <input autocomplete="off" class="input-daily form-control double" name="qty_cancel" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_cancel)}}">
                                    </td>
                                    <td class="text-right">
                                        <input autocomplete="off" style="background-color: #66CC66;font-weight: bold" class="input-daily form-control double" name="qty_last" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_last)}}">
                                    </td>
                                    <td class="hide-item-sm move-in">
                                        <input autocomplete="off" class="input-daily form-control double" name="qty_in_move" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_in_move)}}">
                                    </td>
                                    <td class="hide-item-sm move-out">
                                        <input autocomplete="off" class="input-daily form-control double" name="qty_out_move" value="{{\App\Helpers\AppHelper::formatMoney($material->qty_out_move)}}">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="12" class="text-center calculator-colspan" style="background-color: #5cd08d">
                            Tổng Tiền Nhập : <span class="total-amount-check-in" style="color: red">{{\App\Helpers\AppHelper::formatMoney($totalAmountCheckIn)}}</span>
                            <span class="total-amount-check-out hide">{{\App\Helpers\AppHelper::formatMoney($totalAmountCheckOut)}}</span>
                        </td>
{{--                        <td class="text-right" style="color: red"><span class="total-amount-check-in">{{\App\Helpers\AppHelper::formatMoney($totalAmountCheckIn)}}</span></td>--}}
{{--                        <td colspan="2" class="text-center hide-item-sm" style="background-color: #5cd08d">Tổng Tiền Xuất</td>--}}
{{--                        <td class="text-right hide-item-sm" colspan="3" style="color: red"><span class="total-amount-check-out">{{\App\Helpers\AppHelper::formatMoney($totalAmountCheckOut)}}</span></td>--}}
                    </tr>
                </tfoot>
            </table>

            <div>
                <h2>Bản Chấm Công</h2>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <table class="table table-striped table-bordered datatable dataTable no-footer" style="float:left">
                            <thead>
                            <tr role="row">
                                <th rowspan="2" class="text-center hide-item-sm" width="70px">Mã NV</th>
                                <th rowspan="2" class="text-center" width="150px">Tên Nhân Viên</th>
                                <th rowspan="2" class="text-center" width="80">3 Giờ Đầu</th>
                                <th rowspan="2" class="text-center" width="80">2 Giờ Sau</th>
                                <th rowspan="2" class="text-center name">Tổng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td class="hide">
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                    </td>
                                    <td class="text-center hide-item-sm">{{$employee->id}}</td>
                                    <td>{{$employee->name}}</td>
                                    <td>
                                        <input autocomplete="off" class="input-employee form-control double" name="first_hours" value="{{$employee->first_hours}}">
                                    </td>
                                    <td>
                                        <input autocomplete="off" class="input-employee form-control double" name="last_hours" value="{{$employee->last_hours}}">
                                    </td>
                                    <td class="text-right">
                                        <span class="total-amount-employee">
                                            {{\App\Helpers\AppHelper::formatMoney($employee->total_amount_employee)}}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="@if($agent->isMobile()) 1 @else 2 @endif" class="text-center">Tổng Giờ Công</td>
                                <td class="text-right"><span class="total-first-hour">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->first_hours_total)}}</span></td>
                                <td class="text-right"><span class="total-last-hour">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->last_hours_total)}}</span></td>
                                <td class="text-right"><span class="total-hour">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->first_hours_total + $sumEmployeeTotal->last_hours_total)}}</span></td>
                            </tr>
                            <tr>
                                <td colspan="@if($agent->isMobile()) 1 @else 2 @endif" class="text-center">Thành Tiền</td>
                                <td class="text-right"><span class="total-first-amount">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->amount_first_total)}}</span></td>
                                <td class="text-right"><span class="total-last-amount">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->amount_last_total)}}</span></td>
                                <td class="text-right"><span class="total-amount">{{\App\Helpers\AppHelper::formatMoney($sumEmployeeTotal->amount_first_total + $sumEmployeeTotal->amount_last_total)}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <table class="table table-striped table-bordered datatable dataTable no-footer" id="table-bill">
                            <thead>
                            <tr role="row">
                                <th rowspan="2" class="text-center" width="150px">Sản Phẩm</th>
                                <th rowspan="2" class="text-center" width="100px">Đơn Giá</th>
                                <th rowspan="2" class="text-center" width="80">Số Lượng</th>
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
                                            <input autocomplete="off" class="input-sale form-control double" name="product_{{$product->id}}" value="{{\App\Helpers\AppHelper::formatMoney($product->qty)}}">
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
                                <td colspan="2" class="text-center">Doanh Thu</td>
                                <td class="text-right"><span class="total-qty">{{\App\Helpers\AppHelper::formatMoney($totalQty)}}</span></td>
                                <td class="text-right"><span class="total-amount">{{\App\Helpers\AppHelper::formatMoney($orderBill->total_amount)}}</span></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-center">Tiền Thực Thu</td>
                                <td class="text-right">
                                    <input autocomplete="off" class="input-bill form-control double" style="width: 100px;padding: 2px 2px;" value="{{\App\Helpers\AppHelper::formatMoney($orderBill->real_amount)}}">
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
        </div>
    </div>
@endsection

@section('body.modal')
    <div class="modal fade show" id="changePriceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog modal-success" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thay Đổi Đơn Giá</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <span id="confirm-content" class="font-weight-bold"></span></p>
                    <div class="form-group">
                        <label class="form-col-form-label" for="inputSuccess1">Giá hiện tại : <span class="current-price"></span></label>
                    </div>
                    <div class="form-group">
                        <label class="form-col-form-label" for="inputSuccess1">Nhập giá thay đổi</label>
                        <input class="form-control is-valid number text-right" name="price" required id="inputSuccess1" value="" type="text">
                        <input name="material_id" value="" type="hidden">
                        <input name="qty_in" value="" type="hidden">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-cancel" type="button" data-dismiss="modal">Đóng</button>
                    <button class="btn btn-success btn-change-price" type="button">Thay Đổi</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/form.input.number.js')}}"></script>
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/input-daily.js')}}"></script>
    <script>
        function closeModalChangePrice() {
            $('#changePriceModal').find('.btn-cancel').click();
        }

        function changePricePopup() {
            $('.changePricePopupClick').each(function () {
                $(this).on('click', function () {
                    let modal = $('#changePriceModal');
                    modal.find('.current-price').html($(this).attr('price-current'));
                    modal.find('#confirm-content').html($(this).attr('material-name'));
                    modal.find('input[name=material_id]').val($(this).attr('material-id'));
                    modal.find('input[name=qty_in]').val($(this).attr('qty-in'));
                    modal.find('input[name=price]').val('');
                    // modal.find('input[name=price]').val($(this).attr('price-current'));
                });
            });
            $('#changePriceModal').find('.btn-change-price').on('click',function () {
                let modal = $('#changePriceModal');
                let price = modal.find('input[name=price]');
                let priceValue = price.val();
                if(priceValue != '' && priceValue != 0){
                    InputDailyAPI.updateInputPriceDaily(price,closeModalChangePrice);
                }
            });

        }

        function cancelOfDay(){

        }

        function calculatorColspan(){
            $('td.calculator-colspan').each(function(){
                let tableTr = $(this).closest('table').find('tbody tr').eq(1);
                let countShow = tableTr.find('td:visible').length;
                $(this).attr('colspan',countShow);
            });
        }

        let classHideSm = 'hide-item-sm';
        $(document).ready(function(){
            let editForm = @can('input_daily.update', $currentDate) 1; @else 0; @endcan
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
            $('.is-off-day').on('change',function(){
                ModalConfirm.showConfirm(
                    'Xác Nhận',
                    'Bạn Có Thật Sự Muốn Nghĩ Bán Ngày' + '{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y/m/d')}}',
                    '{{route('admin.input_daily.update_of_day',['date' => \App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m-d')])}}',
                    cancelOfDay
                );
            });
            if(editForm == 0){
                $('table.dataTable input:visible').each(function(){
                    let parent = $(this).parent();
                    let index = $(this).index();
                    let spanTag = document.createElement('span');
                    $(spanTag).html($(this).val());
                    $(spanTag).insertAfter($(this));
                    $(this).remove();
                });
            }
            $('.show-price-in').on('click',function(){
                $(this).closest('table').find('th.price').removeClass(classHideSm);
                $(this).closest('table').find('td.price').removeClass(classHideSm);
                $(this).hide();
                calculatorColspan();
            });

            $('.show-amount-in').on('click',function(){
                $(this).closest('table').find('th.amount-in').removeClass(classHideSm);
                $(this).closest('table').find('td.amount-in').removeClass(classHideSm);
                $(this).hide();
                calculatorColspan();
            });

            $('.show-move-in-out').on('click',function(){
                $(this).closest('table').find('th.move-in').removeClass(classHideSm);
                $(this).closest('table').find('td.move-in').removeClass(classHideSm);
                $(this).closest('table').find('th.move-out').removeClass(classHideSm);
                $(this).closest('table').find('td.move-out').removeClass(classHideSm);
                $(this).hide();
                calculatorColspan();
            });
            calculatorColspan();
            changePricePopup();
        });
    </script>
@endsection

