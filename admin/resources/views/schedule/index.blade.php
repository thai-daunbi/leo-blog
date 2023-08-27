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
                        xhr.open('GET', '/api/get-events?start=' + encodeURIComponent(fetchInfo.startStr) + '&end=' + encodeURIComponent(fetchInfo.endStr));
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                const events = JSON.parse(xhr.responseText);
                                const parsedEvents = events.map((event) => ({
                                    title: event.title,
                                    start: new Date(event.start),
                                    end: new Date(event.end),
                                    id: event.id // Add this line
                                }));
                                successCallback(parsedEvents);
                            } else {
                                failureCallback();
                            }
                        };
                        xhr.send();
                    },
                    eventDidMount: function (info) {
                        const button = document.createElement('button');
                        button.innerText = 'Edit';
                        button.addEventListener('click', function () {
                            window.location.href = '/edit-schedule/' + info.event.id; // Edit this line
                        });

                        info.el.appendChild(button);
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
                

                function updateEventStatus(event, status) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/api/update-event-status');
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    
                    const data = JSON.stringify({
                        event_id: event.id,
                        status: status
                    });
                    
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            console.log('Event status updated successfully.');
                        } else {
                            console.error('Failed to update event status.');
                        }
                    };
                    
                    xhr.send(data);
                }
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
                padding-top: 1em;
                padding-left: 1em;
                padding-right: 1em;
            }

            .checkbox-container {
                display: flex;
                align-items: center;
            }

            .event-checkbox {
                margin-right: 5px;
            }

        </style>
    </head>
    <body>
        <div id='calendar-container'>
            <div id='calendar'></div>
        </div>
    </body>
</html>

