$(document).ready(function(){
    $('.select2').select2();

    $(document).on('click', '.add-ward', function(e) {
        var url = base_url + '/admin/ward';
        var name = $("#name").val();
        var district_id = $("#district_id").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'district_id': district_id,
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-ward', function(e) {
        var url = '/admin/ward/' + $(this).attr('data-id');
        var name = $("#name").val();
        var district_id = $("#district_id").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'district_id': district_id,
            'is_active': is_active
        };

        updateModel(url, data);
    });
});