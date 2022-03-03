$(document).ready(function(){
    $('.select2').select2();

    $(document).on('click', '.add-district', function(e) {
        var url = base_url + '/admin/district';
        var name = $("#name").val();
        var province_id = $("#province_id").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'province_id': province_id,
            'is_active': is_active
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-district', function(e) {
        var url = '/admin/district/' + $(this).attr('data-id');
        var name = $("#name").val();
        var province_id = $("#province_id").val();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'province_id': province_id,
            'is_active': is_active
        };

        updateModel(url, data);
    });
});