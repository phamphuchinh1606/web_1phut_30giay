@extends('admin.layouts.master')

@section('head.title','Tạo mới sản phẩm')

@section('head.css')
    <link href="{{asset('css/admin/plugins/quill.snow.css')}}" rel="stylesheet">
    {{--<link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('css/admin/plugins/dropzone.css')}}">
    <link href="{{asset('css/admin/dropzon_custom.css')}}" rel="stylesheet">
@endsection

@section('body.js')
    <script src="{{asset('js/admin/plugins/quill.min.js')}}"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.min.js"></script>--}}
    <script src="{{asset('js/admin/plugins/text-editor.js')}}"></script>
    <script src="{{asset('js/admin/plugins/dropzone.js')}}"></script>
    <script src="{{asset('js/admin/dropzone-config.js')}}"></script>
    <script src="{{asset('js/admin/product.js')}}"></script>
@endsection

@section('body.breadcrumb')
    {{ Breadcrumbs::render('admin.product.create') }}
@endsection

@section('body.content')
    <div class="container-fluid">
        <div id="ui-view">
            <div>
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="post" action="{{route('admin.product.create')}}" enctype="multipart/form-data" id="form">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <i class="icon-note"></i> Tạo Mới Sản Phẩm
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Tên Sản Phẩm</label>
                                            <div class="col-md-10">
                                                <input class="form-control" id="text-input" type="text" name="product_name" placeholder="Tên sản phẩm" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Mã Sản Phẩm</label>
                                            <div class="col-md-10">
                                                <input class="form-control" id="text-input" type="text" name="product_code" placeholder="Mã sản phẩm" required>
                                            </div>
                                        </div>
{{--                                        <div class="form-group row">--}}
{{--                                            <label class="col-md-2 col-form-label" for="text-input">Thương hiệu</label>--}}
{{--                                            <div class="col-md-10">--}}
{{--                                                @include('admin.common.__select_vendor',['selectName' => 'vendor'])--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Loại Sản Phẩm</label>
                                            <div class="col-md-10">
                                                @include('admin.common.__select_product_type',['selectName' => 'product_type'])
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Giá sản phẩm</label>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Giá Bán</span>
                                                            </div>
                                                            <input class="form-control product-price text-right number" id="product_price" type="text" name="product_price">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">VNĐ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Giá Gốc</span>
                                                            </div>
                                                            <input class="form-control product-price text-right number" id="product_cost_price" type="text" name="product_cost_price">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">VNĐ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Tiền Giảm</span>
                                                            </div>
                                                            <input class="form-control text-right number" id="product_compare_price" type="text" name="product_compare_price" disabled>
                                                            <input name="product_compare_price" class="number" type="hidden" value="" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">VNĐ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pt-3">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">Phần Trăm</span>
                                                            </div>
                                                            @include('admin.product.__select_sale_percent',['selectName' => 'product_sale_percent'])
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Công khai sản phẩm</label>
                                            <div class="col-md-10">
                                                <label class="switch switch-label switch-outline-primary-alt">
                                                    <input class="switch-input" type="checkbox" checked="" name="is_public">
                                                    <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Mô tả ngắn sản phẩm</label>
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="product_description" rows="9" placeholder="Nhập mô tả ngắn thông tin sản phẩm"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="text-input">Nội dung sản phẩm</label>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" id="summary-ckeditor" name="product_content" style="height: 400px"></textarea>
                                                        <script src="{{ \App\Common\AppCommon::assetPublic('ckeditor/ckeditor.js') }}"></script>
                                                        <script>
                                                            CKEDITOR.replace( 'summary-ckeditor', {
                                                                filebrowserBrowseUrl: '{{ asset('ckfinder/ckfinder.html') }}',
                                                                filebrowserImageBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Images') }}',
                                                                filebrowserFlashBrowseUrl: '{{ asset('ckfinder/ckfinder.html?type=Flash') }}',
                                                                {{--filebrowserUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',--}}
                                                                        {{--filebrowserImageUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',--}}
                                                                filebrowserFlashUploadUrl: '{{ asset('ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
                                                            } );
                                                            CKEDITOR.on('instanceLoaded', function(e) {e.editor.resize('100%', 700)} );
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none">
                                            <input type="file" class="'form-control" id="product_main_image" name="product_main_image"/>
                                            <div class="root_product_images">
                                                <input type="hidden" class="'form-control product_images" name="product_images[]" value=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-sm btn-primary" type="submit">
                                            <i class="fa fa-dot-circle-o"></i> Tạo mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Hình Ảnh Chính
                                    <small>slides only</small>
                                </div>
                                <div class="card-body">
                                    <div class="box box-warning">
                                        <div class="box-body">
                                            <div class="upload__area-image">
                                                <span>
                                                    <img id="imgHandle" src="http://beats-city.amagumolabs.io/images/upload/no_image_available.jpg">
                                                    <label for="imgAnchorInput">Upload image</label>
                                                </span>
                                                <p><small>(Please upload a file of type: jpeg, png, jpg, gif, svg.)</small></p>
                                            </div>
                                            <div class="form__upload">

                                                <div class="form-inline-simple">
                                                    <input type="file" class="'form-control" id="imgAnchorInput" onchange="loadFile(event)">
                                                </div>
                                                <script>
                                                    var loadFile = function(event) {
                                                        var output = document.getElementById('imgHandle');
                                                        output.src = URL.createObjectURL(event.target.files[0]);
                                                        document.getElementById('product_main_image').files = event.target.files;
                                                    };
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-align-justify"></i> Danh sách hình ảnh phụ
                                    <small>slides only</small>
                                </div>
                                <div class="card-body">
                                    <div class="carousel slide" id="carouselExampleSlidesOnly" data-ride="carousel">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form method="post" action="{{route('admin.common.upload_image')}}"
                                                      enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                                                    {{ csrf_field() }}
                                                    <div class="dz-message">
                                                        <div class="col-xs-8">
                                                            <div class="message">
                                                                <p>Kéo thả file image hoặc click để upload</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="fallback">
                                                        <input type="file" name="file">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{--Dropzone Preview Template--}}
                                        <div id="preview" style="display: none;">

                                            <div class="dz-preview dz-file-preview">
                                                <div class="dz-image"><img data-dz-thumbnail /></div>

                                                <div class="dz-details">
                                                    <div class="dz-size"><span data-dz-size></span></div>
                                                    <div class="dz-filename"><span data-dz-name></span></div>
                                                </div>
                                                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                <div class="dz-success-mark">

                                                    {{--<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">--}}
                                                        {{--<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->--}}
                                                        {{--<title>Check</title>--}}
                                                        {{--<desc>Created with Sketch.</desc>--}}
                                                        {{--<defs></defs>--}}
                                                        {{--<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">--}}
                                                            {{--<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>--}}
                                                        {{--</g>--}}
                                                    {{--</svg>--}}

                                                </div>
                                                <div class="dz-error-mark">

                                                    {{--<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">--}}
                                                        {{--<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->--}}
                                                        {{--<title>error</title>--}}
                                                        {{--<desc>Created with Sketch.</desc>--}}
                                                        {{--<defs></defs>--}}
                                                        {{--<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">--}}
                                                            {{--<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">--}}
                                                                {{--<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>--}}
                                                            {{--</g>--}}
                                                        {{--</g>--}}
                                                    {{--</svg>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
