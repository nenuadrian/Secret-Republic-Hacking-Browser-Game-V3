function scrollToElement(id) {
    $('html, body').animate({
        scrollTop: $(id).offset().top
    }, 1000);
}


$(window).load(function() {

    $('.alert-stack').click(function() {
        $(this).fadeOut();
    });
    blinkElement(".jsFlash");

    $(document).keypress(function(e) {
        var tag = e.target.tagName.toLowerCase();
        if (tag != 'input' && tag != 'textarea')
            if (e.which === 77)
                document.location = main_url + 'quests';
            else if (e.which === 71)
            document.location = main_url + 'grid';
        else if (e.which === 83)
            document.location = main_url + 'servers';
        else if (e.which === 65)
            document.location = main_url + 'skills';
        else if (e.which === 79)
            document.location = main_url + 'organization';
        else if (e.which === 74)
            document.location = main_url + 'job';
        else if (e.which === 84)
            document.location = main_url + 'train';
        else if (e.which === 72)
            document.location = main_url;
        else if (e.which === 90)
            document.location = main_url + 'zones';
        else if (e.which === 80)
            document.location = main_url + 'profile';
        else if (e.which === 82)
            document.location = main_url + 'rankings';
    });
    $("input:not([data-no-voice]):not([readonly]):not([type='password']):not([type='submit'])").attr("x-webkit-speech", true);
    $("textarea:not([data-no-voice]):not([readonly])").attr("x-webkit-speech", true);

    if (!mobile) {

        if (!tablet) {
            $('[title][data-placement!="left"]').tooltip({ placement: "top" });
            $('[title]').tooltip({ placement: "left" });
            /* max length counter */
            if ($("input[maxlength], textarea[maxlength]").length !== 0) {
                $.getScript(main_url + "layout/js/bootstrap-maxlength.min.js", function(data, textStatus, jqxhr) {
                    $("input[maxlength]").maxlength({
                        alwaysShow: true,
                        warningClass: "label label-primary",
                        limitReachedClass: "label label-danger ",
                        placement: 'right',
                        message: '%charsTyped%/%charsTotal%'
                    });
                    $("textarea[maxlength]").maxlength({
                        alwaysShow: true,
                        warningClass: "label label-primary",
                        limitReachedClass: "label label-danger",
                        placement: 'bottom',
                        message: 'used %charsTyped% of %charsTotal% chars.'
                    });
                });

            }
        }
    }
    $('img').on('dragstart', function(event) { event.preventDefault(); });


    /* search box hack */
    var searchTimerFocusOut;
    $("#searchField").focusin(function() {
        $("#searchType").fadeIn("slow");
        clearTimeout(searchTimerFocusOut);
    });

    function hideSearchField() {
        $("#searchType").fadeOut("slow");
    }

    $("#searchType").focusin(function() {
        clearTimeout(searchTimerFocusOut);
    });

    $("#searchField").focusout(function() {
        searchTimerFocusOut = setTimeout(hideSearchField, 3000);
    });
    $("#searchType").focusout(function() {
        searchTimerFocusOut = setTimeout(hideSearchField, 3000);
    });



    setTimeout(function() { $("input[autofocus]").blur();
        $("input[autofocus]").focus(); }, 300);


});

function doCheckboxToggle(id) {
    $("#" + id).trigger('click');

    var check = $('#' + id).prop('checked');
    $("#" + id + "_button").text(check ? "ENABLED" : "DISABLED");
    $("#" + id + "_button").css("opacity", check ? 1 : 0.6);

}

function doCheckboxToggle2(id) {
    $("#" + id).trigger('click');

    var check = $('#' + id).prop('checked');
    $("#" + id + "_button").css("opacity", check ? 1 : 0.6);

}

function panelToggling(id, type) {
    current = $(id);
    $(type).each(function() {
        if ($(this).prop("id") != current.prop("id") && $(this).is(":visible"))
            $(this).slideToggle('slow');

    });
    current.slideToggle('slow');
}


