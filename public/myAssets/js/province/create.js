$(document).ready(function(){
    $(document).on('click', '.add-province', function(e) {
        var url = base_url + '/admin/province';
        var name = $("#name").val();
        var code = $("#code").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'is_active' : is_active,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-province', function(e) {
        var url = '/admin/province/' + $(this).attr('data-id');
        var name = $("#name").val();
        var code = $("#code").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'is_active' : is_active,
        };

        updateModel(url, data);
    });
});