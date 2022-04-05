function reloadPage () {
    // location.reload();
    window.location = base_url + window.location.pathname;
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function destroyModel(model, id) {
    var result = confirm("Bạn có chắc chắn muốn xóa ?");
    if (result) { // neu nhấn == ok , sẽ send request ajax
        $.ajax({
            url: base_url + '/admin/'+model+'/'+id, // base_url được khai báo ở đầu page == http://webshop.local
            type: 'DELETE',
            data: {}, // dữ liệu truyền sang nếu có
            dataType: "json", // kiểu dữ liệu trả về
            success: function (response) { // success : kết quả trả về sau khi gửi request ajax
                $('.item-'+id).closest('tr').remove();// class .item- ở trong class của thẻ td đã khai báo trong file index
                messageFade('success', response.mess, '');
                // setTimeout(function (){
                //     location.reload()
                // }, 2500);
            },
            error: function (e) { // lỗi nếu có
                messageFade('danger', e.responseJSON.mess, '');
            }
        });
    }
}

function addModel (url, data) {
    $.ajax({
        type: "post",
        url: url,
        data: data,
        dataType: "json",
        success: function (response) {
            successResponse(response);
        }, 
        error: function (e) { 
            errorResponse(e);
        }
    });
}

function updateModel (url, data) {
    $.ajax({
        type: 'PUT',
        url: url,
        data: data,
        dataType : "json",
        success: function (response) {
            successResponse(response);
        }, 
        error: function (e) {
            errorResponse(e);
        }
    });
}


function restore (model, id) {
    var result = confirm("Bạn có chắc chắn muốn khôi phục bản ghi ?");
    if (result) { 
        $.ajax({
            url: base_url + '/admin/'+model+'/'+id,
            type: 'GET',
            data: {}, 
            dataType: "json", 
            success: function (response) { 
                $('.item-'+id).closest('tr').remove();
                messageFade('success', response.mess, '');
                // setTimeout(function (){
                //     location.reload()
                // }, 1500);
            },
            error: function (e) { 
                messageFade('danger', e.responseJSON.mess, '');
            }
        });
    }
}

function forceDelete (model, id) {
    var result = confirm("Bạn có chắc chắn muốn vĩnh viễn bản ghi và dữ liệu liên quan ?");
    if (result) { 
        $.ajax({
            url: base_url + '/admin/'+model+'/'+id,
            type: 'GET',
            data: {}, 
            dataType: "json", 
            success: function (response) { 
                $('.item-'+id).closest('tr').remove();
                messageFade('success', response.mess, '');
                // setTimeout(function (){
                //     location.reload()
                // }, 1500);
            },
            error: function (e) { 
                messageFade('danger', e.responseJSON.mess, '');
            }
        });
    }
}