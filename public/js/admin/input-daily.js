/*==============================================================================*/
if ((typeof InputDailyAPI) === 'undefined') { InputDailyAPI = {}; }

InputDailyAPI.UpdateInputPriceDailyUrl = '/admin/input-daily/update-daily.js';
InputDailyAPI.UpdateInputDailyUrl = '/admin/input-daily/update-daily.js';
InputDailyAPI.UpdateSaleDailyUrl = '/admin/input-daily/update-sale.js';
InputDailyAPI.UpdateBillDailyUrl = '/admin/input-daily/update-bill.js';
InputDailyAPI.UpdateEmployeeDailyUrl = '/admin/input-daily/update-employee.js';

InputDailyAPI.updateInputPriceDaily = function(note, callback) {
    var materialId = $(note).closest('.modal-content').find('input[name=material_id]').val();
    var thisItem = $('tr#'+ materialId).find('input[name=price]');
    var data = 'name=' + $(note).attr('name') +
        '&value='+InputFortmat.originalDouble($(note).val()) +
        '&price=' + InputFortmat.originalNumber($(note).closest('.modal-content').find('input[name=price]').val()) +
        '&date=' + $('input[name=current_date]').val() +
        '&qty_in=' + InputFortmat.originalNumber(thisItem.closest('tr').find('input[name=qty_in]').val()) +
        "&material_id="+materialId;

    var $body = $(document.body),
        params = {
            type: 'POST',
            url: InputDailyAPI.UpdateInputPriceDailyUrl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
            },
            success: function(data) {
                if ((typeof callback) === 'function') {
                    InputDailyAPI.onInputUpdate(data,thisItem);
                    callback();
                }
                else {
                    InputDailyAPI.onInputUpdate(data,thisItem);
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

InputDailyAPI.updateInputDaily = function(note, callback) {
    var data = 'name=' + $(note).attr('name') +
        '&value='+InputFortmat.originalDouble($(note).val()) +
        '&price=' + $(note).closest('tr').find('input[name=price]').val() +
        '&date=' + $('input[name=current_date]').val() +
        "&material_id="+$(note).closest('tr').find('input[name=material_id]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: InputDailyAPI.UpdateInputDailyUrl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
                ModalConfirm.showLoading();
            },
            success: function(data) {
                if ((typeof callback) === 'function') {
                    callback(cart);
                }
                else {
                    InputDailyAPI.onInputUpdate(data,thisItem);
                }
                // $body.trigger('afterUpdateCartNote.ajaxCart', [note, cart]);
            },
            error: function(XMLHttpRequest, textStatus) {
                // $body.trigger('errorUpdateCartNote.ajaxCart', [XMLHttpRequest, textStatus]);
                // HaravanAPI.onError(XMLHttpRequest, textStatus);
            },
            complete: function(jqxhr, text) {
                // $body.trigger('completeUpdateCartNote.ajaxCart', [this, jqxhr, text]);
                ModalConfirm.hideLoading();
            }
        };
    jQuery.ajax(params);
};

InputDailyAPI.onInputUpdate = function(data, thisItem) {
    thisItem.closest('tr').find('span.amount_in').html(data.amount_in);
    thisItem.closest('tr').find('span.qty_out').html(data.qty_out);
    thisItem.closest('table').find('span.total-amount-check-in').html(data.total_amount_check_in);
    thisItem.closest('table').find('span.total-amount-check-out').html(data.total_amount_check_out);
    $('#table-bill').find('tr#' + data.product_id+' span.product-amount').html(data.product_amount);
    $('#table-bill').find('tr#' + data.product_id+' span.product-'+data.product_id).html(data.product_qty);
    $('#table-bill').find('span.total-amount').html(data.total_amount);
    $('#table-bill').find('span.total-qty').html(data.total_qty);
    $('#table-bill').find('span.lack-amount').html(data.lack_amount);
    if(data.price != undefined && data.price_str != undefined && data.price != '' && data.price_str != ''){
        thisItem.closest('tr').find('input[name=price]').val(data.price);
        thisItem.closest('tr').find('a.changePricePopupClick').html(data.price_str);
    }
};

InputDailyAPI.updateSaleDaily = function(note ,callback){
    var data = 'value='+InputFortmat.originalDouble($(note).val()) +
        '&product_id=' + $(note).closest('td').find('input[name=product_id]').val() +
        '&date=' + $('input[name=current_date]').val() +
        "&product_the_same_id="+$(note).closest('td').find('input[name=product_the_same_id]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: InputDailyAPI.UpdateSaleDailyUrl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                ModalConfirm.showLoading();
            },
            success: function(data) {
                if ((typeof callback) === 'function') {
                    callback(data);
                }
                else {
                    InputDailyAPI.onSaleDailyUpdate(data,thisItem);
                }
                // $body.trigger('afterUpdateCartNote.ajaxCart', [note, cart]);
            },
            error: function(XMLHttpRequest, textStatus) {
                // $body.trigger('errorUpdateCartNote.ajaxCart', [XMLHttpRequest, textStatus]);
                // HaravanAPI.onError(XMLHttpRequest, textStatus);
            },
            complete: function(jqxhr, text) {
                ModalConfirm.hideLoading();
            }
        };
    jQuery.ajax(params);
}

InputDailyAPI.onSaleDailyUpdate = function(data, thisItem){
    thisItem.closest('tr').find('span.product-amount').html(data.product_amount);
    thisItem.closest('table').find('tr#'+data.product_the_same_id+' span.product-amount').html(data.product_the_same_amount);
    thisItem.closest('table').find('.product-'+data.product_the_same_id).html(data.product_the_same_qty);
    thisItem.closest('table').find('span.total-amount').html(data.total_amount);
    thisItem.closest('table').find('span.total-qty').html(data.total_qty);
    thisItem.closest('table').find('span.lack-amount').html(data.lack_amount);
}


InputDailyAPI.updateBillDaily = function (note, callback){
    var data = 'value='+InputFortmat.originalDouble($(note).val()) +
        '&date=' + $('input[name=current_date]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: InputDailyAPI.UpdateBillDailyUrl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                ModalConfirm.showLoading();
            },
            success: function(data) {
                if ((typeof callback) === 'function') {
                    callback(data);
                }
                else {
                    InputDailyAPI.onBillUpdate(data,thisItem);
                }
                // $body.trigger('afterUpdateCartNote.ajaxCart', [note, cart]);
            },
            error: function(XMLHttpRequest, textStatus) {
                // $body.trigger('errorUpdateCartNote.ajaxCart', [XMLHttpRequest, textStatus]);
                // HaravanAPI.onError(XMLHttpRequest, textStatus);
            },
            complete: function(jqxhr, text) {
                ModalConfirm.hideLoading();
            }
        };
    jQuery.ajax(params);
}

