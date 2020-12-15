<script>
    $(function() {
        let dropdownList = new ShowModal({
            'selector': '._labBtn',
            'e': 'click',
            'appendToSelector': '#modalBody',
            'route': '{{ route("lab._item") }}',
        });
        dropdownList.onReady();
    });
</script>
<div class="modal fade" tabindex="-1" role="dialog" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="modalBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>