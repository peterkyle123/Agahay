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
            margin: 0;
            padding: 0;
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

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #2E8B57;
            border: 2px solid #2E8B57;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            background: #f0f0f0;
        }

        .search-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="date"], button {
            padding: 8px 12px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background: #2E8B57;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background: #006400;
        }

        #calendar-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .legend-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .fc-prev-button, .fc-next-button {
        font-size: 12px !important;
        padding: 4px 6px !important;
        height: auto !important;
        min-width: auto !important;
        background: #2E8B57 !important;
        color: white !important;
        border: 1px solid #2E8B57 !important;
        border-radius: 4px !important;
        margin: 0 4px !important; /* Adds space between the buttons */
        }

        .fc-prev-button:hover, .fc-next-button:hover {
        background: #006400 !important;
        border-color: #006400 !important;
        }

        .fc-today-button {
        font-size: 12px !important;
        padding: 4px 8px !important;
        height: auto !important;
        min-width: auto !important;
        background: #2E8B57 !important;
        color: white !important;
        border: 1px solid #2E8B57 !important;
        border-radius: 4px !important;
        }

    .fc-today-button:hover {
        background: #006400 !important;
        border-color: #006400 !important;
        }


        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                align-items: center;
            }

            input[type="date"], button {
                width: 90%;
            }

            .legend-container {
                max-width: 100%;
                padding: 15px;
            }

            .fc-prev-button, .fc-next-button {
            margin: 0 6px !important; /* Slightly more spacing on smaller screens */
            }
        }
        
    </style>
</head>
<body>

<header>Booking Calendar</header>

<div class="container">
    <div class="button-container">
        <button class="btn" onclick="window.location.href='{{ route('book') }}'">
            <span class="sr-only sm:not-sr-only sm:whitespace-nowrap">
                Back
            </span>
        </button>
    </div>

    <div class="search-container">
        <input type="date" id="searchDate" aria-label="Select a date">
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
