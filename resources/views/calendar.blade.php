<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>

    <!-- FullCalendar Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        /* Header */
        header {
            background: linear-gradient(to right, #2E8B57, #006400);
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Search Bar */
        .search-container {
            text-align: center;
            margin: 20px auto;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        input[type="date"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 12px;
            background: #2E8B57;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #006400;
        }

        /* Calendar Container */
        #calendar-container {
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Highlighted Date */
        .highlight {
            background-color: #FFD700 !important;
            color: black !important;
            font-weight: bold;
        }

        /* Legend */
        .legend-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .small-group { background-color: #4CAF50; } /* Green */
        .vip { background-color: #FFA500; } /* Orange */
        .large-group { background-color: #FF4500; } /* Red */
        .canceled { background-color: #808080; } /* Gray */
        
        .highlight {
             background-color: #FFD700 !important; /* Gold color */
             color: black !important;
             font-weight: bold;
             border-radius: 5px;
}
    </style>
</head>
<body>

    <header>Booking Calendar</header>

    <!-- Search Bar -->
    <div class="search-container">
        <input type="date" id="searchDate">
        <button onclick="searchByDate()">Search</button>
        <button onclick="resetCalendar()">Show All</button>
    </div>

    <div id="calendar-container">
        <div id="calendar"></div>
    </div>

    <!-- Legend -->
    <div class="legend-container">
        <div class="legend-item">
            <span class="legend-color small-group"></span> Small Group Booking
        </div>
        <div class="legend-item">
            <span class="legend-color vip"></span> VIP Booking
        </div>
        <div class="legend-item">
            <span class="legend-color large-group"></span> Large Group Booking
        </div>
        <div class="legend-item">
            <span class="legend-color canceled"></span> Canceled Booking
        </div>
    </div>

    <!-- FullCalendar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

    setTimeout(() => {
        let todayCell = document.querySelector(`[data-date="${today}"]`);
        if (todayCell) {
            todayCell.classList.add('highlight');
        }
    }, 500);
});
        let bookings = @json($bookings);
        let calendar;

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: bookings,
                selectable: true,
                editable: false,
                eventClick: function (info) {
                    alert('Booking: ' + info.event.title);
                },
                eventDidMount: function(info) {
                    var eventType = info.event.extendedProps.type; 

                    if (eventType === 'Small Group') {
                        info.el.style.backgroundColor = '#4CAF50'; // Green
                    } else if (eventType === 'VIP') {
                        info.el.style.backgroundColor = '#FFA500'; // Orange
                    } else if (eventType === 'Large Group') {
                        info.el.style.backgroundColor = '#FF4500'; // Red
                    } else if (eventType === 'Canceled') {
                        info.el.style.backgroundColor = '#808080'; // Gray
                    }
                }
            });

            calendar.render();
        });

        function searchByDate() {
    let searchDate = document.getElementById('searchDate').value;
    if (!searchDate) {
        alert("Please select a date.");
        return;
    }

    // Move calendar to the selected date
    calendar.gotoDate(searchDate);

    // Wait for FullCalendar to update, then highlight the searched date
    setTimeout(() => {
        document.querySelectorAll('.highlight').forEach(el => el.classList.remove('highlight'));

        let targetCell = document.querySelector(`[data-date="${searchDate}"]`);
        if (targetCell) {
            targetCell.classList.add('highlight');
        }
    }, 500);
}

        function resetCalendar() {
            document.getElementById('searchDate').value = '';
            calendar.removeAllEvents();
            calendar.addEventSource(bookings);
            
            // Remove highlights
            document.querySelectorAll('.highlight').forEach(el => el.classList.remove('highlight'));
        }
    </script>

</body>
</html>
