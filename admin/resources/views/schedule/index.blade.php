<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8' />
        <script src="/dist/index.global.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    height: '100%',
                    expandRows: true,
                    slotMinTime: '08:00',
                    slotMaxTime: '20:00',
                    headerToolbar: {
                        left: 'prev,next today,addEventButton',
                        center: 'title',
                        right:
                            'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    },
                    initialView: 'dayGridMonth',
                    initialDate: new Date(),
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    selectable: true,
                    nowIndicator: true,
                    dayMaxEvents: true,
                    events: function (fetchInfo, successCallback, failureCallback) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', '/api/get-events');
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                const events = JSON.parse(xhr.responseText);
                                const parsedEvents = events.map((event) => ({
                                    title: event.title,
                                    start: new Date(event.start),
                                    end: new Date(event.end),
                                }));
                                successCallback(parsedEvents);
                            } else {
                                failureCallback();
                            }
                        };
                        xhr.send();
                    },
                    customButtons: {
                        addEventButton: {
                            text: '일정 추가',
                            click: function () {
                                window.location.href = '/add-event';
                            },
                        },
                    },
                });
                calendar.render();
            });
        </script>
        <style>
            html,
            body {
                overflow: hidden; /* don't do scrollbars */
                font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
                font-size: 14px;
            }

            #calendar-container {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
            }

            .fc-header-toolbar {
                /*
    the calendar will be butting up against the edges,
    but let's scoot in the header's buttons
    */
                padding-top: 1em;
                padding-left: 1em;
                padding-right: 1em;
            }
        </style>
    </head>
    <body>
        <div id='calendar-container'>
            <div id='calendar'></div>
        </div>
    </body>
</html>
