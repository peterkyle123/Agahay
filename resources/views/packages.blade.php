<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
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
        .price-text {
            font-size: 18px;
            font-weight: bold;
            color: #27ae60; /* Green color for pricing */
            white-space: nowrap; /* Prevents price from wrapping */
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
            background-image: url('{{ asset("images/VIP.jpg") }}');
        }

        .option-2 {
            background-image: url('{{ asset("images/VIP.jpg") }}');
        }

        .option-3 {
            background-image: url('{{ asset("images/16 pax.jpg") }}');
        }
    </style>
</head>
<body class="white">
            <!-- Header -->
 <!-- Header -->
 <header class="bg-white dark:bg-gray-900 h-20 w-full flex items-center fixed top-0 left-0 z-50 shadow-md">
    <nav class="flex justify-start space-x-8 ml-6">

        <a href="#" onclick="window.history.back(); return false;" class="text-green-600 hover:text-green-900 text-s">Back</a>
        <a href="/dashboard" class="text-green-600 hover:text-green-900 text-s">Home</a>
        <a href="/packages" class="text-green-600 hover:text-green-900 text-s">Packages</a>
        {{-- drop down for bookings --}}
        <div class="relative" x-data="{ open: false }">
            <button class="text-green-600 hover:text-green-900 text-s"
                @click="open = !open">
                Bookings ▼
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute mt-2 w-48 bg-white border rounded-lg shadow-lg z-50">
                <a href="/approved-bookings"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Approved</a>
                <a href="/approvedCanceled"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Canceled</a>
                <a href="/archives"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Done</a>
                <a href="/cancelrequestA"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Requesting for Cancellation</a>
            </div>
        </div>

        <!-- Dropdown for Revenues -->
        <div class="relative" x-data="{ open: false }">
            <button class="text-green-600 hover:text-green-900 text-s"
                @click="open = !open">
                Revenues ▼
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute mt-2 w-48 bg-white border rounded-lg shadow-lg z-50">
                <a href="/total-revenues"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Done Revenues</a>
                <a href="/approvedCanceled"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Canceled Revenues</a>
            </div>
        </div>

        <a href="/adminlogout" class="text-green-600 hover:text-green-900 text-s">Logout</a>
    </nav>
</header>
    <div class="option-container">
        <!-- Small Group Booking -->
        @foreach ($packages as $package)
        <div class="option option-{{ $loop->index + 1 }} mt-24"
             style="background-image: url('{{ asset($package->image) }}');">

        <div class="option-text">{{ $package->package_name }}</div>

        <div class="description-container">
                <div class="description-text">
            {{ $package->description }}
        </div>
        <div class="price-text">
                 ₱{{ number_format($package->price, 2) }}
        </div>
     </div>

        <div class="edit-btn-container">
                    <a href="{{ url('/editpackages/' . $package->package_id) }}" class="edit-btn">Edit</a>
        </div>
</div>
    @endforeach

    </div>

</body>
</html>
