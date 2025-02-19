<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Cancellations</title>
</head>
<body>
@vite('resources/css/app.css')
@vite('resources/js/app.js') 

<div class="min-h-screen p-6">
    <header class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
        <span class="text-white">Approved Cancellations</span>
        <a href="/dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
            Home
        </a>
    </header>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-green-800 mb-4">Approved Requests</h2>
        <div id="error-message" class="error-message"></div>
        
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr class="text-green-800 border-b">
                    <th class="px-4 py-2 text-left">Tracking Code</th>
                    <th class="px-4 py-2 text-left">Customer Name</th>
                    <th class="px-4 py-2 text-left">Check-in Date</th>
                    <th class="px-4 py-2 text-left">Check-out Date</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Extra Pax</th>
                    <th class="px-4 py-2 text-left">Special Request</th>
                    <th class="px-4 py-2 text-left">Category</th>
                </tr>   
            </thead>
            <tbody>
                @if ($approvedBookings->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No approved cancellations available</td>
                    </tr>
                @else
                    @foreach ($approvedBookings as $booking)
                        <tr class="bg-green-100">
                            <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                            <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                            <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                            <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                            <td class="px-4 py-2 text-green-600">{{ $booking->phone }}</td>
                            <td class="px-4 py-2">{{ $booking->extra_pax }}</td>
                            <td class="px-4 py-2 text-left whitespace-normal break-words max-w-xs">
                                <p class="block">{{ $booking->special_request ?? 'None' }}</p>
                            </td>
                            <td class="px-4 py-2">{{ $booking->package_name }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
