

@section('content')
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="active"><a href="{{ route('home')}}" class="float-right">Blog</a></li>
                        <li class="active"><a href="{{ url('/schedule') }}" class="float-right">Schedule</a></li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
@endsection

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
                        left: 'prev,next today',
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
                                    id: event.id,
                                    button1: event.button1,
                                    button2: event.button2,
                                    students: event.students // Add students data to the event
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
                        button.innerText = '+';
                        button.addEventListener('click', function () {
                            window.location.href = '/edit-schedule/' + info.event.id;
                        });

                        const students = info.event.extendedProps.students; // 학생 정보 가져오기

                        const studentsLabel = document.createElement('div');
                        studentsLabel.innerText = students.join(', '); // 학생 이름을 쉼표로 구분하여 표시

                        const containerDiv = document.createElement('div');

                        containerDiv.appendChild(button);
                        containerDiv.appendChild(studentsLabel); // 학생 정보 엘리먼트 추가

                        if (info.event.extendedProps.button1 === 1) {
                            const button1Container = document.createElement('div');
                            button1Container.appendChild(button1Label);
                            containerDiv.appendChild(button1Container);
                            containerDiv.appendChild(document.createTextNode(" "));
                        }

                        if (info.event.extendedProps.button2 === 1) {
                            const button2Container = document.createElement('div');
                            button2Container.appendChild(button2Label);
                            containerDiv.appendChild(button2Container);
                        }
                        info.el.appendChild(containerDiv);
                    },

                    customButtons: {
                        listButton: {
                            text: 'List',
                            click: function () {
                                fetchEvents(); 
                            }
                        }
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

                function fetchEvents() { 
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
                                id: event.id,
                                button1: event.button1,
                
                            }));
                            calendar.removeAllEvents(); // Remove existing events
                            calendar.addEventSource(parsedEvents); // Add parsedEvents
                        } else {
                            console.error('Failed to fetch events.');
                        }
                    };
                    
                    xhr.send();
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

