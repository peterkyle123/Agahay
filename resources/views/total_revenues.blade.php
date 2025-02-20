<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Revenues</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white">
    <div class="min-h-screen p-6">
        <header class="bg-gradient-to-r from-green-500 to-green-800 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
            <span class="text-white">Total Revenues</span>
            <div class="flex space-x-4">
                <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                    Home
                </a>
            </div>
        </header>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Revenues from Completed Bookings</h2>

            <p class="text-lg">
                <strong>Total Revenues:</strong> ₱{{ number_format($totalRevenues, 2) }}
            </p>
        </div>
    </div>
</body>
</html>