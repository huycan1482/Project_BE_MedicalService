$(document).ready(function(){
    $(document).on('click', '.add-province', function(e) {
        var url = base_url + '/admin/province';
        var name = $("#name").val();
        var code = $("#code").val();
        var data = {
            'name' : name, 
            'code' : code,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-province', function(e) {
        var url = '/admin/province/' + $(this).attr('data-id');
        var name = $("#name").val();
        var code = $("#code").val();
        var data = {
            'name' : name, 
            'code' : code,
        };

        updateModel(url, data);
    });
});