$(document).ready(function(){
    $('.select2').select2();
    CKEDITOR.replace('description');

    $(document).on('click', '.add-role', function(e) {
        var url = base_url + '/admin/role';
        var name = $("#name").val();
        var level = $("#level").val();
        var ward_id = $("#ward_id").val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'level': level,
            'ward_id' : ward_id,
            'description': description,
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-role', function(e) {
        var url = '/admin/role/' + $(this).attr('data-id');
        var name = $("#name").val();
        var level = $("#level").val();
        var ward_id = $("#ward_id").val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        
        var data = {
            'name' : name, 
            'level': level,
            'ward_id' : ward_id,
            'description': description,
            'is_active': is_active
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