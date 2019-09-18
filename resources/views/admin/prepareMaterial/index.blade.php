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
            <input name="last_date" type="hidden" value="{{\App\Helpers\DateTimeHelper::dateFormat($lastDate,'Y-m-d')}}">
            <input name="url_post_update" type="hidden" value="{{route('admin.prepare_material.update')}}">
        </div>
        <div class="card-body prepare-material-content">
            @include('admin.prepareMaterial.partials.__prepare_material_content')
        </div>
    </div>
@endsection
