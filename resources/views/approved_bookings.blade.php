<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Bookings</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Approved Bookings</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (count($bookings) > 0)
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">Tracking Code</th>
                        <th class="border border-gray-300 p-2">Customer Name</th>
                        <th class="border border-gray-300 p-2">Check-in Date</th>
                        <th class="border border-gray-300 p-2">Check-out Date</th>
                        <th class="border border-gray-300 p-2">Days Staying</th>
                        <th class="border border-gray-300 p-2">Phone</th>
                        <th class="border border-gray-300 p-2">Extra Pax</th>
                        <th class="border border-gray-300 p-2">Special Request</th>
                        <th class="border border-gray-300 p-2">Category</th>
                        <th class="border border-gray-300 p-2">Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $booking->tracking_code }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->customer_name }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->check_in_date }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->check_out_date }}</td>
                            <td class="border border-gray-300 p-2 text-center">{{ $booking->days_staying }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->phone }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->extra_pax }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->special_request ?? 'None' }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->package_name }}</td>
                            <td class="border border-gray-300 p-2">{{ $booking->payment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No approved bookings found.</p>
        @endif
    </div>
</body>
</html>