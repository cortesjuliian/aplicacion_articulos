function PrintError(msg) {
    $(window).scrollTop(0);
    $('#MsgContainer').html('<h3 class="bad">' + msg + '</h3>');
}

function PrintOk(msg) {
    $(window).scrollTop(0);
    $('#MsgContainer').html('<h3 class="ok">' + msg + '</h3>');
}