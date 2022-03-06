$(document).ready(function(){
    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);

    $(document).on('click', '.btn-filter', function(e) {
        var name = $('#name').val();
        var sort = $('#sort').val();
        var status = $('#status').val();

        name === "" ? urlParams.delete('name') : urlParams.set('name', name);
        sort === "" ? urlParams.delete('sort') : urlParams.set('sort', sort);
        status === "" ? urlParams.delete('status') : urlParams.set('status', status);

        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });
});