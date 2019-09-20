@extends('admin.layouts.master')

@section('body.js')
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/small-car.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('input.product_input_qty').on('change',function(){
                SmallCarAPI.calculatorProductQty(this);
            });
            $('input.material_input_qty').on('change',function(){
                SmallCarAPI.calculatorMaterialQty(this);
            });
        });
    </script>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Cập Nhật Xe Nhỏ
            <a class="btn btn-sm btn-dark pull-right" href="{{route('admin.setting.small_car')}}" >Quay Lại</a>
        </div>
        <form action="{{route('admin.setting.small_car.update',['id' => $smallCarLocation->id])}}" method="post">
            @csrf
            <input type="hidden" value="{{$branchId}}" name="branch_id"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="car_name">Tên Xe Nhỏ</label>
                            <input autocomplete="off" class="form-control" id="car_name" name="car_name" type="text" value="{{$smallCarLocation->car_name}}" placeholder="Tên xe nhỏ" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa Chỉ</label>
                            <input autocomplete="off" class="form-control" id="address" name="address" type="address" value="{{$smallCarLocation->address}}" placeholder="Địa chỉ">
                        </div>
                        <div class="form-group">
                            <label for="is_show">Hiển Thị</label>
                            <div class="col-md-9 col-8">
                                <label class="switch switch-label switch-outline-primary-alt">
                                    <input class="switch-input" id="is_show" {{$smallCarLocation->is_show_check}} type="checkbox" name="is_show">
                                    <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Ngày Không Bán Trong Tuần</label>
                            <div class="col-md-9 col-form-label">
                                @foreach($weekMap as $key => $week)
                                    <?php $selected = false; ?>
                                    @foreach($smallCarLocationOfDays as $smallCarLocationOfDay)
                                        @if($smallCarLocationOfDay->week_no == $key)
                                            <?php $selected = true; ?>
                                        @endif
                                    @endforeach
                                    <div class="form-check form-check-inline mr-1">
                                        <input name="check_week[]" class="form-check-input" @if($selected) checked @endif id="inline-checkbox{{$key}}" type="checkbox" value="{{$key}}">
                                        <label class="form-check-label" for="inline-checkbox{{$key}}">{{$week}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                Thiết Lặp Số Lượng Sản Phẩm
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-sm">
                                    <thead>
                                    <tr class="text-center">
                                        <th rowspan="2">Tên Sản Phẩm</th>
                                        <th colspan="2">Rau</th>
                                        <th rowspan="2">Tổng</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Có</th>
                                        <th>Không</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalQty = 0; $totalQtyHaveVegetables = 0; $totalQtyNoVegetables = 0;?>
                                    @foreach($products as $product)
                                        <?php
                                            $totalQtyHaveVegetables+= $product->qty_have_vegetables;
                                            $totalQtyNoVegetables+= $product->qty_no_vegetables;
                                            $totalQty+= $product->total_qty;
                                        ?>
                                        <tr>
                                            <td>{{$product->product_short_name}}</td>
                                            <td>
                                                <input autocomplete="off" class="product_input_qty qty_have_vegetables form-control number text-right" name="qty_have_vegetables_{{$product->id}}" value="{{\App\Helpers\AppHelper::formatMoney($product->qty_have_vegetables)}}"/>
                                            </td>
                                            <td>
                                                <input autocomplete="off" class="product_input_qty qty_no_vegetables form-control number text-right" name="qty_no_vegetables_{{$product->id}}" value="{{\App\Helpers\AppHelper::formatMoney($product->qty_no_vegetables)}}"/>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle">
                                                <span class="product_total_qty">{{\App\Helpers\AppHelper::formatMoney($product->total_qty)}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="bg-gray text-right">
                                        <td class="text-center">Tổng</td>
                                        <td class="pr-3 total_qty_have_vegetables">{{\App\Helpers\AppHelper::formatMoney($totalQtyHaveVegetables)}}</td>
                                        <td class="pr-3 total_qty_no_vegetables">{{\App\Helpers\AppHelper::formatMoney($totalQtyNoVegetables)}}</td>
                                        <td class="pr-3 total_qty_vegetables">{{\App\Helpers\AppHelper::formatMoney($totalQty)}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Thiết Lặp Số Lượng Nước
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                    <tr class="text-center">
                                        <th>Loại Nước</th>
                                        <th>Số Lượng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $totalQty = 0;?>
                                    @foreach($materials as $material)
                                        <?php $totalQty+= $material->qty; ?>
                                        <tr>
                                            <td>{{$material->material_short_name}}</td>
                                            <td>
                                                <input autocomplete="off" class="material_input_qty form-control text-right" name="qty_{{$material->id}}" value="{{\App\Helpers\AppHelper::formatMoney($material->qty)}}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="bg-gray text-center">
                                        <td>Tổng</td>
                                        <td class="text-right pr-3 material_input_qty_total">{{\App\Helpers\AppHelper::formatMoney($totalQty)}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-lg btn-primary" type="submit">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>
@endsection