function refresh() {
    window.location.href = url;
    location.reload(true);
    window.location.href = location.href + "?" + Date.parse(new Date());

    window.location.replace(url);
    window.location.href = window.location.href;

}
/* Cookies */
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
    }
    return "";
}



function fadeOut(element, f) {
    var op = 1; // initial opacity
    var timer = setInterval(function() {
        if (op < 0.1) {
            clearInterval(timer);
            element.style.display = 'none';
            f();
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ')';
        op -= op * 0.1;
    }, 50);
}

function fadeIn(element, f) {
    var op = 0; // initial opacity

    element.style.display = 'block';
    var timer = setInterval(function() {
        if (op > 0.9) {
            clearInterval(timer);
            f();
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ')';
        op += 0.1;
    }, 50);
}

function toggleFade(element) {
    if (!element.style.display || element.style.display == 'block')
        fadeOut(element, function() {});
    else fadeIn(element, function() {});
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) != -1) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function blinkElement(element, animationTime) {
    if (typeof animationTime === "undefined") animationTime = 2000;

    $(element).fadeToggle(animationTime, 'swing', function() { blinkElement(element, animationTime); });

}



function hideSidebar(element) {
    //$(element).animate({ marginLeft: '-' + $(element).css("width"), opacity:0 }, 400, function(){ $(element).hide();});
    $(element).fadeOut();
    $(".adminIcon, .mobileIcon").fadeIn();

}

function showSidebar(element) {
    //$(element).css("margin-left", 0);
    $(element).fadeIn();
    //$(element).show();
    //$(element).animate({ marginLeft: '0px', opacity:1 }, 700);	

    $(".adminIcon, .mobileIcon").fadeOut();
}

function bodyClick() {
    if ($("#adminNavigation").is(":visible")) {
        hideSidebar("#adminNavigation");
    }
    if ($("#mobileNavigation").is(":visible")) {
        hideSidebar("#mobileNavigation");
    }
}

$(window).load(function() {
    /* if(typeof Android !== 'undefined') 
     {
         Android.showToast("test");
     }	*/
    $('#body').click(bodyClick);
    $(window).on("touchstart", bodyClick);
    $("#adminNavigation, #mobileNavigation").click(function(e) {
        e.stopPropagation();
    });
    $("#adminNavigation, #mobileNavigation").on("touchstart", function(e) {
        e.stopPropagation();
    });

    $(".adminIcon").click(function(e) {
        e.stopPropagation();
        e.preventDefault();
        if ($("#adminNavigation").is(":visible"))
            hideSidebar("#adminNavigation");
        else
            showSidebar("#adminNavigation");

    });

    $(".mobileIcon").click(function(e) {

        e.stopPropagation();
        e.preventDefault();
        if ($("#mobileNavigation").is(":visible"))
            hideSidebar("#mobileNavigation");
        else
            showSidebar("#mobileNavigation");

    });

    $("body").on("swiperight", function() {
        if (!$("#mobileNavigation").is(":visible"))
            showSidebar("#mobileNavigation");
    });

    $("body").on("swipeleft", function() {
        if (!$("#adminNavigation").is(":visible"))
            showSidebar("#adminNavigation");
    });

});


/*********
  HACKER TEXT MINI PLUGIN
 *********/

var hackerText = function(target, message, messageFinal, index, interval) {
    if (index == message.length) return;

    if (index == message.length - 2) {
        $(target).html(messageFinal);
    } else {
        index++;
        $(target).text(message.substring(0, index) + '_');

        setTimeout(function() { hackerText(target, message, messageFinal, index, interval); }, interval);
    }

}

$("[data-hacker-text]").each(function() {
    $(this).text("_");

});


$(window).load(function() {
    $("[data-hacker-text]").each(function() {
        var msgFinal = $(this).attr('data-hacker-text');
        var msg = msgFinal.replace(/(<([^>]+)>)/ig, "");

        hackerText(this, msg, msgFinal, 0, 50);
    });
});