@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i> Tổng Hợp Tháng : {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'Y/m')}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 col-6">
                    <div class="callout callout-info">
                        <small class="text-muted">Tổng Doanh Thu</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_real_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-1" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-6">
                    <div class="callout callout-danger">
                        <small class="text-muted">Tiền Mặt Bằng</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_cash_hourse_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-6">
                    <div class="callout callout-success">
                        <small class="text-muted">Tiền Mua Hàng 1p30s</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_check_in_1p30s_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-6">
                    <div class="callout callout-success">
                        <small class="text-muted">Tiền Vận Chuyển</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_shipping_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-6">
                    <div class="callout callout-dark">
                        <small class="text-muted">Tiền Mua Đá</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_check_in_rock_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-6">
                    <div class="callout callout-light">
                        <small class="text-muted">Tiền Công</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_time_kipping_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-6">
                    <div class="callout callout-secondary">
                        <small class="text-muted">Tiền Chi</small>
                        <br>
                        <strong class="h4">{{\App\Helpers\AppHelper::formatMoney($dashboard->sum_payment_bill_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="callout callout-warning">
                        <small class="text-muted font-weight-bold">Lợi Nhuận Thực</small>
                        <br>
                        <strong class="h4 {{$dashboard->real_profit_amount_badge}}">{{\App\Helpers\AppHelper::formatMoney($dashboard->real_profit_amount)}}</strong>
                        <div class="chart-wrapper">
                            <canvas id="sparkline-chart-2" width="100" height="30"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
