/*==============================================================================*/
if ((typeof SelectedBranchMonth) === 'undefined') { SelectedBranchMonth = {}; }

SelectedBranchMonth.updateSelectedBranch = function(branchId, branchName, callback){
    let data = 'branch_id=' + branchId + '&branch_name=' + branchName;
    let $body = $(document.body),
        params = {
            type: 'POST',
            url: '/admin/setting/update-selected-branch.js',
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

                }
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

SelectedBranchMonth.updateSelectedMonth = function(date, callback){
    let data = 'month=' + date;
    let $body = $(document.body),
        params = {
            type: 'POST',
            url: '/admin/setting/update-selected-month.js',
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

                }
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
