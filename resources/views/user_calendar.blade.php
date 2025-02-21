<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        header {
            background: linear-gradient(to right, #2E8B57, #006400);
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

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

        #calendar-container {
            max-width: 1100px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .highlight {
            background-color: rgb(0, 255, 55) !important;
            color: black !important;
            font-weight: bold;
            border-radius: 5px;
        }

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
    </style>
</head>
<body>

    <header>Booking Calendar</header>

    <div class="search-container">
        <input type="date" id="searchDate">
        <button onclick="searchByDate()">Search</button>
        <button onclick="resetCalendar()">Show All</button>
    </div>

    <div id="calendar-container">
        <div id="calendar"></div>
    </div>

    <div class="legend-container">
        <div class="legend-item">
            <span class="legend-color" style="background-color: #28a745;"></span> Done
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color: #ffc107;"></span> Pending
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color: #dc3545;"></span> Canceled
        </div>
        <div class="legend-item">
            <span class="legend-color" style="background-color: rgb(78, 53, 220);"></span> Requesting for Cancellation
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var today = new Date().toISOString().split('T')[0];
            let bookings = @json($bookings);
            let calendarEl = document.getElementById('calendar');

            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: bookings,
                selectable: true,
                editable: false,
                eventDidMount: function (info) {
                    var bookingStatus = info.event.extendedProps.status;

                    if (bookingStatus === 'Done') {
                        info.el.style.backgroundColor = '#28a745';
                    } else if (bookingStatus === 'Pending') {
                        info.el.style.backgroundColor = '#ffc107';
                    } else if (bookingStatus === 'Canceled') {
                        info.el.style.backgroundColor = '#dc3545';
                    } else if (bookingStatus === 'Requesting for Cancellation') {
                        info.el.style.backgroundColor = 'rgb(78, 53, 220)';
                    }
                },
                eventClick: function (info) {
                    // Prevent showing booking details for users
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

            calendar.gotoDate(searchDate);

            document.querySelectorAll('.highlight').forEach(el => el.classList.remove('highlight'));

            setTimeout(() => {
                let targetCell = document.querySelector(`[data-date="${searchDate}"]`);
                if (targetCell) {
                    targetCell.classList.add('highlight');
                }
            }, 500);
        }

        function resetCalendar() {
            document.getElementById('searchDate').value = '';
            calendar.gotoDate(new Date());

            document.querySelectorAll('.highlight').forEach(el => el.classList.remove('highlight'));
        }
    </script>

</body>
</html>