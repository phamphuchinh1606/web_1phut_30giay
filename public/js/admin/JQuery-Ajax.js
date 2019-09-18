/*==============================================================================*/
if ((typeof JQueryAjax) === 'undefined') { JQueryAjax = {}; }

JQueryAjax.call = function(url, data, callback, dataType = 'json', type = 'POST') {
    let params = {
            type: 'POST',
            url: url,
            data: data,
            dataType: '',
            beforeSend: function() {
                ModalConfirm.showLoading();
            },
            success: function(data) {
                if ((typeof callback) === 'function') {
                    callback(data);
                }
            },
            error: function(XMLHttpRequest, textStatus) {
                console.log('loi');
            },
            complete: function(jqxhr, text) {
                ModalConfirm.hideLoading();
            }
        };
    jQuery.ajax(params);
};
