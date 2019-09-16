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
                            <table class="table table-responsive-sm table-bordered">
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
                                            <?php $totalQtyIn = 0; ?>
                                            @foreach($material->branches as $branch)
                                                <?php $totalQtyIn+= $branch->qty_in; ?>
                                                <td>
                                                    {{$branch->qty_in}}<br>
                                                    {{$branch->detail_qty_in}}
                                                </td>
                                            @endforeach
                                            <td>{{$totalQtyIn}}</td>
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
                                    @foreach($checkOutMaterials as $checkOutMaterial)
                                        <tr>
                                            <td>{{$checkOutMaterial->material_short_name}}</td>
                                            <?php $totalOutQty = 0; ?>
                                            @foreach($checkOutMaterial->branches as $branch)
                                                <?php $totalOutQty+= $branch->check_out_qty; ?>
                                                <td class="text-center">{{$branch->check_out_qty}}</td>
                                            @endforeach
                                            <td class="text-center">{{$totalOutQty}}</td>
                                        </tr>
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
                                <table class="table table-responsive-sm table-bordered">
                                    <thead>
                                    <tr>
                                        @foreach($branches as $branch)
                                            <th class="text-center">{{$branch->branch_name}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-secondary theme-color">
                                            <td colspan="2">
                                                Pita Gà , Ham Gà
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row text-center">
                                                    <div class="form-group col-6 text-center">
                                                        <label for="ccmonth">Ham</label>
                                                        <input class="form-control number text-right" name="qty_cancel" value="1">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="ccyear">Pita</label>
                                                        <input class="form-control number text-right" name="qty_cancel" value="1">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row text-center">
                                                    <div class="form-group col-6">
                                                        <label for="ccmonth">Ham</label>
                                                        <input class="form-control double text-right" name="qty_cancel" value="1">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="ccyear">Pita</label>
                                                        <input class="form-control double text-right" name="qty_cancel" value="1">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach($checkOutMaterials as $checkOutMaterial)
                                            <tr class="bg-secondary theme-color">
                                                <td colspan="2">
                                                    {{$checkOutMaterial->material_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                @foreach($checkOutMaterial->branches as $branch)
                                                    <td>
                                                        <input class="form-control double text-right" name="qty_cancel" value="{{\App\Helpers\AppHelper::formatMoney($branch->check_out_qty)}}">
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
