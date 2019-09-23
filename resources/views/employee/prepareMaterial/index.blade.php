@extends('employee.layouts.master')

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
    <script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/plugins/jquery.printPage.js')}}"></script>
    <script>
        $(document).ready(function(){
            let pluginOptions = {
                attr : "url-print",
                message: "Đang tạo tài liệu. Vui lòng chờ đợi."
            };
            $('.btn-print-view').printPage(pluginOptions);
        });
    </script>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Chuẩn Bị Nguyên Liệu Ngày : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'m/Y')}}
            <input name="last_date" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($lastDate,'Y-m-d')}}">
            <input name="url_post_update" type="hidden" value="{{route('prepare_material.update')}}">
        </div>
        <div class="card-body prepare-material-content">
            @include('employee.prepareMaterial.partials.__prepare_material_content')
        </div>
    </div>
@endsection
