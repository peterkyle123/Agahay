<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            background-image: url('{{asset('images/8.jpg')}}');
            background-size: cover;
            background-position: center;
            overflow-y: auto;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 900px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 120px;
        }

        .form-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        .input-container {
            width: 48%;
            margin-bottom: 15px;
        }

        .input-field, textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
            text-align: left;
        }

        .submit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .full-width {
            width: 100%;
        }

        /* Success message styling */
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 12px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 900px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                align-items: center;
            }

            .input-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="absolute top-4 left-4 flex space-x-4">
    <button class="bg-gradient-to-r from-green-500 to-green-700 text-white text-xl md:text-2xl font-medium px-3 md:px-4 py-2 rounded shadow">
        <a href="/">Home</a>
    </button>
    <button class="bg-gradient-to-r from-green-500 to-green-700 text-white text-xl md:text-2xl font-medium px-3 md:px-4 py-2 rounded shadow">
        <a href="{{ route('book') }}">Back</a>
    </button>
</div>

<!-- Position the success message at the top -->


<form action="/bookform" method="POST">
    @csrf

    <div class="form-container">
        <h1 class="form-title">Booking Form</h1>
        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        <div id="error-message" class="error-message"></div>
        <div class="input-container">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="customer_name" required class="input-field" placeholder="Enter your full name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
        </div>

        <div class="input-container">
            <label for="checkin">Check-in Date</label>
            <input type="date" id="checkin" name="check_in_date" required class="input-field">
        </div>
        <div class="input-container">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required class="input-field" placeholder="Enter your phone number" pattern="^\d{11}$" maxlength="11" title="Phone number must be exactly 11 digits">
        </div>

        <div class="input-container">
            <label for="checkout">Check-out Date</label>
            <input type="date" id="checkout" name="check_out_date" required class="input-field">
        </div>
        
     

        <div class="input-container">
    <label for="extra_pax">Extra Pax</label>
    <input type="number" id="extra_pax" name="extra_pax" required class="input-field" placeholder="Extra Pax?" min="0" step="1">
</div>

        <div class="input-container full-width">
            <label for="special_requests">Special Requests</label>
            <textarea id="special_requests" name="special_request" class="input-field" placeholder="Any special requests?" rows="4"></textarea>

        </div>
       @if(session('tracking_code'))
    <div id="tracking-code-alert" class="tracking-code-alert">
        <strong>Screenshot or save Your Tracking Code: </strong>{{ session('tracking_code') }}
    </div>
@endif


    <script>
        // JavaScript to hide the tracking code alert after a short delay
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('tracking-code-alert').style.display = 'none';
            }, 7000); // Hides the alert after 7 seconds
        };
    </script>

    <style>
        /* Overlay filter effect */
        .tracking-code-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 15px 20px;
            background: rgba(0, 255, 55, 0.8); /* Red transparent background */
            color: white; /* Ensure text is readable */
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        /* Full-screen background filter */
        body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1; /* Ensure it stays behind the form */
}

    </style>
    <script>
    // Get the check-in and check-out date inputs
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');

    // Set the minimum check-out date to be the selected check-in date
    checkinInput.addEventListener('change', function() {
        const checkinDate = checkinInput.value;
        checkoutInput.setAttribute('min', checkinDate);
        
        // Optionally, if the user selects a check-in date that is later than the current check-out date, adjust the check-out date
        if (checkoutInput.value && checkoutInput.value < checkinDate) {
            checkoutInput.value = checkinDate;
        }
    });
</script>


        <button class="bg-gradient-to-r from-green-500 to-green-700 submit-btn full-width" type="submit">Submit Booking</button>
   
    </div>
</form>

</body>
</html>
