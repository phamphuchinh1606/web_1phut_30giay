/*==============================================================================*/
if ((typeof TimeKeepingAPI) === 'undefined') { TimeKeepingAPI = {}; }

TimeKeepingAPI.updateTimeKeeping = function(note, callback) {
    employeeId = $(note).closest('td').find('input[name=employee_id]').val();
    var data = 'name=' + $(note).attr('name') +
        '&value='+InputFortmat.originalNumber($(note).val()) +
        '&month=' + $('input[name=current_month]').val() +
        '&employee_id=' + employeeId;
    var thisItem = $(note);
    var $body = $(document.body),
        params = {
            type: 'POST',
            url: 'time-keeping/update-time-keeping.js',
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
                    TimeKeepingAPI.onTimeKeeping(data,thisItem,employeeId);
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

TimeKeepingAPI.onTimeKeeping = function(data, thisItem, employeeId){
    thisItem.closest('table').find('span.salary-amount-'+employeeId).html(data.salary_amount);
    thisItem.closest('table').find('span.total-salary-amount').html(data.total_salary_amount);
}
