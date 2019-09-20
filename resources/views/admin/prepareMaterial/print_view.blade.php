@extends('admin.layouts.master')

@section('body.content')
    <div class="">
        <div class="card-header text-center">
            <h1 class="font-weight-bold">Chuẩn Bị Nguyên Liệu Ngày {{\App\Helpers\DateTimeHelper::dateFormat($currentDate,'d/m/Y')}}</h1>
        </div>
        <div class="card-body mt-2">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        @include('admin.prepareMaterial.partials.__last_date_prepare_material')
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        @include('admin.prepareMaterial.partials.__small_car_location')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
