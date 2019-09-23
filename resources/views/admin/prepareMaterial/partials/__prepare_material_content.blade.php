<div class="row">
    <div class="col-md-6">
        <div class="row">
            @include('admin.prepareMaterial.partials.__last_date_prepare_material')
        </div>
        <div class="row">
            @include('admin.prepareMaterial.partials.__small_car_product')
        </div>
        <div class="row">
            @include('admin.prepareMaterial.partials.__small_car_material')
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Số Lượng Đã Đặt
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="display: table">
                    <thead>
                    <tr class="text-center">
                        <th>Nguyên Liệu</th>
                        @foreach($branches as $branch)
                            <th>{{$branch->branch_short_name}}</th>
                        @endforeach
                        <th>Tổng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        @if($product->id < 5)
                            <tr class="text-center">
                                <td>
                                    {{$product->product_name}}
                                </td>
                                @foreach($product->prepare_materials as $prepareMaterial)
                                    <td>
                                        {{\App\Helpers\AppHelper::formatMoney($prepareMaterial->qty_check_out)}}
                                    </td>
                                @endforeach
                                <td class="text-center">{{$product->total_qty_check_out}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <hr/>
            <div class="row pl-2 pb-1">
                <div class="col-md-12">
                    <span class="h3">Số Lượng Xuất Dự Tính</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-responsive-sm table-bordered table-sm">
                        <thead>
                        <tr>
                            @foreach($branches as $branch)
                                <th class="text-center">{{$branch->branch_short_name}}</th>
                            @endforeach
                            <th>Tổng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="bg-secondary theme-color">
                                <td colspan="3">
                                    {{$product->product_name}}
                                </td>
                            </tr>
                            <tr>
                                @foreach($product->prepare_materials as $prepareMaterial)
                                    <td>
                                        <input autocomplete="off" class="form-control double text-right input-prepare-material" name="qty_{{$product->id.'_'.$prepareMaterial->branch_id}}_" value="{{\App\Helpers\AppHelper::formatMoney($prepareMaterial->qty_prepare)}}">
                                        <input type="hidden" name="branch_id" value="{{$prepareMaterial->branch_id}}"/>
                                        <input type="hidden" name="product_id" value="{{$product->id}}"/>
                                    </td>
                                @endforeach
                                <td class="text-center" style="vertical-align: middle">{{$product->total_qty_prepare}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/prepare-material.js')}}"></script>
<script>
    $(document).ready(function(){
        $('input.input-prepare-material').on('change',function(){
            let urlPost = $('input[name=url_post_update]').val();
            PrepareMaterialAPI.updateInputPrepare(this,urlPost);
        });
    });
</script>
