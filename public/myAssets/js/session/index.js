$(document).ready(function(){
    const pathname = window.location.pathname;
    const urlParams = new URLSearchParams(window.location.search);

    $(document).on('click', '.btn-filter', function(e) {
        var start_at = $('#start_at').val();
        var end_at = $('#end_at').val();
        var sort = $('#sort').val();
        var status = $('#status').val();

        start_at === "" ? urlParams.delete('start_at') : urlParams.set('start_at', start_at);
        end_at === "" ? urlParams.delete('end_at') : urlParams.set('end_at', end_at);
        sort === "" ? urlParams.delete('sort') : urlParams.set('sort', sort);
        status === "" ? urlParams.delete('status') : urlParams.set('status', status);

        window.location.href = pathname + "?" + decodeURIComponent(urlParams.toString());
    });
    
    $(document).on('click', '.show-statistics', function (e) {
        var id = $(this).attr('data-id');

        $.ajax({
            type: "GET",
            url: base_url + '/admin/session/' + id,
            data: "",
            dataType: "JSON",
            success: function (response) {
                if (response.status) {
                    var data = response.data;

                    $('.table-1 td:nth-child(1)').text(data.start_at);
                    $('.table-1 td:nth-child(2)').text(data.end_at);
                    $('.table-1 td:nth-child(3)').text(data.disease);
                    $('.table-1 td:nth-child(4)').text(data.vaccines);
                    $('.table-1 td:nth-child(5)').text(data.ward);

                    $('.table-2 td:nth-child(1)').text(data.number_injected + '/' + data.number);

                    if (data.status == 0)
                        $('.table-2 td:nth-child(2)').html("<span class='label label-warning'>Hoãn</span>");
                    else if (data.status == 1)
                        $('.table-2 td:nth-child(2)').html("<span class='label label-danger'>Chưa hoàn thành</span>");
                    else
                        $('.table-2 td:nth-child(2)').html("<span class='label label-success'>Hoàn thành</span>");

                    var age_65 = (data.age_65 * 100 /data.number).toFixed(2);
                    var age_18_65 = (data.age_18_65 * 100 /data.number).toFixed(2);
                    var age_12_17 = (data.age_12_17 * 100 /data.number).toFixed(2);
                    var age_5_11 = (data.age_5_11 * 100 /data.number).toFixed(2);

                    age_65 = isNaN(age_65) == true ? 0 : age_65;
                    age_18_65 = isNaN(age_18_65) == true ? 0 : age_18_65;
                    age_12_17 = isNaN(age_12_17) == true ? 0 : age_12_17;
                    age_5_11 = isNaN(age_5_11) == true ? 0 : age_5_11;

                    $('.table-2 td:nth-child(3)').text(data.age_65 + ' (' + age_65 + '%)');
                    $('.table-2 td:nth-child(4)').text(data.age_18_65 + ' (' + age_18_65 + '%)');
                    $('.table-2 td:nth-child(5)').text(data.age_12_17 + ' (' + age_12_17 + '%)');
                    $('.table-2 td:nth-child(6)').text(data.age_5_11 + ' (' + age_5_11 + '%)');
                }
            }
        });
    });

});