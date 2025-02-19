<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cancelRequest</title>
</head>
<body>
@vite('resources/css/app.css')
@vite('resources/js/app.js') 


<div class="min-h-screen p-6">
    <header class="bg-gradient-to-r from-red-500 to-red-700 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
        <span class="text-white">Request for Cancellation</span>
        <a href="/dashboard" class="bg-white text-red-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
            Home
        </a>
    </header>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-red-800 mb-4">Requests</h2>
        <div id="error-message" class="error-message"></div>
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr class="text-red-800 border-b">
                    <th class="px-4 py-2 text-left">Tracking Code</th>
                    <th class="px-4 py-2 text-left">Customer Name</th>
                    <th class="px-4 py-2 text-left">Check-in Date</th>
                    <th class="px-4 py-2 text-left">Check-out Date</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Extra Pax</th>
                    <th class="px-4 py-2 text-left">Special Request</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Category</th>
                    <th class="px-4 py-2 text-left">Downpayment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($canceledBookings as $booking)
                <tr class="bg-red-100">
                    <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                    <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                    <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                    <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                    <td class="px-4 py-2 text-red-600">{{ $booking->phone }}</td>
                    <td class="px-4 py-2">{{ $booking->extra_pax }}</td>
                    <td class="px-4 py-2 text-left whitespace-normal break-words max-w-xs">
                        <p class="block">{{ $booking->special_request ?? 'None' }}</p>
                    </td>
                    <td class="px-4 py-2">Canceled</td>
                    <td class="px-4 py-2">{{ $booking->package_name }}</td>
                    <td class="px-4 py-2">{{ $booking->downpayment }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


</body>
</html>