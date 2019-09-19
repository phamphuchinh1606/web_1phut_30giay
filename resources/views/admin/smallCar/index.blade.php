@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Danh Sách Xe Nhỏ
            <a class="btn btn-sm btn-primary pull-right" href="{{route('admin.setting.small_car.create')}}" >Thêm Xe Nhỏ</a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered datatable dataTable no-footer" id="DataTables_Table_0"
                   role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                <thead>
                <tr role="row">
                    <th class="text-center" width="50">STT</th>
                    <th class="text-center">Tên Xe Nhỏ</th>
                    <th class="text-center hide-item-sm"">Địa Chỉ</th>
                    <th class="text-center">Hiển Thị</th>
                    <th class="text-center"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($smallCarLocations as $index => $smallCarLocation)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$smallCarLocation->car_name}}</td>
                        <td class="hide-item-sm">{{$smallCarLocation->address}}</td>
                        <td>
                            @if($smallCarLocation->is_show == 1)
                                Hiển thị
                            @else
                                Không hiển thị
                            @endif
                        </td>
                        <td class="text-center">
                            <a class="btn btn-info" href="{{route('admin.setting.small_car.update',['id' => $smallCarLocation->id])}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a data-toggle="modal" class="btn btn-danger anchorClick"
                               data-url="{{route('admin.setting.small_car.delete',['id' => $smallCarLocation->id]) }}"
                               data-name="{{$smallCarLocation->car_name}}" href="#deleteModal">
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
