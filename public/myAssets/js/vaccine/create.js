$(document).ready(function(){
    CKEDITOR.replace('description');
    $('.select2').select2();
    
    $(document).on('click', '.add-vaccine', function(e) {
        var url = base_url + '/admin/vaccine';
        var name = $("#name").val();
        var disease_id = $('#disease_id').val();
        var producer_id = $('#producer_id').val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;

        var data = {
            'name' : name, 
            'description': description,
            'is_active': is_active,
            'disease_id': disease_id,
            'producer_id': producer_id,
        };

        addModel(url, data);
    });

    $(document).on('click', '.edit-vaccine', function(e) {
        var url = '/admin/vaccine/' + $(this).attr('data-id');
        var name = $("#name").val();
        var disease_id = $('#disease_id').val();
        var producer_id = $('#producer_id').val();
        var description = CKEDITOR.instances.description.getData();
        var is_active = ( $("input[name='is_active']").is(':checked') ) ? 1 : 0;
        
        var data = {
            'name' : name, 
            'description': description,
            'is_active': is_active,
            'disease_id': disease_id,
            'producer_id': producer_id,
        };

        console.log(data);

        updateModel(url, data);
    });
});