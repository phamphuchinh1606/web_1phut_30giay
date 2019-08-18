@extends('admin.layouts.master')

@section('head.css')
    <link href="{{asset('/css/admin/plugins/daterangepicker.css')}}" rel="stylesheet">
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

@section('body.js')
    <script src="{{asset('js/admin/plugins/moment.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/plugins/daterangepicker.min.js') }}" type='text/javascript'></script>
    <script src="{{asset('js/admin/date-picker.js') }}" type='text/javascript'></script>
@endsection

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Thiết Lặp Thông Tin Ngày Nghĩ
            <input name="branch_id" type="hidden" value="{{$branchId}}">
        </div>
        <div class="card-body">
            <form action="{{route('admin.setting.setting_of_day.save')}}" method="post">
                @csrf
                <input type="hidden" value="1" name="type_day"/>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Ngày làm việc trong tuần</label>
                    <div class="col-md-9 col-form-label">
                        @foreach($weekMap as $key => $week)
                            <?php $selected = false; ?>
                            @foreach($settingWeekOfDays as $settingWeekDay)
                                @if($settingWeekDay->week_no == $key)
                                    <?php $selected = true; ?>
                                @endif
                            @endforeach
                            <div class="form-check form-check-inline mr-1">
                                <input name="check_week[]" class="form-check-input" id="inline-checkbox{{$key}}" @if($selected) checked @endif type="checkbox" value="{{$key}}">
                                <label class="form-check-label" for="inline-checkbox{{$key}}">{{$week}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 text-center">
                        <button class="btn btn-sm btn-primary" type="submit">Lưu Ngày Nghĩ Trong Tuần</button>
                    </div>
                </div>
            </form>

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
                                @foreach($settingOfDays as $key => $settingDay)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$settingDay->date_off}}</td>
                                        <td>{{$settingDay->note}}</td>
                                        <td>
                                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                                               data-url="{{route('admin.setting.setting_of_day.delete',['id' => $settingDay->id]) }}"
                                               data-name="{{$settingDay->date_off}}" href="#deleteModal">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <form action="{{route('admin.setting.setting_of_day.save')}}" method="post">
                                @csrf
                                <input type="hidden" value="2" name="type_day"/>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="controls">
                                            <div class="input-prepend input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> Ngày </span>
                                                </div>
                                                <input class="form-control date-picker" id="date_off" type="text" name="date_off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="controls">
                                            <div class="input-prepend input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> Nội Dung </span>
                                                </div>
                                                <input class="form-control" id="note" name="note" size="10" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <button class="btn btn-primary" type="submit">
                                            Thêm
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection