$(document).ready(function(){
    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);

    $(document).on('click', '.btn-filter', function(e) {
        var disease = $('#disease').val();
        disease === "" ? urlParams.delete('disease') : urlParams.set('disease', disease);
        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });

    

});