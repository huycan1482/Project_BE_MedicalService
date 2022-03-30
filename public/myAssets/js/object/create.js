$(document).ready(function(){
    $(document).on('click', '.add-object', function(e) {
        var url = base_url + '/admin/object';
        var name = $("#name").val();
        var abbreviation = $("#abbreviation").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'abbreviation' : abbreviation,
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-object', function(e) {
        var url = '/admin/object/' + $(this).attr('data-id');
        var name = $("#name").val();
        var abbreviation = $("#abbreviation").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'abbreviation' : abbreviation,
            'is_active': is_active,
        };

        updateModel(url, data);
    });
});