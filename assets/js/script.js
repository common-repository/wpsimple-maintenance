// countdown script
var finalCountdown = jQuery.noConflict();
finalCountdown(document).ready(function() {
     'use strict';
    var option_start_time   = finalCountdown('#maintenancecountdownstart').html();
    var option_end_time     = finalCountdown('#maintenancecountdownend').html();
    var parse_start_time    = Date.parse(option_start_time)/1000;
    var parse_end_time      = Date.parse(option_end_time)/1000;
    var now                 = new Date().getTime() / 1000;
    finalCountdown('.countdown').final_countdown({
        start: parse_start_time,
        end: parse_end_time,
        now: now,
        seconds: {
            borderColor: 'red',
            borderWidth: '6'
        },
        minutes: {
            borderColor: '#ACC742',
            borderWidth: '6'
        },
        hours: {
            borderColor: '#ECEFCB',
            borderWidth: '6'
        },
        days: {
            borderColor: '#FF9900',
            borderWidth: '6'
        }
    }, 
    function() {
    // Finish callback
    });
});

