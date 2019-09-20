<div class="col-md-12">
    <span class="h3">Số Lượng Bánh Xe Nhỏ</span>
</div>
<div class="col-md-12">
    @foreach($smallCarLocations as $smallCarLocation)
        <?php $totalQty = 0;?>
        <table class="table table-bordered table-sm table-striped text-center" style="display: table">
            <thead>
                <tr class="bg-secondary theme-color">
                    <th colspan="4">{{$smallCarLocation->car_name}}</th>
                </tr>
                <tr>
                    <th rowspan="2" style="vertical-align: middle">Tên Bánh</th>
                    <th colspan="2">Rau</th>
                    <th rowspan="2" style="vertical-align: middle">Tổng</th>
                </tr>
                <tr>
                    <th width="100">Có</th>
                    <th width="100">Không</th>
                </tr>
            </thead>
            <tbody>
                @foreach($smallCarLocation->products as $product)
                    <?php $totalQty+= $product->total_qty;?>
                    @if($product->total_qty > 0)
                        <tr>
                            <td>{{$product->product_short_name}}</td>
                            <td>@if($product->qty_have_vegetables != 0){{\App\Helpers\AppHelper::formatMoney($product->qty_have_vegetables)}}@endif</td>
                            <td>@if($product->qty_no_vegetables != 0){{\App\Helpers\AppHelper::formatMoney($product->qty_no_vegetables)}}@endif</td>
                            <td>{{\App\Helpers\AppHelper::formatMoney($product->total_qty)}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-dark">
                    <td colspan="3">Tổng</td>
                    <td class="bg-facebook">{{\App\Helpers\AppHelper::formatMoney($totalQty)}}</td>
                </tr>
            </tfoot>
        </table>
    @endforeach
</div>
