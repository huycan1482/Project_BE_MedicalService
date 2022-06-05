function messageResponse (status, mess) {
    $("html, body").animate({ scrollTop: 0 }, "slow");
                        
    var message = "<div class='pad margin no-print col-md-3' id='message' style='position: fixed; right: -5px; z-index: 1051; top: 40px'><div class='alert alert-" + status + " alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Thông báo !</h4>"+ mess +"</div></div>"

    if ( $('#message') ) {
        $('#message').remove();
    }

    $('.content-header').after(message);
    
    $('#message').fadeIn();

    // $('#message').delay(2500).fadeOut();
}


function messageFade (status, mess, reload) {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

    var message = "<div class='pad margin no-print col-md-3' id='message' style='position: fixed; right: -5px; z-index:1051; top: 40px; width: '><div class='alert alert-" + status + " alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Thông báo !</h4>"
    + mess +" <br> "+ reload +" </div></div>";

    if ( $('#message') ) {
        $('#message').remove();
    }

    $('.content-header').after(message);

    $('#message').fadeIn();

    // $('#message').delay(2500).fadeOut();
}

function messageReload (status, mess, reload) {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");

    var message = "<div class='pad margin no-print col-md-3' id='message' style='position: fixed; right: -5px; z-index:1051; top: 40px; width: '><div class='alert alert-" + status + " alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-check'></i> Thông báo !</h4>"
    + mess +" <br> "+ reload +" </div></div>";

    if ( $('#message') ) {
        $('#message').remove();
    }

    $('.content-header').after(message);
}

function successResponse (response) {
    $("*").removeClass('has-error');
    $('.sp-error').remove();

    messageResponse('success', response.mess);
}

function errorResponse (e) {

    if (e.responseJSON.errors != null) {
    errors = e.responseJSON.errors;
        
        $("*").removeClass('has-error');

        $('.sp-error').remove();

        $.each( errors, function( key, value ) {
            // console.log( key + ": " + value[0] );
            $('.sp-' + key).remove();
            $('#form-' + key).addClass('has-error');
            // $('#form-' + key).append("<span class='help-block sp-" + key + " sp-error'>"+ value[0] +"</span>");
            $('#form-' + key + ' > div').append("<span class='help-block sp-" + key + " sp-error'>"+ value[0] +"</span>");
        });
    }
    messageResponse('danger', e.responseJSON.mess);
}