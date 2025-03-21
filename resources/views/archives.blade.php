<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Archived Bookings</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white">
    <div class="min-h-screen p-6">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-900 h-20 w-full flex items-center fixed top-0 left-0 z-50 shadow-md">
            <nav class="flex justify-start space-x-8 ml-6">
                <a href="/packages" class="text-green-600 hover:text-green-900 text-s">Back</a>
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


        <div class="bg-white rounded-xl shadow-lg p-6 mt-24">
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

            <!-- Bulk Delete Form -->
            <form id="bulkDeleteForm" action="{{ route('admin.bulkDeleteArchivedBookings') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected bookings permanently?');">
             @csrf
            @method('DELETE')

                <!-- Delete Selected Button -->
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 mb-4">
                    Delete Selected
                </button>

                <!-- Table displaying only 'Done' bookings -->
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr class="text-gray-800 border-b">
                            <th class="px-4 py-2 text-left">
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                            </th>
                            <th class="px-4 py-2 text-left">Tracking Code</th>
                            <th class="px-4 py-2 text-left">Customer Name</th>
                            <th class="px-4 py-2 text-left">Check-in Date</th>
                            <th class="px-4 py-2 text-left">Check-out Date</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">Payment</th>
                            <th class="px-4 py-2 text-left">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($archivedBookings as $booking)
                            <tr class="border-b">
                                <td class="px-4 py-2">
                                    <input type="checkbox" name="booking_ids[]" value="{{ $booking->id }}" class="bookingCheckbox">
                                </td>
                                <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                                <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                                <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ $booking->phone }}</td>
                                <td class="px-4 py-2">{{ $booking->payment }}</td>
                                <td class="px-4 py-2 font-bold">{{ $booking->package_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-600 py-4">No completed bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <script>
        // Toggle all checkboxes when 'Select All' is clicked
        function toggleSelectAll(source) {
            let checkboxes = document.querySelectorAll('.bookingCheckbox');
            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
        }
    </script>
</body>
</html>
