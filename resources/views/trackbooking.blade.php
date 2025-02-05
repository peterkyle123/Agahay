<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Booking | Agahay Guesthouse</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0fdf4; /* Light green background */
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background: #2e8b57; /* Dark green header */
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white; /* White background for content */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 80%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 16px;
            text-align: center;
        }

        button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-btn {
            background: #228b22;
            color: white;
        }

        .search-btn:hover {
            background: #1c7d1c;
        }

        .cancel-btn {
            background: red;
            color: white;
            margin-top: 10px;
        }

        .cancel-btn:hover {
            background: darkred;
        }

        .booking-details {
            background: #f0fdf4; /* Light green background for details */
            color: #333;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: left;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
        function searchBooking() {
            const bookingCode = document.getElementById("bookingCode").value.trim();
            const resultSection = document.getElementById("bookingResult");

            if (bookingCode === "") {
                resultSection.innerHTML = "<p class='error-message'>Please enter a booking code.</p>";
                return;
            }

            // Simulated booking lookup
            if (bookingCode === "ABC123") {
                resultSection.innerHTML = `
                    <div class="booking-details">
                        <p><strong>Booking Code:</strong> ABC123</p>
                        <p><strong>Guest Name:</strong> John Doe</p>
                        <p><strong>Check-in:</strong> February 10, 2025</p>
                        <p><strong>Check-out:</strong> February 12, 2025</p>
                        <p><strong>Status:</strong> Confirmed</p>
                        <button class="cancel-btn" onclick="cancelBooking()">Cancel Booking</button>
                    </div>
                `;
            } else {
                resultSection.innerHTML = "<p class='error-message'>No booking found for this code.</p>";
            }
        }

        function cancelBooking() {
            const confirmCancel = confirm("Are you sure you want to cancel this booking?");
            if (confirmCancel) {
                document.getElementById("bookingResult").innerHTML = "<p class='error-message'>Your booking has been canceled.</p>";
            }
        }
    </script>
</head>
<body>
<div class="bg-green-900 text-white p-4 sm:p-6 shadow-md w-full">
        <div class="flex flex-wrap items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-semibold">Track Your Booking</h1>
            <div class="flex items-center mt-2 sm:mt-0">
                <!-- Home Button -->
                <a href="/" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
                    Home
                </a>
            </div>
        </div>
    </div>

    
    <div class="container">
        <h2>Enter Your Booking Code</h2>
        <input type="text" id="bookingCode" placeholder="E.g., ABC123">
        <button class="search-btn" onclick="searchBooking()">Search</button>

        <div id="bookingResult"></div>
    </div>
</body>
</html>
