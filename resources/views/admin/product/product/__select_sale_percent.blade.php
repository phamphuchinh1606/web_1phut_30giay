<select class="form-control" id="product_sale_percent" name="{{$selectName}}">
    <option value="0" class="text-right">Chọn phần trăm</option>
    <?php $arrayPercent = [5,10,15,20,25,30,35,40,45,50,55,60]; ?>
    @foreach($arrayPercent as $percent)
        <option value="{{$percent}}" class="text-right" @if(isset($defaultValue) && $defaultValue == $percent) selected @endif>{{$percent}}%</option>
    @endforeach
</select>