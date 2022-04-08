$(document).ready(function(){
    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);

    $(document).on('click', '.btn-filter', function(e) {
        var start_at = $('#start_at').val();
        var end_at = $('#end_at').val();
        var sort = $('#sort').val();
        var status = $('#status').val();

        start_at === "" ? urlParams.delete('start_at') : urlParams.set('start_at', start_at);
        end_at === "" ? urlParams.delete('end_at') : urlParams.set('end_at', end_at);
        sort === "" ? urlParams.delete('sort') : urlParams.set('sort', sort);
        status === "" ? urlParams.delete('status') : urlParams.set('status', status);

        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });
});