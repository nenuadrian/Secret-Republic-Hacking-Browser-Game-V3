/*
  Countdown jQuery plugin for TSR
  
  Created by Nenu Adrian Mircea (http://nenuadrian.com) 
*/

var Hackdown = function(options) {
    this.updateTime = function(remainingSeconds, newTotalSeconds) {

        leftSeconds = remainingSeconds;
        totalSeconds = newTotalSeconds;
        onePercent = totalSeconds / 100;
    };
    // Draw digits in given container
    var countdown = function() {
        leftSeconds--;
        seconds = leftSeconds;

        if (options.textCountdown)
            if ($("" + options.textElement).length) {
                if (leftSeconds <= 0) {

                    var string = options.textFinish ? options.textFinish + ". " : " ";
                    string += options.reloadOnFinish ? ". Reloading in " + options.reloadAfterXSeconds + " seconds" : "";

                } else {
                    var days = parseInt(seconds / day);
                    seconds -= days * day;

                    var hours = parseInt(seconds / hour);
                    seconds -= hours * hour;
                    var minutes = parseInt(seconds / 60);
                    seconds -= minutes * 60;

                    var string = days ? days + ":" : "";
                    string += (hours <= 9 ? "0" : "") + hours + ":";
                    string += (minutes <= 9 ? "0" : "") + minutes + ":";
                    string += (seconds <= 9 ? "0" : "") + seconds;
                }
                $("" + options.textElement).html(string);
            } // if text label
        if (options.progressBarCountdown)
            if ($("" + options.progressBarElement).length) {
                var width = (100 - leftSeconds / onePercent) + "%";
                $("" + options.progressBarElement).css("width", width);
            } // if progress bar

        if (leftSeconds <= 0) {
            clearInterval(interval);
            if (options.reloadOnFinish)
                setTimeout(function() { location.reload(true); }, options.reloadAfterXSeconds * 1000);

            options.callOnFinish();
        }
    };

    var stringToSeconds = function(string) {
        var data = ("" + string).split(':');

        return (parseInt(data[3]) || 0) * 24 * 60 * 60 +
            (parseInt(data[2]) || 0) * 60 * 60 +
            (parseInt(data[1]) || 0) * 60 +
            (parseInt(data[0]) || 0);
    };

    var leftSeconds = stringToSeconds(options.countdownFrom);

    var totalSeconds = stringToSeconds(options.totalCountdown);



    var onePercent = totalSeconds / 100;

    var hour = 60 * 60;
    var day = 24 * hour;

    countdown();
    var interval = setInterval(countdown, 1000);
};


jQuery.fn.hackdown = function(userOptions) {
    // Default options
    var options = {
        countdownFrom: "01:01:01:01",
        totalCountdown: "00:01:01:01",
        textCountdown: true,
        textElement: "#hackdown",
        textFinish: "Finished",
        progressBarCountdown: false,
        progressBarElement: "#hackdownProgressBar",
        reloadOnFinish: true,
        reloadAfterXSeconds: 5,
        callOnFinish: function() { console.log("Task finished"); },
    };


    $.extend(options, userOptions);

    return this.each(function() {
        var element = $(this);

        // Return early if this element already has a plugin instance
        if (element.data('hackdown')) { element.data("hackdown").updateTime(0, 0);
            element.removeData('hackdown'); }


        var hackdown = new Hackdown(options);
        element.data('hackdown', hackdown);


    });






};