/*==============================================================================*/
if ((typeof InputSaleCartSmallAPI) === 'undefined') { InputSaleCartSmallAPI = {}; }

InputSaleCartSmallAPI.updateInputDaily = function(note, callback) {
    var data = 'name=' + $(note).attr('name') +
        '&value='+InputFortmat.originalNumber($(note).val()) +
        '&date=' + $(note).closest('tr').find('input[name=sale_date]').val() +
        "&employee_id="+$(note).closest('td').find('input[name=employee_id]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: '/admin/sale-cart-small/update-sale-cart-small.js',
            data: data,
            dataType: 'json',
            beforeSend: function() {
                // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
            },
            success: function(data) {
                if ((typeof callback) === 'function') {
                    callback(cart);
                }
                else {
                    InputSaleCartSmallAPI.onInputUpdate(data,thisItem);
                }
                // $body.trigger('afterUpdateCartNote.ajaxCart', [note, cart]);
            },
            error: function(XMLHttpRequest, textStatus) {
                // $body.trigger('errorUpdateCartNote.ajaxCart', [XMLHttpRequest, textStatus]);
                // HaravanAPI.onError(XMLHttpRequest, textStatus);
            },
            complete: function(jqxhr, text) {
                // $body.trigger('completeUpdateCartNote.ajaxCart', [this, jqxhr, text]);
            }
        };
    jQuery.ajax(params);
};

InputSaleCartSmallAPI.onInputUpdate = function(data, thisItem) {
    thisItem.closest('tr').find('span.qty-target-'+ data.employee_id).html(data.qty_target);
    thisItem.closest('tr').find('span.bonus-amount-' + data.employee_id).html(data.bonus_amount);
    thisItem.closest('table').find('tfoot span.sum-qty-' + data.employee_id).html(data.sum_qty);
    thisItem.closest('table').find('tfoot span.sum-qty-target-' + data.employee_id).html(data.sum_qty_target);
    thisItem.closest('table').find('tfoot span.sum-bonus-amount-' + data.employee_id).html(data.sum_bonus_amount);
};
