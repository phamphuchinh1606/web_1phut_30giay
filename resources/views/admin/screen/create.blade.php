@extends('admin.layouts.master')

@section('body.content')
    <div class="card">
        <div class="card-header">
            <i class="fa fa-edit"></i>Tạo Mới Màn Hình
            <a class="btn btn-sm btn-dark pull-right" href="{{route('admin.setting.screen')}}" >Quay Lại</a>
        </div>
        <form action="{{route('admin.setting.screen.create')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="screen_id">Mã Màn Hình</label>
                            <input autocomplete="off" class="form-control" id="screen_id" name="screen_id" type="text" placeholder="Mã màn hình" required>
                        </div>
                        <div class="form-group">
                            <label for="screen_name">Tên Màn Hình</label>
                            <input autocomplete="off" class="form-control" id="screen_name" name="screen_name" type="text" placeholder="Tên màn hình">
                        </div>
                        <div class="form-group">
                            <label for="screen_url">Link Url</label>
                            <input autocomplete="off" class="form-control" id="screen_url" name="screen_url" type="text" placeholder="Link url">
                        </div>
                        <div class="form-group">
                            <label for="screen_name">Loại Màn Hình</label>
                            <div class="col-form-label pl-2">
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="screen_type_1" checked type="radio" value="{{\App\Models\Screen::SCREEN_TYPE_ADMIN}}" name="screen_type">
                                    <label class="form-check-label" for="screen_type_1">Admin</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" id="screen_type_2" type="radio" value="{{\App\Models\Screen::SCREEN_TYPE_EMPLOYEE}}" name="screen_type">
                                    <label class="form-check-label" for="screen_type_2">Employee</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="screen_parent_id">Màn Hình Cha</label>
                            <select class="form-control" id="screen_parent_id" name="screen_parent_id">
                                <option value="">Chọn màn hình cha</option>
                                @foreach($screenMap as $key_screen => $screens)
                                    <optgroup label="{{\App\Common\RoleConstant::screenTypeName($key_screen)}}">
                                        @foreach($screens as $key => $screen)
                                            <option value="{{$screen->screen_id}}">{{$screen->screen_name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-lg btn-primary" type="submit">
                    Tạo Mới
                </button>
            </div>
        </form>
    </div>
@endsection
