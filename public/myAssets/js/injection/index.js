$(document).ready(function(){
    $('.select2').select2();

    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);
    //Bộ lọc
    $(document).on('click', '.btn-filter', function(e) {
        var disease = $('#disease').val();
        // var sort = $('#sort').val();
        // var status = $('#status').val();

        disease === "" ? urlParams.delete('disease') : urlParams.set('disease', disease);
        // sort === "" ? urlParams.delete('sort') : urlParams.set('sort', sort);
        // status === "" ? urlParams.delete('status') : urlParams.set('status', status);

        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });

});