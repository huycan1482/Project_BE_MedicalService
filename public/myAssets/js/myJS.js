function reloadPage () {
    location.reload();
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
                messageFade('success', response.mess, 'Tải lại sau 1,5s');
                setTimeout(function (){
                    location.reload()
                }, 2500);
            },
            error: function (e) { // lỗi nếu có
                messageFade('danger', e.responseJSON.mess, 'Tải lại sau 1,5s');
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

function destroyModel (url, data) {
    var result = confirm("Bạn có chắc chắn muốn xóa ?");
    if (result) { 
        $.ajax({
            type: 'DELETE',
            url:base_url + '/admin/' + url + '/' + data,
            data: data,
            dataType : "json",
            success: function (response) {
                $('.item-'+id).closest('tr').remove();
                messageFade('success', response.mess, 'Tải lại sau 1,5s');
                setTimeout(function (){
                    location.reload()
                }, 2500);
            }, 
            error: function (e) {
                messageFade('danger', e.responseJSON.mess, 'Tải lại sau 1,5s');
            }
        });
    }
}