$(document).ready(function(){
    $('.select2').select2();
    CKEDITOR.replace('description');

    $(document).on('click', '.add-resident', function(e) {
        var url = base_url + '/admin/resident';
        var name = $("#name").val();
        var gender = $("#gender").val();
        var date_of_birth = $("#date_of_birth").val();
        var phone = $('#phone').val();
        var nationality_id = $('#nationality_id').val();
        var identity_card = $('#identity_card').val();
        var health_insurance_card = $('#health_insurance_card').val();
        var job = $('#job').val();
        var work_place = $('#work_place').val();
        var address = $('#address').val();
        var description = CKEDITOR.instances.description.getData();
        var status_id = ( $("input[name='status_id']").is(':checked') ) ? 1 : 0;
        var ward_id = $('#ward_id').val();

        var data = {
            'name' : name, 
            'gender' : gender,
            'date_of_birth': date_of_birth,
            'phone': phone,
            'nationality_id': nationality_id,
            'identity_card': identity_card,
            'health_insurance_card': health_insurance_card,
            'job': job,
            'work_place': work_place,
            'address': address,
            'description': description,
            'status_id': status_id,
            'ward_id': ward_id,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-resident', function(e) {
        var url = '/admin/resident/' + $(this).attr('data-id');
        var name = $("#name").val();
        var gender = $("#gender").val();
        var date_of_birth = $("#date_of_birth").val();
        var phone = $('#phone').val();
        var nationality_id = $('#nationality_id').val();
        var identity_card = $('#identity_card').val();
        var health_insurance_card = $('#health_insurance_card').val();
        var job = $('#job').val();
        var work_place = $('#work_place').val();
        var address = $('#address').val();
        var description = CKEDITOR.instances.description.getData();
        var status_id = ( $("input[name='status_id']").is(':checked') ) ? 1 : 0;
        var ward_id = $('#ward_id').val();

        var data = {
            'name' : name, 
            'gender' : gender,
            'date_of_birth': date_of_birth,
            'phone': phone,
            'nationality_id': nationality_id,
            'identity_card': identity_card,
            'health_insurance_card': health_insurance_card,
            'job': job,
            'work_place': work_place,
            'address': address,
            'description': description,
            'status_id': status_id,
            'ward_id': ward_id,
        };
        updateModel(url, data);
    });

    $(document).on('change', '#province_id', function(e) {
        var province_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + '/admin/district/getDistrictsByProvinceId/' + province_id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data_html = "<option value=''>--Chọn--</option>";
                    response.data.forEach(function (value, index) {
                        data_html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('#district_id').html(data_html);
                }
            }
        });
    });

    $(document).on('change', '#district_id', function(e) {
        var district_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + '/admin/ward/getWardsByDistrictId/' + district_id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data_html = "<option value=''>--Chọn--</option>";
                    response.data.forEach(function (value, index) {
                        data_html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('#ward_id').html(data_html);
                }
            }
        });
    });
});