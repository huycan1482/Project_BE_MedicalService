$(document).ready(function() {
    $('.select2').select2();

    $(document).on('click', '.add-pack', function(e) {
        var url = base_url + '/admin/pack';
        var name = $("#name").val();
        var expired = $("#expired").val();
        var vaccine_id  = $("#vaccine_id ").val();
        var producer_id  = $("#producer_id ").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'expired': expired,
            'vaccine_id': vaccine_id,
            'producer_id': producer_id,
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-pack', function(e) {
        var url = '/admin/pack/' + $(this).attr('data-id');
        var name = $("#name").val();
        var expired = $("#expired").val();
        var vaccine_id  = $("#vaccine_id ").val();
        var producer_id  = $("#producer_id ").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'expired': expired,
            'vaccine_id': vaccine_id,
            'producer_id': producer_id,
            'is_active': is_active
        };

        updateModel(url, data);
    });

    $(document).on('change', '#vaccine_id', function(e) {
        var vaccine_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + '/admin/producer/getActiveProducersByVaccineId/' + vaccine_id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data_html = "<option value=''>--Chọn--</option>";
                    response.data.forEach(function (value, index) {
                        data_html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('#producer_id').html(data_html);
                }
            }
        });
    });
});