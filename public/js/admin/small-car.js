/*==============================================================================*/
if ((typeof SmallCarAPI) === 'undefined') { SmallCarAPI = {}; }

SmallCarAPI.calculatorProductQty = function(note) {
    let productTotalQty = 0;
    $(note).closest('tr').find('input.product_input_qty').each(function(){
        let value = $(this).val();
        if(value != undefined && value != '' ){
            productTotalQty+= Number(value);
        }
    });
    $(note).closest('tr').find('span.product_total_qty').html(productTotalQty);

    let totalQtyHaveVegetables = 0;
    $(note).closest('table').find('input.qty_have_vegetables').each(function(){
        let value = $(this).val();
        if(value != undefined && value != '' ){
            totalQtyHaveVegetables+= Number(value);
        }
    });
    $(note).closest('table').find('td.total_qty_have_vegetables').html(totalQtyHaveVegetables);

    let totalQtyNoVegetables = 0;
    $(note).closest('table').find('input.qty_no_vegetables').each(function(){
        let value = $(this).val();
        if(value != undefined && value != '' ){
            totalQtyNoVegetables+= Number(value);
        }
    });
    $(note).closest('table').find('td.total_qty_no_vegetables').html(totalQtyNoVegetables);
    $(note).closest('table').find('td.total_qty_vegetables').html(totalQtyHaveVegetables + totalQtyNoVegetables);
};

SmallCarAPI.calculatorMaterialQty = function (note){
    let totalQtyMaterial = 0;
    $(note).closest('table').find('input.material_input_qty').each(function(){
        let value = $(this).val();
        if(value != undefined && value != '' ){
            totalQtyMaterial+= Number(value);
        }
    });
    $(note).closest('table').find('td.material_input_qty_total').html(totalQtyMaterial);
}
