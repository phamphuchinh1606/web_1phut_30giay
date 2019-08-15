@extends('admin.layouts.master')

@section('head.css')
    <style>
        table.dataTable{
            width: auto;
        }
        table.dataTable th, table.dataTable td{
            padding: 3px;
            vertical-align: middle !important;
        }
    </style>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Thiết Lặp Thông Tin Ngày Nghĩ
            <input name="branch_id" type="hidden" value="{{$branchId}}">
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Ngày làm việc trong tuần</label>
                <div class="col-md-9 col-form-label">
                    @foreach($weekMap as $key => $week)
                        <div class="form-check form-check-inline mr-1">
                            <input name="check_week" class="form-check-input" id="inline-checkbox{{$key}}" type="checkbox" value="{{$key}}">
                            <label class="form-check-label" for="inline-checkbox{{$key}}">{{$week}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Danh Sách Ngày Nghĩ Trong Năm</div>
                        <div class="card-body">
                            <table class="table table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày</th>
                                    <th>Nội dung</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Samppa Nori</td>
                                    <td>2012/01/01</td>
                                    <td>Member</td>
                                    <td>
                                        <span class="badge badge-success">Active</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection