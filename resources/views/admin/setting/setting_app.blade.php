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
        <form action="{{route('admin.setting.setting_app.update')}}" method="post">
            @csrf
            <div class="card-header">
                <i class="fa fa-edit"></i> Thiết Lặp Thông Tin Chi Nhánh
                <input name="branch_id" type="hidden" value="{{$branchId}}">
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label for="rent_amount">Tiền Thuê Mặt Bằng</label>
                    <input class="form-control double" id="rent_amount" name="rent_amount" value="{{$settingApp->rent_amount}}" type="text" placeholder="Tiền thuê mặt bằng">
                </div>
                <div class="form-group">
                    <label for="percent_shipping">Phần Trăm Phí Vận Chuyển</label>
                    <input class="form-control double" id="percent_shipping" value="{{$settingApp->percent_shipping}}" name="percent_shipping" type="text" placeholder="Phần trăm phí vận chuyển">
                </div>
                <div class="form-group">
                    <label for="percent_shipping">Miếng Gà Chiên Hàng Ngày</label>
                    <input class="form-control double" id="chicken_num" value="{{$settingApp->chicken_num}}" name="chicken_num" type="text" placeholder="Miếng gà chiên hàng ngày">
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i> Lưu Thông Tin</button>
            </div>
        </form>
    </div>
@endsection
