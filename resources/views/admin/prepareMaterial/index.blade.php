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
                            <table class="table table-responsive-sm table-bordered table-sm">
                                <thead>
                                <tr>
                                    @foreach($branches as $branch)
                                        <th>{{$branch->branch_name}}</th>
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
                                                    {{$prepareMaterial->qty_material}}
                                                </td>
                                            @endforeach
                                            <td>{{$material->total_qty_material}}</td>
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
                            <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>Nguyên Liệu</th>
                                    @foreach($branches as $branch)
                                        <th>{{$branch->branch_name}}</th>
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
                                            <th class="text-center">{{$branch->branch_name}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr class="bg-secondary theme-color">
                                                <td colspan="2">
                                                    {{$product->product_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                @foreach($product->prepare_materials as $prepareMaterial)
                                                    <td>
                                                        <input autocomplete="off" class="form-control double text-right" name="qty_cancel" value="{{\App\Helpers\AppHelper::formatMoney($prepareMaterial->qty_prepare)}}">
                                                    </td>
                                                @endforeach
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
