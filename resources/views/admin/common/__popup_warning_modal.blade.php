<div class="modal fade show" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog modal-warning" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p> <span id="confirm-content"></span> ?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary name-cancel" type="button" data-dismiss="modal">Cancel</button>
                <form class="inline" action="route" method="post" id="formHolder">
                    @csrf
                    <button class="btn btn-warning name-ok" type="submit">OK</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function dataWarningPopup() {
        $('.warningPopupClick').each(function () {
            $(this).on('click', function () {
                let $url = $(this).attr('data-url');
                let $dataContent = $(this).attr('data-content');
                let $title = $(this).attr('data-title');
                let $nameCancel = $(this).attr('data-name-cancel');
                let $nameOK = $(this).attr('data-name-ok');

                $('#warningModal #formHolder').attr('action', $url);
                $('#warningModal #confirm-content').html($dataContent);
                $('#warningModal .modal-title').html($title);
                $('#warningModal .name-cancel').html($nameCancel);
                $('#warningModal .name-ok').html($nameOK);
            });
        });

    }
    $(document).ready(function () {
        dataWarningPopup();
    })
</script>
