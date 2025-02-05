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

        <div id="error-message" class="error-message"></div>
    <div class="form-container">
        <h1 class="form-title">Booking Form</h1>

        <div class="input-container">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required class="input-field" placeholder="Enter your full name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
        </div>

        <div class="input-container">
            <label for="email">Email Address (Optional)</label>
            <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email">
        </div>

        <div class="input-container">
            <label for="checkin">Check-in Date</label>
            <input type="date" id="checkin" name="checkin" required class="input-field">
        </div>
        
        <div class="input-container">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required class="input-field" placeholder="Enter your phone number" pattern="^\d{11}$" maxlength="11" title="Phone number must be exactly 11 digits">
        </div>

        <div class="input-container">
            <label for="checkout">Check-out Date</label>
            <input type="date" id="checkout" name="checkout" required class="input-field">
        </div>

        <div class="input-container">
            <label for="message">Extra Pax</label>
            <input type="number" id="message" name="message" required class="input-field" placeholder="Extra Pax?">
        </div>

        <div class="input-container full-width">
            <label for="special-requests">Special Requests</label>
            <textarea id="special-requests" name="special-requests" class="input-field" placeholder="Any special requests?" rows="4"></textarea>
        </div>

        <button class="bg-gradient-to-r from-green-500 to-green-700  submit-btn full-width" type="submit">Submit Booking</button>
    </div>

</body>
</html>
