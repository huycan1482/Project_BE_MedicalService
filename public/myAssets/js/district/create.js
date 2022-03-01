$(document).ready(function(){
    $(document).on('click', '.add-district', function(e) {
        var url = base_url + '/admin/district';
        var name = $("#name").val();
        var code = $("#code").val();
        var data = {
            'name' : name, 
            'code' : code,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-district', function(e) {
        var url = '/admin/district/' + $(this).attr('data-id');
        var name = $("#name").val();
        var code = $("#code").val();
        var data = {
            'name' : name, 
            'code' : code,
        };

        updateModel(url, data);
    });
});