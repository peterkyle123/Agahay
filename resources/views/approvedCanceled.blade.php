<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Approved Canceled Bookings</title>
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
        <div class="bg-white rounded-xl shadow-lg p-6 mt-24">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">List of Canceled Bookings</h2>

            <!-- Success & Error Messages -->
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

            <!-- Bulk Delete Form -->
            <form id="bulkDeleteForm" action="{{ route('admin.bulkDeleteApprovedBookings') }}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Table displaying only 'Canceled' bookings -->
                <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="text-gray-800 border-b">
                        <th class="px-4 py-2 text-left">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="px-4 py-2 text-left">Tracking Code</th>
                        <th class="px-4 py-2 text-left">Customer Name</th>
                        <th class="px-4 py-2 text-left">Check-in Date</th>
                        <th class="px-4 py-2 text-left">Check-out Date</th>
                        <th class="px-4 py-2 text-left">Phone</th>
                        <th class="px-4 py-2 text-left">Payment</th>
                        <th class="px-4 py-2 text-left">Downpayment</th>
                        <th class="px-4 py-2 text-left">Category</th>
                    </tr>
                </thead>
                <tbody>
                        @php
                            $totalDownpayment = 0; // Initialize the total variable to 0
                        @endphp

                            @forelse ($approvedCanceledBookings as $booking)
                                <tr class="border-b">
                                    <td class="px-4 py-2">
                                        <input type="checkbox" name="booking_ids[]" value="{{ $booking->id }}" class="booking-checkbox">
                                    </td>
                                    <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                                    <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                    <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                                    <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                                    <td class="px-4 py-2 text-gray-600">{{ $booking->phone }}</td>
                                    <td class="px-4 py-2">{{ $booking->payment }}</td>
                                    <td class="px-4 py-2">
                                        @if ($booking->package && $booking->package->initial_payment)
                                            ₱{{ number_format($booking->package->initial_payment, 2) }}
                                            @php
                                                $totalDownpayment += $booking->package->initial_payment; // Accumulate the downpayments
                                            @endphp
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 font-bold">{{ $booking->package_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-600 py-4">No canceled bookings found.</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="8" class="px-4 py-2 text-right font-bold">Total Downpayments:</td>
                                <td class="px-4 py-2 font-bold">₱{{ number_format($totalDownpayment, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                <!-- Bulk Delete Button -->
                <button type="submit" class="bg-red-600 text-white px-4 py-2 mt-4 rounded-lg hover:bg-red-800">
                    Delete Selected
                </button>
            </form>
        </div>
    </div>

    <script>
        // Select/Deselect All Checkboxes
        document.getElementById('select-all').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.booking-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
</body>
</html>
