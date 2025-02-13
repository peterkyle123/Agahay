<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            background: url('{{ asset("images/GR.jpg") }}') no-repeat center center fixed;
            background-size: cover;
        }

        .black {
            color: white;
        }

        .option-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            flex-wrap: nowrap;
            margin-top: 20px;
        }

        .option {
            width: 400px;
            height: 400px;
            color: white;
            border-radius: 15px;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-bottom: 20px;
            background-size: cover;
            background-position: center;
            text-decoration: none;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .option:hover {
            transform: scale(1.05);
        }

        .option img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .option-text {
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.6);
        }

        .description-text {
            padding: 20px;
            font-size: 14px;
            font-weight: normal;
            text-align: justify;
            background: rgba(0, 0, 0, 0.6);
        }

        .edit-btn-container {
            display: flex;
            justify-content: center; /* Center the button horizontally */
            margin-top: 10px;
        }

        .edit-btn {
            width: 100px;  /* Shorter width for the border */
            padding: 6px 0;  /* Reduced padding */
            text-align: center;
            background-color: green;
            color: white;
            border: 2px solid black;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
        }

        .option-1 {
            background-image: url('{{ asset("images/8.jpg") }}');
        }

        .option-2 {
            background-image: url('{{ asset("images/VIP.jpg") }}');
        }

        .option-3 {
            background-image: url('{{ asset("images/16 pax.jpg") }}');
        }
    </style>
</head>
<body>

    <h1 class="black">Booking Options</h1>

    <div class="option-container">
        <!-- Small Group Booking -->
        <div class="option option-1">
            <div class="option-text">Small Group Package</div>
            <div class="description-text">
                Enjoy a private stay for 10 guests at Agahay Guesthouse. 
                Rates: ₱6000 (Mon-Thurs) / ₱6500 (Fri-Sun). 
                Includes full house access, free Wi-Fi, billiards, and videoke. 
                Extra guests: ₱75 each. Check-in: 2 PM | Check-out: 12 NN.
            </div>
            <!-- Edit Button -->
            <div class="edit-btn-container">
                <a href="/editpackages" class="edit-btn">Edit</a>
            </div>
        </div>

        <!-- VIP Booking -->
        <div class="option option-2">
            <div class="option-text">VIP Booking</div>
            <div class="description-text">
                Experience premium luxury with our VIP package. 
                Private amenities, enhanced comfort, and exclusive services. 
                Contact us for pricing and details.
            </div>
            <!-- Edit Button -->
            <div class="edit-btn-container">
                <a href="/editpackages" class="edit-btn">Edit</a>
            </div>
        </div>

        <!-- Large Group Booking -->
        <div class="option option-3">
            <div class="option-text">Large Group Booking</div>
            <div class="description-text">
                Perfect for big gatherings! Accommodates up to 16 guests. 
                Full access to all amenities and discounts for extended stays. 
                Message us for group rates!
            </div>
            <!-- Edit Button -->
            <div class="edit-btn-container">
                <a href="/editpackages" class="edit-btn">Edit</a>
            </div>
        </div>
    </div>

</body>
</html>
