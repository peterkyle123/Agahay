<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
   </head>
<body>
    <div class="bg-green-900 text-white p-4 sm:p-6 shadow-md w-full">
        <div class="flex flex-wrap items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-semibold">Track Your Booking</h1>
            <div class="flex items-center mt-2 sm:mt-0">
                <a href="/" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
                    Home
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2>Enter Your Booking Code</h2>
        
        <!-- Track Booking Form -->
        <form action="{{ route('trackbooking') }}" method="POST">
            @csrf
            <input type="text" name="tracking_code" id="bookingCode" placeholder="E.g., BKABC123" value="{{ old('tracking_code') }}" required>
            <button class="search-btn" type="submit">Search</button>
        </form>

        <!-- Display Errors -->
        @error('tracking_code')
            <div class="error-message">{{ $message }}</div>
        @enderror

         <!-- Display Results -->
         @if(isset($booking))
            <div class="booking-details" id="bookingDetails">
                <p><strong>Booking Code:</strong> {{ $booking->tracking_code }}</p>
                <p><strong>Guest Name:</strong> {{ $booking->customer_name }}</p>
                <p><strong>Check-in:</strong> {{ $booking->check_in_date }}</p>
                <p><strong>Check-out:</strong> {{ $booking->check_out_date }}</p>
                <p><strong>Status:</strong> {{ $booking->status }}</p>
                <button onclick="cancelBooking({{ $booking->id }})" class="cancel-btn">Cancel Booking</button>

            </div>

            <script>
                // Hide booking details after 5 seconds (5000ms)
                setTimeout(function() {
                    document.getElementById('bookingDetails').style.display = 'none';
                }, 5000); // 5000ms = 5 seconds
            </script>
        @elseif(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
    </div>
    <script>
    function cancelBooking(bookingId) {
        const confirmCancel = confirm("Are you sure you want to cancel this booking?");
        if (confirmCancel) {
            // Send the cancel request to the server via AJAX
            fetch(`/cancel-booking/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    _method: 'POST',  // Use the POST method for the route
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("bookingResult").innerHTML = "<p class='success-message'>Your booking has been canceled.</p>";
                    setTimeout(function() {
                        document.getElementById('bookingDetails').style.display = 'none';
                    }, 5000);
                } else {
                    document.getElementById("bookingResult").innerHTML = "<p class='error-message'>Failed to cancel the booking. Please try again.</p>";
                }
            })
            .catch(error => {
                document.getElementById("bookingResult").innerHTML = "<p class='error-message'>An error occurred. Please try again later.</p>";
            });
        }
    }
</script>

</body>
</html>