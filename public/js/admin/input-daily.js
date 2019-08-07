/*==============================================================================*/
if ((typeof InputDailyAPI) === 'undefined') { InputDailyAPI = {}; }

InputDailyAPI.updateInputDaily = function(note, callback) {
    var data = 'name=' + $(note).attr('name') +
        '&value='+$(note).val() +
        '&price=' + $(note).closest('tr').find('input[name=price]').val() +
        '&date=' + $('input[name=current_date]').val() +
        "&material_id="+$(note).closest('tr').find('input[name=material_id]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: 'input-daily/update-daily.js',
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

InputDailyAPI.onInputUpdate = function(data, thisItem) {
    thisItem.closest('tr').find('span.amount_in').html(data.amount_in);
    thisItem.closest('tr').find('span.qty_out').html(data.qty_out);
    $('#table-bill').find('tr#' + data.product_id+' span.product-amount').html(data.product_amount);
    $('#table-bill').find('tr#' + data.product_id+' span.product-'+data.product_id).html(data.product_qty);
    $('#table-bill').find('span.total-amount').html(data.total_amount);
    $('#table-bill').find('span.lack-amount').html(data.lack_amount);
};

InputDailyAPI.updateSaleDaily = function(note ,callback){
    var data = 'value='+$(note).val() +
        '&product_id=' + $(note).closest('td').find('input[name=product_id]').val() +
        '&date=' + $('input[name=current_date]').val() +
        "&product_the_same_id="+$(note).closest('td').find('input[name=product_the_same_id]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: 'input-daily/update-sale.js',
            data: data,
            dataType: 'json',
            beforeSend: function() {
                // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
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
                // $body.trigger('completeUpdateCartNote.ajaxCart', [this, jqxhr, text]);
            }
        };
    jQuery.ajax(params);
}

InputDailyAPI.onSaleDailyUpdate = function(data, thisItem){
    thisItem.closest('tr').find('span.product-amount').html(data.product_amount);
    thisItem.closest('table').find('tr#'+data.product_the_same_id+' span.product-amount').html(data.product_the_same_amount);
    thisItem.closest('table').find('.product-'+data.product_the_same_id).html(data.product_the_same_qty);
    thisItem.closest('table').find('span.total-amount').html(data.total_amount);
    thisItem.closest('table').find('span.lack-amount').html(data.lack_amount);
}


InputDailyAPI.updateBillDaily = function (note, callback){
    var data = 'value='+$(note).val() +
        '&date=' + $('input[name=current_date]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: 'input-daily/update-bill.js',
            data: data,
            dataType: 'json',
            beforeSend: function() {
                // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
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
                // $body.trigger('completeUpdateCartNote.ajaxCart', [this, jqxhr, text]);
            }
        };
    jQuery.ajax(params);
}

InputDailyAPI.onBillUpdate = function(data, thisItem){
    thisItem.closest('table').find('span.lack-amount').html(data.lack_amount);
}

InputDailyAPI.updateEmployeeDaily = function(data, callback){
    var data = 'value='+$(note).val() +
        '&name=' + $(note).attr('name') +
        '&employee_id=' + $(note).closest('tr').find('input[name=employee_id]').val() +
        '&date=' + $('input[name=current_date]').val();
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: 'input-daily/update-employee.js',
            data: data,
            dataType: 'json',
            beforeSend: function() {
                // $body.trigger('beforeUpdateCartNote.ajaxCart', note);
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
                // $body.trigger('completeUpdateCartNote.ajaxCart', [this, jqxhr, text]);
            }
        };
    jQuery.ajax(params);
}
