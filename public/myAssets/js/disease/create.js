$(document).ready(function(){
    CKEDITOR.replace('description');
    
    $(document).on('click', '.add-disease', function(e) {
        var url = base_url + '/admin/disease';
        var name = $("#name").val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'description': description,
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-disease', function(e) {
        var url = '/admin/disease/' + $(this).attr('data-id');
        var name = $("#name").val();
        var description = $("#description").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'description': description,
            'is_active': is_active
        };

        updateModel(url, data);
    });
});