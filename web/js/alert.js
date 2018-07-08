$(document).ready(function(){

    var msg = $('#message');
    var type = $("#message").attr("data-type");
    var alert;
    var message = $("#message").attr("data-flash");
    if (type === "dangering") {
        alert = '<i class="fa fa-warning"></i>';
    } else {
        alert = '<span class="glyphicon glyphicon-check"></span>';
    }
    var content = '<div class="col-lg-4 col-lg-offset-8 text-center">\
            <div class="alert alert-' + type + '">\
                ' + alert + '\
                ' + " " + message + '\
            </div>\
        </div>';

    if (msg) {
        msg
            .html(content)
            .hide()
            .velocity("slideDown", {
                duration: 500
            });
    }
    
});

// .velocity("slideUp", {
//     delay: 3000,
//     duration: 500
// })