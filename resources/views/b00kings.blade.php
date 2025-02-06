<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking List</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-100">
    <div class="min-h-screen p-6">
    <header class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
    <span class="text-white">Bookings</span>

    <!-- Home Button -->
    <a href="dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
        Home
    </a>
</header>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-green-800 mb-4">List of Bookings</h2>
            @if(session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
@endif
<div id="error-message" class="error-message"></div>
            <!-- Form for deleting multiple bookings -->
            <form action="{{ route('admin.deleteBookings') }}" method="POST">
                @csrf
                @method('DELETE') <!-- Ensure method is DELETE -->

                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="text-green-800 border-b">
                            <th class="px-4 py-2 text-left">
                                <input type="checkbox" id="select-all" class="select-all">
                            </th>
                            <th class="px-4 py-2 text-left">Tracking Code</th>
                            <th class="px-4 py-2 text-left">Customer Name</th>
                            <th class="px-4 py-2 text-left">Check-in Date</th>
                            <th class="px-4 py-2 text-left">Check-out Date</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">Extra Pax</th> <!-- New Column -->
                            <th class="px-4 py-2 text-left">Special Request</th> <!-- New Column -->
                            <th class="px-4 py-2 text-left">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="px-4 py-2">
                                    <input type="checkbox" name="bookings[]" value="{{ $booking->id }}" class="booking-checkbox">
                                </td>
                                <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                                <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                                <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                                <td class="px-4 py-2 text-green-600">{{ $booking->phone }}</td>
                                <td class="px-4 py-2">{{ $booking->extra_pax }}</td> <!-- Display Extra Pax -->
                                <td class="px-4 py-2">{{ $booking->special_request ?? 'None' }}</td> <!-- Display Special Request -->
                                <td class="px-4 py-2">
                    {{ $booking->status ?? 'Not Set' }} <!-- Display the Status -->
                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Delete Button -->
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-800">
                        Delete Selected Bookings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to toggle select-all functionality -->
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
