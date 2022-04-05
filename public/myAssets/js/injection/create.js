$(document).ready(function(){
    $('.select2').select2();

    $(document).on('click', '.add-injection', function(e) {
        var url = base_url + '/admin/injection';
        var resident_id = $(this).attr('data-id');
        var type = 0;
        var pack_id = $("#pack_id").val();
        var dose = $("#dose").val();
        var created_at = $("#created_at").val();
        var priority_id = $("#priority_id").val();
        var injector_id = $("#injector_id").val();
        var reaction_id = $("#reaction_id").val();
        var watcher_id = $("#watcher_id").val();
        var description = $("#description").val();
        var data = {
            'resident_id': resident_id,
            'type' : type, 
            'pack_id' : pack_id,
            'dose' : dose,
            'created_at' : created_at,
            'priority_id' : priority_id,
            'injector_id' : injector_id,
            'reaction_id' : reaction_id,
            'watcher_id' : watcher_id,
            'description' : description,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-injection', function(e) {
        var url = '/admin/injection/' + $(this).attr('data-id');
        var type = $("#type").val();
        var vaccine_id = $("#vaccine_id").val();
        var pack_id = $("#pack_id").val();
        var dose = $("#dose").val();
        var created_at = $("#created_at").val();
        var priority_id = $("#priority_id").val();
        var injector_id = $("#injector_id").val();
        var reaction_id = $("#reaction_id").val();
        var watcher_id = $("#watcher_id").val();
        var description = $("#description").val();
        var data = {
            'type' : type, 
            'vaccine_id' : vaccine_id,
            'pack_id' : pack_id,
            'dose' : dose,
            'created_at' : created_at,
            'priority_id' : priority_id,
            'injector_id' : injector_id,
            'reaction_id' : reaction_id,
            'watcher_id' : watcher_id,
            'description' : description,
        };

        updateModel(url, data);
    }); 

    $(document).on('change', '#disease_id', function (e) {
        var disease_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + '/admin/vaccine/getVaccinesByDiseaseId/' + disease_id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data_html = "<option value=''>--Chọn--</option>";
                    response.data.forEach(function (value, index) {
                        data_html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('#vaccine_id').html(data_html);
                }
            }
        });
    });

    $(document).on('change', '#vaccine_id', function (e) {
        var vaccine_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + '/admin/pack/getActivePacksByVaccineId/' + vaccine_id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data_html = "<option value=''>--Chọn--</option>";
                    response.data.forEach(function (value, index) {
                        data_html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('#pack_id').html(data_html);
                }
            }
        });
    });
});