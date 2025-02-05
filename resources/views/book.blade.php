<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            background: url('{{ asset("images/Green.jpg") }}') no-repeat center center fixed;
            background-size: cover;
        }

        .black {
            color: white;
        }

        /* Header Styling */
        .header {
    background-color: transparent; /* Makes the background invisible */
    color: white;
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: none; /* Removes any shadow */
}

        .header h1 {
            font-size: 24px;
            margin-left: 20px;
        }

        .home-btn {
            background-color: white;
            color: #2e7d32;
            padding: 8px 16px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            margin-right: 20px;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease;
        }

        .home-btn:hover {
            background-color: #e0e0e0;
        }

        .option-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            flex-wrap: wrap;
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

        /* Background images */
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

    <!-- Header Section -->
    <header class="header">
        <h1>Booking Options</h1>
        <a href="/" class="home-btn">Back</a>
    </header>

    <div class="option-container">
        <!-- Small Group Booking -->
        <a href="/booking" class="option option-1">
            <div class="option-text">Small Group Package</div>
            <div class="description-text">
                Enjoy a private stay for 10 guests at Agahay Guesthouse. 
                Rates: ₱6000 (Mon-Thurs) / ₱6500 (Fri-Sun). 
                Includes full house access, free Wi-Fi, billiards, and videoke. 
                Extra guests: ₱75 each. Check-in: 2 PM | Check-out: 12 NN.
            </div>
        </a>

        <!-- VIP Booking -->
        <a href="/booking" class="option option-2">
            <div class="option-text">VIP Booking</div>
            <div class="description-text">
                Experience premium luxury with our VIP package. 
                Private amenities, enhanced comfort, and exclusive services. 
                Contact us for pricing and details.
            </div>
        </a>

        <!-- Large Group Booking -->
        <a href="/booking" class="option option-3">
            <div class="option-text">Large Group Booking</div>
            <div class="description-text">
                Perfect for big gatherings! Accommodates up to 16 guests. 
                Full access to all amenities and discounts for extended stays. 
                Message us for group rates!
            </div>
        </a>
    </div>
 
   

</body>
</html>
