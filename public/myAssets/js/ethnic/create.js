$(document).ready(function(){
    $(document).on('click', '.add-ethnic', function(e) {
        var url = base_url + '/admin/ethnic';
        var name = $("#name").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-ethnic', function(e) {
        var url = '/admin/ethnic/' + $(this).attr('data-id');
        var name = $("#name").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        var data = {
            'name' : name, 
            'is_active': is_active,
        };

        updateModel(url, data);
    });
});