InputDailyAPI.onBillUpdate = function(data, thisItem){
    thisItem.closest('table').find('span.lack-amount').html(data.lack_amount);
}

InputDailyAPI.updateEmployeeDaily = function(note, callback){
    var data = 'value='+InputFortmat.originalDouble($(note).val()) +
        '&name=' + $(note).attr('name') +
        '&employee_id=' + $(note).closest('tr').find('input[name=employee_id]').val() +
        '&date=' + $('input[name=current_date]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: InputDailyAPI.UpdateEmployeeDailyUrl,
            data: data,
            dataType: 'json',
            beforeSend: function() {
                ModalConfirm.showLoading();
            },
            success: function(data) {
                console.log(data);
                if ((typeof callback) === 'function') {
                    callback(data);
                }
                else {
                    InputDailyAPI.onEmployeeUpdate(data,thisItem);
                }
                // $body.trigger('afterUpdateCartNote.ajaxCart', [note, cart]);
            },
            error: function(XMLHttpRequest, textStatus) {
                // $body.trigger('errorUpdateCartNote.ajaxCart', [XMLHttpRequest, textStatus]);
                // HaravanAPI.onError(XMLHttpRequest, textStatus);
            },
            complete: function(jqxhr, text) {
                ModalConfirm.hideLoading();
            }
        };
    jQuery.ajax(params);
}

InputDailyAPI.onEmployeeUpdate = function(data, thisItem){
    thisItem.closest('tr').find('span.total-amount-employee').html(data.total_amount_employee);
    thisItem.closest('table').find('span.total-first-hour').html(data.total_first_hour);
    thisItem.closest('table').find('span.total-last-hour').html(data.total_last_hour);
    thisItem.closest('table').find('span.total-first-amount').html(data.total_first_amount);
    thisItem.closest('table').find('span.total-last-amount').html(data.total_last_amount);
    thisItem.closest('table').find('span.total-amount').html(data.total_amount);
    thisItem.closest('table').find('span.total-qty').html(data.total_qty);
    thisItem.closest('table').find('span.total-hour').html(data.total_hour);
}
