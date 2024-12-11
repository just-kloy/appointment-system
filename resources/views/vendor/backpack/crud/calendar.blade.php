@extends(backpack_view('blank'))

@section('after_styles')
    <!-- Include FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/main.min.css" rel="stylesheet">
    <style>
        #calendar {
            max-width: 1100px;
            margin: 40px auto;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div id="calendar"></div>
    </div>
@endsection

@section('after_scripts')
    <!-- Include FullCalendar JS -->
    <script type='importmap'>
        {
            "imports": {
                "@fullcalendar/core": "https://cdn.skypack.dev/@fullcalendar/core@6.1.15",
                "@fullcalendar/daygrid": "https://cdn.skypack.dev/@fullcalendar/daygrid@6.1.15"
            }
        }
    </script>

    <script type="module">
        import { Calendar } from '@fullcalendar/core';
        import dayGridPlugin from '@fullcalendar/daygrid';

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin],
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                events: function(info, successCallback, failureCallback) {
                    fetch('/admin/calendar-events-json', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Transform events to include start and end schedule
                        const transformedEvents = data.map(event => ({
                            ...event,
                            color: 'blue', // Set event color to blue
                            title: event.title, // Ensure the event title displays properly
                            start: event.start, // Start time from schedule
                            end: event.end // End time from end_schedule
                        }));
                        successCallback(transformedEvents); // Pass the transformed events to FullCalendar
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    });
                },
                editable: true, // Allow dragging and resizing of events
                droppable: false, // Allow external event sources to be dropped
            });

            calendar.render();
        });
    </script>
@endsection
