<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Archived Bookings</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white"> 
    <div class="min-h-screen p-6">
        <!-- Header -->
        <header class="bg-gradient-to-r from-green-500 to-green-800 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
            <span class="text-white">Archived Bookings</span>
            
            <div class="flex space-x-4">
    <!-- Canceled Bookings Button -->
    <a href="{{ url('/approvedCanceled') }}" class="bg-white text-red-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
        Canceled Bookings
    </a>
    <!-- Home Button -->
    <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
        Home
    </a>
 
</div>

        </header>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">List of Completed Bookings (Done)</h2>
            
            @if(session('success'))
                <div class="bg-green-200 text-green-800 p-2 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-200 text-red-800 p-2 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div id="error-message" class="error-message"></div>

            <!-- Table displaying only 'Done' bookings -->
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="text-gray-800 border-b">
                        <th class="px-4 py-2 text-left">Tracking Code</th>
                        <th class="px-4 py-2 text-left">Customer Name</th>
                        <th class="px-4 py-2 text-left">Check-in Date</th>
                        <th class="px-4 py-2 text-left">Check-out Date</th>
                        <th class="px-4 py-2 text-left">Phone</th>
                        <th class="px-4 py-2 text-left">Payment</th>
                        <th class="px-4 py-2 text-left">Category</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($archivedBookings as $booking)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                            <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                            <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                            <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $booking->phone }}</td>
                            <td class="px-4 py-2">{{ $booking->payment }}</td>
                            <td class="px-4 py-2 font-bold">{{ $booking->package_name }}</td>
                            <td class="px-4 py-2 text-center">
                                <!-- Delete Button -->
                                <form action="{{ route('admin.deleteArchivedBooking', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-600 py-4">No completed bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
