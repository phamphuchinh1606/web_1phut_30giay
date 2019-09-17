@extends('admin.layouts.master')

@section('head.css')
    <style>
        /*table.table input{*/
        /*    width: 80px;*/
        /*    text-align: right;*/
        /*    font-size: medium;*/
        /*}*/
    </style>
@endsection

@section('body.js')
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Chuẩn Bị Nguyên Liệu Ngày : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="current_month" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y-m')}}">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive-sm table-bordered table-sm" style="display: table">
                                <thead>
                                <tr class="text-center">
                                    @foreach($branches as $branch)
                                        <th>{{$branch->branch_short_name}}</th>
                                    @endforeach
                                    <th>Tổng</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr class="bg-secondary theme-color">
                                            <td colspan="3">
                                                {{$material->material_name}}
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            @foreach($material->prepare_materials as $prepareMaterial)
                                                <td>
                                                    @if($material->id == \App\Models\Material::MATERIAL_EGG_ID)
                                                        <span class="color-red">{{$prepareMaterial->prepare_qty_total}}</span> Miếng
                                                        <br>
                                                        Ham : {{$prepareMaterial->prepare_qty_ham}} m<br>
                                                        Pita : {{$prepareMaterial->prepare_qty_pita}} m<br>
                                                        Sandwich : {{$prepareMaterial->prepare_qty_sandwich}} m<br>
                                                    @else
                                                        <span class="color-red">{{$prepareMaterial->qty_material}}</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>
                                                @if($material->id == \App\Models\Material::MATERIAL_EGG_ID)
                                                    <span class="color-red">{{$material->prepare_qty_total}}</span> Miếng
                                                    <br>
                                                    Ham : {{$material->prepare_qty_ham}} m<br>
                                                    Pita : {{$material->prepare_qty_pita}} m<br>
                                                    Sandwich : {{$material->prepare_qty_sandwich}} m<br>
                                                @else
                                                    <span class="color-red">{{$material->total_qty_material}}</span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                                                        <input autocomplete="off" class="form-control double text-right" name="qty_cancel" value="{{\App\Helpers\AppHelper::formatMoney($prepareMaterial->qty_prepare)}}">
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

        </div>
    </div>
@endsection
