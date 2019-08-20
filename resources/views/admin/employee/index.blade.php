@extends('admin.layouts.master')

@section('head.css')
    <link href="{{asset('/css/admin/plugins/daterangepicker.css')}}" rel="stylesheet">
    <style>
        /*table.dataTable{*/
        /*    width: auto;*/
        /*}*/
        /*table.dataTable th{*/
        /*    text-align: center;*/
        /*}*/
        /*table.dataTable th, table.dataTable td{*/
        /*    padding: 3px;*/
        /*    vertical-align: middle !important;*/
        /*}*/
    </style>
@endsection

@section('body.js')
    <script src="{{asset('js/admin/plugins/moment.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/plugins/daterangepicker.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/date-picker.js') }}" type='text/javascript'></script>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Danh Sách Nhân Viên
            <input name="branch_id" type="hidden" value="{{$branchId}}">

            <a class="btn btn-sm btn-primary pull-right" href="{{route('admin.employee.create')}}" >Thêm Nhân Viên</a>
        </div>
        <div class="card-body">
            <table class="table dataTable table-responsive-sm table-bordered table-striped table-sm">
                <thead>
                <tr>
                    <th width="50">STT</th>
                    <th width="150">Tên Nhân Viên</th>
                    <th width="120">Số Điện Thoại</th>
                    <th width="150">Email</th>
                    <th width="120">Số CMND</th>
                    <th width="120"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $index => $employee)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->phone}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->identity_card}}</td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{route('admin.employee.update',['id' => $employee->id])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                               data-url="{{route('admin.employee.delete',['id' => $employee->id]) }}"
                               data-name="{{$employee->name}}" href="#deleteModal">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
