$(document).ready(function(){
    $(document).on('click', '.add-nationality', function(e) {
        var url = base_url + '/admin/nationality';
        var name = $("#name").val();
        var abbreviation = $("#abbreviation").val();
        var data = {
            'name' : name, 
            'abbreviation' : abbreviation,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-nationality', function(e) {
        var url = '/admin/nationality/' + $(this).attr('data-id');
        var name = $("#name").val();
        var abbreviation = $("#abbreviation").val();
        var data = {
            'name' : name, 
            'abbreviation' : abbreviation,
        };

        updateModel(url, data);
    });
});