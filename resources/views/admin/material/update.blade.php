@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <strong>Cập Nhật Nguyên Liệu</strong>

            <a class="btn btn-sm btn-secondary pull-right" href="{{route('admin.material')}}" >Quay lại</a>
        </div>
        <form action="{{route('admin.material.update',['id' => $material->id])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="material_name">Tên Nguyên Liệu</label>
                            <input class="form-control" id="material_name" name="material_name" type="text" placeholder="Tên nguyên liệu" value="{{$material->material_name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="material_type_id">Loại Nguyên Liệu</label>
                            <select class="form-control" id="material_type_id" name="material_type_id">
                                @foreach($materialTypes as $materialType)
                                    <option value="{{$materialType->id}}" @if($material->material_type_id == $materialType->id) selected @endif>{{$materialType->material_type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="unit_id">Đơn Vị</label>
                            <select class="form-control" id="unit_id" name="unit_id">
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}" @if($material->unit_id == $unit->id) selected @endif>{{$unit->unit_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Đơn Giá</label>
                            <input class="form-control number text-right" id="price" name="price" type="text" value="{{$material->price}}" placeholder="Đơn giá">
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Nhà Cung Cấp</label>
                            <select class="form-control" id="supplier_id" name="supplier_id">
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}" @if($material->supplier_id == $supplier->id) selected @endif>{{$supplier->supplier_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-4 col-form-label" for="text-input">Hiển Thị</label>
                            <div class="col-md-9 col-8">
                                <label class="switch switch-label switch-outline-primary-alt">
                                    <input class="switch-input" type="checkbox" {{$material->is_check_show_input}} name="is_show_input">
                                    <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-sm btn-primary" type="submit">
                    <i class="fa fa-dot-circle-o"></i> Cặp Nhật Nguyên Liệu</button>
            </div>
        </form>
    </div>
@endsection
