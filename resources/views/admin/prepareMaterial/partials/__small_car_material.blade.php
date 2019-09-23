<div class="col-md-12">
    <span class="h3">Số Lượng Nước Xe Nhỏ</span>
</div>
<div class="col-md-12">
    <table class="table table-bordered table-sm table-striped text-center" style="display: table">
        <thead>
            <tr>
                <th>Xe Nhỏ</th>
                <th>Pepsi</th>
                <th>Ca Cao</th>
                <th>Trà Sửa</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($smallCarLocations as $smallCarLocation)
                @if($smallCarLocation->total_qty_product > 0)
                    <tr>
                        <td>{{$smallCarLocation->car_name}}</td>
                        @foreach($smallCarLocation->materials as $material)
                            <td>{{\App\Helpers\AppHelper::formatMoney($material->qty)}}</td>
                        @endforeach
                        <td>{{\App\Helpers\AppHelper::formatMoney($smallCarLocation->total_qty_material)}}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-dark">
                <td>Tổng</td>
                <td class="bg-facebook">{{\App\Helpers\AppHelper::formatMoney($total_qty_pepsi)}}</td>
                <td class="bg-facebook">{{\App\Helpers\AppHelper::formatMoney($total_qty_cocoa)}}</td>
                <td class="bg-facebook">{{\App\Helpers\AppHelper::formatMoney($total_qty_milk_tea)}}</td>
                <td class="bg-facebook">{{\App\Helpers\AppHelper::formatMoney($total_qty_material)}}</td>
            </tr>
        </tfoot>
    </table>
</div>
