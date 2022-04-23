$(document).ready(function(){
    $('.select2').select2();

    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);
    //Bộ lọc
    $(document).on('click', '.btn-filter', function(e) {
        var name = $('#name').val();
        var identity = $('#identity').val();
        var sort = $('#sort').val();
        var status = $('#status').val();

        identity === "" ? urlParams.delete('identity') : urlParams.set('identity', identity);
        sort === "" ? urlParams.delete('sort') : urlParams.set('sort', sort);
        status === "" ? urlParams.delete('status') : urlParams.set('status', status);

        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });

    //Lấy dữ liệu quận
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

    //Lấy dữ liệu phường
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

    //Tìm kiếm dữ liệu residents
    $(document).on('click', '.search-resident', function(e) {
        var identity_card = $("input[name='identity_card']").val();
        var name = $("input[name='name']").val();
        var date_of_birth = $("input[name='date_of_birth']").val();
        var phone = $("input[name='phone']").val();
        var province_id = $("input[name='province_id']").val();
        var district_id = $("input[name='district_id']").val();
        var ward_id = $("input[name='ward_id']").val();

        $.ajax({
            type: "GET",
            url: base_url + '/admin/searchResidents',
            data: {
                'identity_card': identity_card,
                'name': name,
                'date_of_birth': date_of_birth,
                'phone': phone,
                'province_id': province_id,
                'district_id': district_id,
                'ward_id': ward_id,
            },
            dataType: "JSON",
            success: function (response) {
                var data_html = "";
                response.data.forEach(function (value, index) {
                    data_html += "<tr><td>"+ value.name + "</td>" + "<td class='text-center'>"+ value.date_of_birth + "</td>" + "<td class='text-center'>"+ value.phone + "</td>" + "<td>"+ value.address + "</td>"+ "<td class='text-center'><button class='btn btn-primary add-object' data-id='"+ value.id +"'><i class='fa fa-solid fa-plus'></i></button></td></tr>";
                });
                $('.list-user').html(data_html);
            }
        });
    });


    $(document).on('click', '.add-object', function(e) {
        var resident_id = $(this).attr('data-id');
        var session_id = $('.session_id').val();
        
        $.ajax({
            type: "POST",
            url: base_url + '/admin/object',
            data: {
                'resident_id': resident_id,
                'session_id': session_id,
            },
            dataType: "JSON",
            success: function (response) {
                messageReload ('success', response.mess, 'Tải lại sau 1.5s');
                // setTimeout(location.reload.bind(location), 1500);
                setTimeout(function () {
                    reloadPage();
                }, 1500);
            }, 
            error: function (e) { // lỗi nếu có
                console.log(e);
                messageResponse ('danger', e.responseJSON.mess);
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

    $(document).on('click', '#btn-active-modal-injection', function(e) {
        var resident_id = $(this).attr('resident-id');
        var object_id = $(this).attr('object-id');

        $('#add-injection').attr('resident-id', resident_id);
        $('#add-injection').attr('object-id', object_id);
    });

    $(document).on('click', '#add-injection', function (e) {
        var url = base_url + '/admin/injection';

        var pack_id = $('#pack_id').val();
        var resident_id = $(this).attr('resident-id');
        var object_id = $(this).attr('object-id');
        var priority_id = $('#priority_id').val();
        var type = 1;
        var dose = $('#dose').val();
        var reaction_id = $('#reaction_id').val();
        var injector_id = $('#injector_id').val();
        var watcher_id = $('#watcher_id').val();
        var description = $('#description').val();
        var disease_id = $('#disease_id').val();
        var created_at = $('#created_at').val();

        var data = {
            'pack_id': pack_id,
            'resident_id': resident_id,
            'object_id': object_id,
            'priority_id': priority_id,
            'type': type,
            'dose': dose,
            'reaction_id': reaction_id,
            'injector_id': injector_id,
            'watcher_id': watcher_id,
            'description': description,
            'disease_id': disease_id,
            'created_at': created_at,
        }

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "JSON",
            success: function (response) {
                messageReload ('success', response.mess, 'Tải lại sau 1.5s');
                // setTimeout(location.reload.bind(location), 1500);
                setTimeout(function () {
                    reloadPage();
                }, 1500);
            }, 
            error: function (e) { // lỗi nếu có
                console.log(e);
                messageResponse ('danger', e.responseJSON.mess);
            }
        });

    });

});