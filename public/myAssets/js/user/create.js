$(document).ready(function(){
    $('.select2').select2();
    CKEDITOR.replace('description');

    $(document).on('click', '.add-user', function(e) {
        var url = base_url + '/admin/user';
        var name = $("#name").val();
        var gender = $("#gender").val();
        var date_of_birth = $("#date_of_birth").val();
        var phone = $('#phone').val();
        var identity_card = $('#identity_card').val();
        var address = $('#address').val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var email = $('#email').val();
        var password = $('#password').val();
        var ward_id = $('#ward_id').val();
        var role_id = $('#role_id').val();

        var data = {
            'name' : name, 
            'gender' : gender,
            'date_of_birth': date_of_birth,
            'phone': phone,
            'identity_card': identity_card,
            'address': address,
            'description': description,
            'is_active': is_active,
            'email': email,
            'password': password,
            'ward_id': ward_id,
            'role_id': role_id,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-user', function(e) {
        var url = '/admin/user/' + $(this).attr('data-id');
        var name = $("#name").val();
        var gender = $("#gender").val();
        var date_of_birth = $("#date_of_birth").val();
        var phone = $('#phone').val();
        var identity_card = $('#identity_card').val();
        var address = $('#address').val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var email = $('#email').val();
        var password = $('#password').val();
        var ward_id = $('#ward_id').val();
        var role_id = $('#role_id').val();

        var data = {
            'name' : name, 
            'gender' : gender,
            'date_of_birth': date_of_birth,
            'phone': phone,
            'identity_card': identity_card,
            'address': address,
            'description': description,
            'is_active': is_active,
            'email': email,
            'password': password,
            'ward_id': ward_id,
            'role_id': role_id,
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

    $(document).on('change', '#province_id2', function(e) {
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
                    $('#district_id2').html(data_html);
                }
            }
        });

    });

    $(document).on('change', '#district_id2', function(e) {
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
                    $('#ward_id2').html(data_html);
                }
            }
        });
    });

    $(document).on('change', '#ward_id2', function(e) {
        var district_id = $(this).val();
        $.ajax({
            type: "GET",
            url: base_url + '/admin/role/getRolesByWardId/' + district_id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data_html = "<option value=''>--Chọn--</option>";
                    response.data.forEach(function (value, index) {
                        data_html += '<option value="'+ value.id +'">'+ value.name +'</option>';
                    });
                    $('#role_id').html(data_html);
                }
            }
        });
    });
});