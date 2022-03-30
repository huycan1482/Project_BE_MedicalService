$(document).ready(function(){
    $('.select2').select2();

    $(document).on('click', '.add-session', function(e) {
        var url = base_url + '/admin/session';
        var start_at = $("#start_at").val();
        var end_at = $("#end_at").val();
        var address = $("#address").val();
        var status_id = $("#status_id").val();
        var disease_id = $("#disease_id").val();
        var vaccine_id = $("#vaccine_id").val();

        // start_at = '17/03/2022';
        // end_at = '16/03/2022';

        var data = {
            'start_at' : start_at, 
            'end_at' : end_at,
            'address': address,
            'status_id': status_id,
            'disease_id': disease_id,
            'vaccine_id': vaccine_id,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-session', function(e) {
        var url = '/admin/session/' + $(this).attr('data-id');
        var start_at = $("#start_at").val();
        var end_at = $("#end_at").val();
        var address = $("#address").val();
        var status_id = $("#status_id").val();
        var disease_id = $("#disease_id").val();
        var vaccine_id = $("#vaccine_id").val();

        var data = {
            'start_at' : start_at, 
            'end_at' : end_at,
            'address': address,
            'status_id': status_id,
            'disease_id': disease_id,
            'vaccine_id': vaccine_id,
        };

        updateModel(url, data);
    });
});