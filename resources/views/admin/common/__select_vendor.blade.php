<select class="form-control" id="vendor" name="{{$selectName}}">
    @foreach($vendors as $vendor)
        <option value="{{$vendor->id}}" @if(isset($defaultValue) && $defaultValue == $vendor->id) selected @endif>
            {{$vendor->vendor_name}}
        </option>
    @endforeach
</select>