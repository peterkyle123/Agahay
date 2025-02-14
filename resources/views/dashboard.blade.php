<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .custom-bg {
            /* background-image: url('https://www.example.com/your-image.jpg'); */
            background-size: cover;
            background-position: center;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Notification Styles */
        .notification {
            position: absolute;
            top: 20px;
            right: 0;
            background-color: #2e7d32; /* Green notification background */
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
            background: linear-gradient(135deg, #81c784, #388e3c); /* Green gradient background */
        }

        .text-green-800 {
            color: #388e3c; /* Dark green text */
        }

        .bg-gradient-btn {
            background: linear-gradient(135deg, #81c784, #388e3c); /* Button gradient */
        }

        .hover\:bg-gradient-btn:hover {
            background: linear-gradient(135deg, #388e3c, #2e7d32); /* Hover gradient */
        }

        /* Gradient Border */
        .border-gradient {
            border: 4px solid transparent;
            border-image: linear-gradient(135deg, #81c784, #388e3c) 1;
        }

        /* Green Gradient for Notification Popup */
        .notification {
            background-color: #66bb6a; /* Light green notification background */
        }
    </style>
</head>
<body class="bg-green-100">
    <div class="min-h-screen" >
        <!-- Header Section -->
        <div class="fixed top-0 bg-white text-green-800 px-10 py-1 z-10 w-full shadow-md">
            <div class="flex items-center justify-between py-2 text-xl">
                <div class="font-bold text-green-900">Admin<span class="text-green-600">Panel</span></div>
                <div class="flex items-center text-gray-500 float-left w-full">
                   
                </div>
            </div>
        </div>

        <!-- Notification Popup -->
        <script>
    let notificationsEnabled = false; // Initially disabled

    // Enable hover effect only after clicking the notification icon
    document.getElementById('notification-icon').addEventListener('click', function() {
        notificationsEnabled = true; // Allow hover effect after clicking
    });

    // Show notification on hover, only if enabled
    document.getElementById('notification-icon').addEventListener('mouseover', function() {
        if (notificationsEnabled) {
            let popup = document.getElementById('notification-popup');
            popup.classList.add('show');

            // Hide after a few milliseconds
            setTimeout(function() {
                popup.classList.remove('show');
            }, 2000); // Adjust the time as needed (2000ms = 2 seconds)
        }
    });

    // TODO: Implement database connection to fetch real notifications
</script>


        <!-- Main Content Section -->
        <div class="flex flex-row pt-24 px-10 pb-4">
            <!-- Sidebar -->
            <div class="w-2/12 mr-6">
                <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
                    <a href="dashboard" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                        <span class="material-icons-outlined float-left pr-2">dashboard</span> Home
                        <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>
                    <a href="{{ route('packages') }}" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                     <span class="material-icons-outlined float-left pr-2">tune</span> Packages
                    <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>

                    <a href="{{ route('b00kings1') }}" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                        <span class="material-icons-outlined float-left pr-2">file_copy</span>Bookings
                        <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4">
                    <a href="editgallery" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                        <span class="material-icons-outlined float-left pr-2">settings</span> Gallery
                        <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>
                    <a href="reviews" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                        <span class="material-icons-outlined float-left pr-2">inventory_2</span>Reviews
                        <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>

                    <a href="archives" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                        <span class="material-icons-outlined float-left pr-2">archive</span> Archives
                        <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>

                    <a href="adminlogout" class="inline-block text-green-600 hover:text-green-800 my-4 w-full">
                        <span class="material-icons-outlined float-left pr-2">power_settings_new</span> Log out
                        <span class="material-icons-outlined float-right">keyboard_arrow_right</span>
                    </a>

                   
                </div>
            </div>

           <!-- Main Dashboard Content -->
<div class="w-10/12">
    <div class="flex flex-row space-x-6 mb-6"> <!-- Increased spacing between panels -->
  <!-- Welcome Panel -->
<div class="bg-gradient-green border-gradient rounded-xl w-7/12 p-6 card">
    <p class="text-5xl text-green-900">Welcome <br><strong>Admin!</strong></p>
    <span id="time" class="bg-gradient-btn text-xl text-white inline-block rounded-full mt-12 px-8 py-2"><strong>01:51</strong></span>
</div>

<script>
    function updateTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');  // Add leading zero if necessary
        const minutes = now.getMinutes().toString().padStart(2, '0');  // Add leading zero if necessary
        const time = `${hours}:${minutes}`;
        
        document.getElementById('time').innerHTML = `<strong>${time}</strong>`;
    }
    
    setInterval(updateTime, 1000);  // Update every second
    updateTime();  // Initial call to set time immediately
</script>

        <!-- Inbox Panel -->
        <div class="bg-gradient-green border-gradient rounded-xl w-5/12 p-6 card">
            <p class="text-5xl text-green-900">Bookings <br><strong>{{ $bookingCount }}</strong></p>
            <a href="b00kings1" class="bg-gradient-btn text-xl text-white underline hover:bg-gradient-btn inline-block rounded-full mt-12 px-8 py-2"><strong>See bookings</strong></a>
        </div>
    </div>

    <!-- New Revenue and Canceled Bookings Panels -->
    <div class="flex flex-row space-x-6"> <!-- Increased spacing between panels -->
        <!-- Bookings Revenue for This Month -->
        <div class="bg-gradient-green border-gradient rounded-xl w-4/12 p-6 card">
            <p class="text-3xl text-green-900">Bookings Revenue <br><strong>This Month</strong></p>
            <p class="text-xl text-white mt-4">$10,000</p> <!-- This would be dynamic in your real app -->
        </div>

        <!-- Total Revenues -->
        <div class="bg-gradient-green border-gradient rounded-xl w-4/12 p-6 card">
            <p class="text-3xl text-green-900">Total Revenues</p>
            <p class="text-xl text-white mt-4">$150,000</p> <!-- Dynamic data as well -->
        </div>

        <!-- Canceled Bookings -->
        <div class="bg-gradient-green border-gradient rounded-xl w-4/12 p-6 card"> 
    <p class="text-3xl text-green-900">Cancelled <br><strong>Bookings</strong></p>
    <p class="text-xl text-white mt-4">{{ $canceledBookingsCount }}</p> <!-- Displays actual canceled bookings count -->
        </div>
    </div>
</div>

    <!-- Optional JavaScript -->
    <script>
        // Show notification popup when clicking on the notification icon
        document.getElementById('notification-icon').addEventListener('click', function() {
            let popup = document.getElementById('notification-popup');
            popup.classList.toggle('show');
        });
    </script>
</body>
</html>
