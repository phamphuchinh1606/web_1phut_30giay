if ((typeof ModalConfirm) === 'undefined') { ModalConfirm = {}; }

ModalConfirm.showConfirm = function(title,content, url="", callbackCancel, callbackOk , okName = "Có", cancelName = "Không")
{
    $('#dangerModal').on('shown.bs.modal', function (event) {
        let modal = $(this)
        modal.find('#formHolder').attr('action', url);
        modal.find('#confirm-content').html(content);
        modal.find('.modal-title').html(title);
        modal.find('.name-cancel').html(cancelName);
        modal.find('.name-ok').html(okName);

        modal.find('.btn-cancel').on('click',function(){
            if ((typeof callbackCancel) === 'function') {
                callbackCancel();
            }
        });
        modal.find('.btn-ok').on('click',function(){
            if ((typeof callbackOk) === 'function') {
                callbackOk();
            }
        });
    })
    $('#dangerModal').modal();
}
