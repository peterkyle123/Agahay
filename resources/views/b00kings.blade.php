<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking List</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white"> 
    <div class="min-h-screen p-6">
        <header class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
            <span class="text-white">Bookings</span>

            <a href="/dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                Home
            </a>
        </header>

        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-green-800 mb-4">Search Bookings</h2>
            <form action="{{ route('admin.bookings') }}" method="GET" class="flex items-center space-x-4">
                <input type="text" name="search" placeholder="Tracking Code, Name, Date" class="border p-2 rounded-md flex-grow">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Search</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-green-800 mb-4">List of Bookings</h2>
            <div id="error-message" class="error-message"></div>
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.bookings', ['sort' => 'asc', 'search' => request('search')]) }}" class="text-green-600 hover:text-green-800">Sort Ascending (Check-in)</a> |
                <a href="{{ route('admin.bookings', ['sort' => 'desc', 'search' => request('search')]) }}" class="text-green-600 hover:text-green-800">Sort Descending (Check-in)</a>
            </div>

            @if (session('error'))
                <div class="bg-red-500 text-white p-3 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.updateBookingsStatus') }}" method="POST" id="booking-status-form">
                @csrf
                @method('PATCH') <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="text-green-800 border-b">
                            <th class="px-4 py-2 text-left">
                                <input type="checkbox" id="select-all" class="select-all">
                            </th>
                            <th class="px-4 py-2 text-left">Tracking Code</th>
                            <th class="px-4 py-2 text-left">Customer Name</th>
                            <th class="px-4 py-2 text-left">Check-in Date</th>
                            <th class="px-4 py-2 text-left">Check-out Date</th>
                            <th class="px-4 py-2 text-left">Days Staying</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">Extra Pax</th>
                            <th class="px-4 py-2 text-left">Special Request</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Category</th>
                            <th class="px-4 py-2 text-left">Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                        <tr class="@if($booking->highlight) bg-green-200 @endif">
                                <td class="px-4 py-2">
                                    <input type="checkbox" name="bookings[]" value="{{ $booking->id }}" class="booking-checkbox">
                                </td>
                                <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                                <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                                <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                                <td class="px-4 py-2 text-center"> {{ $booking->days_staying }} </td> 
                                <td class="px-4 py-2 text-green-600">{{ $booking->phone }}</td>
                                <td class="px-4 py-2">{{ $booking->extra_pax }}</td>
                                <td class="px-4 py-2 text-left whitespace-normal break-words max-w-xs">
                                    <p class="block">{{ $booking->special_request ?? 'None' }}</p>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $booking->status ?? 'Pending' }}
                                </td>
                                <td class="px-4 py-2">{{ $booking->package_name}}</td>
                                <td class="px-4 py-2">{{ $booking->payment }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 flex justify-end space-x-4">
                    <button type="submit" name="action" value="delete" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-800">
                        Delete Cancelled Bookings
                    </button>

                    <button type="submit" name="action" value="done" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-800">
                        Mark Selected as Done
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Select/Deselect all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.booking-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
</body>
</html>