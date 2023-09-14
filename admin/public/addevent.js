$(document).ready(function () {
    var SITEURL = window.location.origin;

  
    var calendar = $('#calendar').fullCalendar({
        editable: true,
        events: SITEURL + "/fullcalender",
        displayEventTime: false,
        selectable: true,
        selectHelper: true,
        select: function (start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
                var start = $.fullCalendar.formatDate(start, "YYYY-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(end, "YYYY-MM-DD HH:mm:ss");
                $.ajax({
                    url: SITEURL + "/fullcalenderAjax",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        type: 'add'
                    },
                    type: "POST",
                    success: function (response) {
                        toastr.success('일정이 추가되었습니다.', '일정 추가');
                        calendar.fullCalendar('refetchEvents');
                    }
                });
            }
        },
        //...
    });
});
