<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .custom-bg {
            /* background-image: url('https://www.example.com/your-image.jpg'); */
            background-size: cover;
            background-position: center;
        }

        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 24px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Notification Styles */
        .notification {
            position: absolute;
            top: 20px;
            right: 0;
            background-color: #66bb6a;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            display: none;
            z-index: 100;
        }

        .notification.show {
            display: block;
        }

        /* Gradient Green theme */
        .bg-gradient-green {
            background: linear-gradient(135deg, #81c784, #388e3c);
        }

        .text-green-800 {
            color: #388e3c;
        }

        .bg-gradient-btn {
            background: linear-gradient(135deg, #81c784, #388e3c);
        }

        .hover\:bg-gradient-btn:hover {
            background: linear-gradient(135deg, #388e3c, #2e7d32);
        }

        /* Gradient Border */
        .border-gradient {
            border: 1px solid transparent;
            border-image: linear-gradient(135deg, #81c784, #388e3c) 1;
        }

        /* Green Gradient for Notification Popup */
        .notification {
            background-color: #66bb6a;
        }

        /* Main Heading Style */
        h1, h2, h3 {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Enhanced Spacing */
        .section-heading {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .section-content {
            font-size: 1rem;
            line-height: 1.6;
        }

        .panel {
            margin-bottom: 20px;
        }

        /* Sidebar and Main Content Adjustments */
        .sidebar-item {
            padding: 12px;
            font-size: 1.1rem;
            line-height: 1.8;
            display: block;
            text-decoration: none;
            color: #388e3c;
            transition: color 0.3s ease;
        }

        .sidebar-item:hover {
            color: #2e7d32;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #fff;
            padding: 16px 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .navbar .text {
            font-size: 1rem;
            color: #888;
        }

        .btn-main {
            font-size: 1.125rem;
            padding: 10px 20px;
            border-radius: 24px;
            font-weight: 500;
            background: linear-gradient(135deg, #81c784, #388e3c);
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }

        .btn-main:hover {
            background: linear-gradient(135deg, #388e3c, #2e7d32);
        }
    </style>
</head>

<body class="white">
    <div class="min-h-screen">
        <!-- Header Section -->
        <div class="fixed top-0 bg-white text-green-800 px-10 py-1 z-10 w-full shadow-md navbar">
            <div class="flex items-center justify-between py-2 text-xl">
                <div class="font-bold text-green-900 logo">Aga<span class="text-green-600">hay</span></div>
                <div class="text-gray-500 text-sm text-right">
                    <!-- User Info or Notifications -->
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="flex flex-row pt-24 px-10 pb-4">
            <!-- Sidebar -->
            <div class="w-2/12 mr-6">
                <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
                    <a href="dashboard" class="sidebar-item">Home</a>
                    <a href="{{ route('packages') }}" class="sidebar-item">Packages</a>
                    <a href="{{ route('b00kings1') }}" class="sidebar-item">Bookings</a>
                </div>

                <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
                    <a href="editgallery" class="sidebar-item">Gallery</a>
                    <a href="reviews" class="sidebar-item">Reviews</a>
                    <a href="archives" class="sidebar-item">Archives</a>
                    <a href="calendar" class="sidebar-item">Calendar</a>
                    <a href="payment_methods" class="sidebar-item">Payment Methods</a>
                    <a href="adminlogout" class="sidebar-item">Log out</a>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="w-10/12">
                <div class="flex flex-row space-x-6 mb-6">
                    <!-- Welcome Panel -->
                    <div class="bg-white border-gradient rounded-xl w-7/12 p-6 card">
                        <p class="text-4xl text-green-900">Welcome <br><strong>Admin!</strong></p>
                        <span id="time" class="bg-white-btn text-xl text-white inline-block rounded-full mt-12 px-8 py-2">
                            <strong>01:51</strong>
                        </span>
                    </div>

                    <!-- Inbox Panel -->
                    <div class="bg-white border-gradient rounded-xl w-5/12 p-6 card">
                        <p class="text-4xl text-green-900">Bookings</p>
                        <a href="b00kings1" class="btn-main mt-12">See bookings</a>
                    </div>
                </div>

                <!-- New Revenue and Canceled Bookings Panels -->
                <div class="flex flex-row space-x-6">
                    <!-- Bookings Revenue for This Month -->
                    <div class="bg-white border-gradient rounded-xl w-4/12 p-6 card">
                        <p class="text-3xl text-green-900">Canceled Revenues <br><strong>Initial Downpayment</strong></p>
                        <p class="text-xl text-white mt-4"></p>
                    </div>

                    <!-- Total Revenues -->
                    <div class="bg-white border-gradient rounded-xl w-4/12 p-6 card">
                        <p class="text-3xl text-green-900">Done Revenues</p>
                        <a href="total-revenues" class="btn-main mt-12">Revenues</a>
                        <p class="text-xl text-white mt-4"></p>
                    </div>

                    <!-- Canceled Bookings -->
                    <div class="bg-white border-gradient rounded-xl w-4/12 p-6 card">
                        <p class="text-3xl text-green-900">Cancelled <br><strong>Bookings</strong></p>
                        <a href="cancelrequestA" class="btn-main mt-12">Cancellation Requests</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script>
        function updateTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const time = `${hours}:${minutes}`;

            document.getElementById('time').innerHTML = `<strong>${time}</strong>`;
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>

</html>
