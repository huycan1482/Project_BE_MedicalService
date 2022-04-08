$(document).ready(function(){
    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);

    $(document).on('click', '.btn-filter', function(e) {
        var name = $('#name').val();
        var email = $('#email').val();
        var sort = $('#sort').val();
        var status = $('#status').val();
        var level = $('#level').val();
        var province = $('#province').val();
        var district = $('#district').val();
        var ward = $('#ward').val();

        if (province != undefined && district != undefined && ward != undefined) {
            province === "" ? urlParams.delete('province') : urlParams.set('province', province);
            district === "" ? urlParams.delete('district') : urlParams.set('district', district);
            ward === "" ? urlParams.delete('ward') : urlParams.set('ward', ward);
        }

        name === "" ? urlParams.delete('name') : urlParams.set('name', name);
        email === "" ? urlParams.delete('email') : urlParams.set('email', email);
        sort === "" ? urlParams.delete('sort') : urlParams.set('sort', sort);
        status === "" ? urlParams.delete('status') : urlParams.set('status', status);
        level === "" ? urlParams.delete('level') : urlParams.set('level', level);

        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });

    $('.select2').select2();
    
    $(document).on('change', '#province', function(e) {
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
                    $('#district').html(data_html);
                }
            }
        });

    });

    $(document).on('change', '#district', function(e) {
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
                    $('#ward').html(data_html);
                }
            }
        });
    });
});