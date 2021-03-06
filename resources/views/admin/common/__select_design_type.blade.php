<select class="form-control" id="product_type" name="{{$selectName}}">
    @foreach($designTypes as $productType)
        @if(isset($productType->childs))
            <optgroup label="{{$productType->design_type_name}}" value="{{$productType->id}}">
                @foreach($productType->childs as $productTypeChild)
                    <option value="{{$productTypeChild->id}}" @if(isset($defaultValue) && $defaultValue == $productTypeChild->id) selected @endif>
                        {{$productTypeChild->design_type_name}}
                    </option>
                @endforeach
            </optgroup>
        @else
            <option class="font-weight-bold" value="{{$productType->id}}" @if(isset($defaultValue) && $defaultValue == $productType->id) selected @endif>
                <b >{{$productType->design_type_name}}</b>
            </option>
        @endif
    @endforeach
</select>
