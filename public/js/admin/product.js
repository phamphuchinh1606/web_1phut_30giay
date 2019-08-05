var priceInput = $('input[name=product_price]');
var cosPriceInput = $('input[name=product_cost_price]');
var comparePrice = $('input[name=product_compare_price]');

jQuery(document).ready(function ($) {
    $('input.product-price').on('change',function(){
        var value = priceInput.val();
        var price = value.replace(/[\D\s\._\-]+/g, "");
        price = price ? parseInt( price, 10 ) : 0;
        var costPriceValue = cosPriceInput.val();
        var costPrice = costPriceValue.replace(/[\D\s\._\-]+/g, "");
        if(costPriceValue != '' && value != ''){
            costPrice = costPrice ? parseInt( costPrice, 10 ) : 0;
            var salePrice = costPrice - price;
            comparePrice.val(salePrice.toLocaleString( "en-US" ));
        }else{
            comparePrice.val(0);
        }
    })
});