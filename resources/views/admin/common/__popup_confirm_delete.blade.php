{{--<div id="popup-confirm" class="modal popup-confirm" tabindex="-1" role="dialog">--}}
    {{--<div class="modal-dialog modal-dialog-centered" role="document">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-body">--}}
                {{--<p>Bạn có thực sự muốn xóa : "<span id="confirm-delete-name"></span>" ?</p>--}}
                {{--<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>--}}
                {{--<form class="inline" action="route_delete" method="post" id="formHolder">--}}
                    {{--@csrf--}}
                    {{--<input name="_method" type="hidden" value="DELETE">--}}
                    {{--<button class="btn btn-sm btn-danger" type="submit">Yes</button>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div id="deleteModal" class="modal fade">--}}
    {{--<div class="modal-dialog modal-confirm">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-header">--}}
                {{--<div class="icon-box">--}}
                    {{--<i class="material-icons">&#xE5CD;</i>--}}
                {{--</div>--}}
                {{--<h4 class="modal-title">Xác nhận xóa ?</h4>--}}
                {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<p>Bạn có thực sự muốn xóa : "<span id="confirm-delete-name"></span>" ?</p>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-info" data-dismiss="modal">Hủy</button>--}}
                {{--<form class="inline" action="route_delete" method="post" id="formHolder">--}}
                    {{--@csrf--}}
                    {{--<input name="_method" type="hidden" value="DELETE">--}}
                    {{--<button type="submit" class="btn btn-danger">Xóa</button>--}}
                {{--</form>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xóa</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có thực sự muốn xóa : "<span id="confirm-delete-name"></span>" ?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                <form class="inline" action="route_delete" method="post" id="formHolder">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Xóa</button>
                </form>

            </div>
        </div>

    </div>

</div>

<script>
    function dataDeletePopup() {
        $('.anchorClick').each(function () {
            $(this).on('click', function () {
                var $url = $(this).attr('data-url');
                var $name = $(this).attr('data-name');
                $('#formHolder').attr('action', $url);
                $('#confirm-delete-name').html($name);
            });
        });

    }
    $(document).ready(function () {
        dataDeletePopup();
    })
</script>
