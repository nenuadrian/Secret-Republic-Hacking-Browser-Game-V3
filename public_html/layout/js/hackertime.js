/* live time */

function check_time() {
    $.ajax({
        type: "POST",
        url: main_url + "api.php",
        data: { time: true },
        dataType: "json",
        success: function(data) {
            if (data.time) {
                $(".hackerTime").html(data.time);
            }
        }
    });
    setTimeout('check_time()', 5000);
}



$(document).ready(function() {

    // show live time
    if ($(".hackerTime").length)
        setTimeout('check_time()', 100);


});