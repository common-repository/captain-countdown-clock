(function($){

    $(function(){

        $('.captain-countdown-timer').each(function(){
           captainCountdownTimer($(this), 0);
        });

        $('#captain-countdown-settings-submit').click(function(e){
            e.preventDefault();
            var over_under = $('#captain_countdown_over_under').val();
            var sign = (over_under == 'under') ? '-' : '';
            var years = $('#captain_countdown_years').val();
            var days = $('#captain_countdown_days').val();
            var hours = $('#captain_countdown_hours').val();
            var minutes = $('#captain_countdown_minutes').val();
            var seconds = $('#captain_countdown_seconds').val();
            var offsets =
                sign + years.toString() + '|' +
                sign + days.toString() + '|' +
                sign + hours.toString() + '|' +
                sign + minutes.toString() + '|' +
                sign + seconds.toString();
            $('#captain-countdown-offset').val(offsets);
            $('#captain-countdown-settings-form').submit();
        });

    });

})(jQuery);

function captainCountdownTimer(element, increment){

    jQuery('.timerSupport').each(function(){
        jQuery(this).css('display', 'none');
    });

    var datetime = element.data('datetime');
    var direction = element.data('direction');

    datetime = moment(datetime).add(increment, 'seconds');

    if (direction == 'down') {

        var target = moment(element.data('target'));
        var balance = target.diff(datetime, 'seconds');

        var years = Math.floor(balance / 31536000);
        var days = Math.floor((balance % 31536000) / 86400);
        var hours = Math.floor(((balance % 31536000) % 86400) / 3600);
        var minutes = Math.floor((((balance % 31536000) % 86400) % 3600) / 60);
        var seconds = (((balance % 31536000) % 86400) % 3600) % 60;

        if (years+days+hours+minutes+seconds <= 0) {
            element.closest('.captain-countdown-container').hide();
            return;
        }

        var ccy = element.find('.captain-countdown-years');
        var ccd = element.find('.captain-countdown-days');
        var cct = element.find('.captain-countdown-time');

        if (years <= 0) {
           ccy.hide();
        } else {
            ccy.text(years+' ');
            if (years == 1) {
                ccy.append(ccy.data('singular'));
            } else {
                ccy.append(ccy.data('plural'));
            }
            ccy.append('<br>');
        }

        if (days <= 0 && years <= 0) {
            ccd.hide();
        } else {
            if (days > 0) {
                ccd.text(days + ' ');
                if (days == 1) {
                    ccd.append(ccd.data('singular'));
                } else {
                    ccd.append(ccd.data('plural'));
                }
                ccd.append('<br>');
            }
        }

        cct.text('');
        if (hours <= 9) {
            cct.append('0');
        }
        cct.append(hours+':');
        if (minutes <= 9) {
            cct.append('0');
        }
        cct.append(minutes+':');
        if (seconds <= 9) {
            cct.append('0');
        }
        cct.append(seconds);

    } else {

        element.text(datetime.format('MMMM D, YYYY h:mm:ss a'));
    }

    element.data('datetime', datetime.format('YYYY-MM-DD HH:mm:ss'));

    setTimeout(function(){
        captainCountdownTimer(element, 1);
    }, 1000);
}