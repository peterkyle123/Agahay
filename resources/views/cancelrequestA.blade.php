<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Request</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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

<body class="bg-gray-100 font-sans mt-24">
    <div class="container mx-auto p-4">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 rounded-lg mb-4 flex justify-between items-center">
            <span class="text-lg font-semibold">Request for Cancellation</span>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 overflow-x-auto">
            <h2 class="text-2xl font-semibold text-red-800 mb-4">Requests</h2>
            <div id="error-message" class="text-red-600 mb-2 text-sm"></div>

            @if (session('success'))
                <div class="bg-green-500 text-white p-2 rounded-md mb-2 text-sm">{{ session('success') }}</div>
            @endif

            <table class="min-w-full table-auto text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Tracking Code</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Customer Name</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Check-in Date</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Check-out Date</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Phone</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Extra Pax</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Special Request</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Category</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Proof of Downpayment</th>
                        <th class="px-4 py-2 text-left font-semibold text-red-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($canceledBookings->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center py-4 text-gray-500 italic">No canceled bookings available</td>
                        </tr>
                    @else
                        @foreach ($canceledBookings as $booking)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                                <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                                <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                                <td class="px-4 py-2 text-red-600">{{ $booking->phone }}</td>
                                <td class="px-4 py-2">{{ $booking->extra_pax }}</td>
                                <td class="px-4 py-2">{{ $booking->special_request ?? 'None' }}</td>
                                <td class="px-4 py-2">{{ $booking->package_name }}</td>
                                <td class="px-4 py-2">
                                    <div class="w-16 h-16 overflow-hidden rounded-lg cursor-pointer hover:opacity-80 transition">
                                        <img src="{{ asset('storage/' . $booking->proof_of_payment) }}" alt="Proof of Payment" class="w-full h-full object-cover" onclick="openModal('{{ asset('storage/' . $booking->proof_of_payment) }}')">
                                    </div>
                                </td>
                                <td class="px-4 py-2 flex space-x-1">
                                    <a class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-md font-semibold uppercase text-xs transition" href="{{ route('approve.booking', $booking->id) }}">Approve</a>
                                    <a class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md font-semibold uppercase text-xs transition" href="{{ route('reject.booking', $booking->id) }}">Reject</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-70 z-50 hidden">
        <span class="absolute top-2 right-2 bg-white rounded-full p-1 cursor-pointer text-xl" onclick="closeModal()">×</span>
        <img id="modal-image" src="" alt="Proof of Payment" class="max-w-3xl max-h-3xl rounded-lg">
    </div>

    <script>
        function openModal(imageUrl) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal-image').src = imageUrl;
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>

</html>
