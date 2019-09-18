/*==============================================================================*/
if ((typeof PrepareMaterialAPI) === 'undefined') { PrepareMaterialAPI = {}; }

PrepareMaterialAPI.updateInputPrepare = function(note, urlPost, callback) {
    let data = 'name=' + $(note).attr('name') +
        '&value='+InputFortmat.originalNumber($(note).val()) +
        '&last_date=' + $('input[name=last_date]').val() +
        "&branch_id="+$(note).closest('td').find('input[name=branch_id]').val() +
        "&product_id="+$(note).closest('td').find('input[name=product_id]').val();
    let thisItem = $(note);

    let callSuccess = function (data){
        PrepareMaterialAPI.successUpdateInputPrepare(data,thisItem);
    };

    JQueryAjax.call(urlPost, data, callSuccess);
};

PrepareMaterialAPI.successUpdateInputPrepare = function (data, thisItem) {
    $('div.prepare-material-content').html(data);
}
