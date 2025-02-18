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
                    <th><input type="checkbox" id="select-all" class="select-all"></th>
                    <th class="px-4 py-2 text-left">Tracking Code</th>
                    <th class="px-4 py-2 text-left">Customer Name</th>
                    <th class="px-4 py-2 text-left">Check-in Date</th>
                    <th class="px-4 py-2 text-left">Check-out Date</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Extra Pax</th>
                    <th class="px-4 py-2 text-left">Special Request</th>
                    <th class="px-4 py-2 text-left">Category</th>
                    <th class="px-4 py-2 text-left">Downpayment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($canceledBookings as $booking)
                <tr class="bg-red-100" id="booking-{{ $booking->id }}">
                    <td class="px-4 py-2">
                        <input type="checkbox" name="bookings[]" value="{{ $booking->id }}" class="booking-checkbox">
                    </td>
                    <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                    <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                    <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                    <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                    <td class="px-4 py-2 text-red-600">{{ $booking->phone }}</td>
                    <td class="px-4 py-2">{{ $booking->extra_pax }}</td>
                    <td class="px-4 py-2 text-left whitespace-normal break-words max-w-xs">
                        <p class="block">{{ $booking->special_request ?? 'None' }}</p>
                    </td>
                    <td class="px-4 py-2">{{ $booking->package_name }}</td>
                    <td class="px-4 py-2">{{ $booking->downpayment }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
       <!-- Cancel and Delete Buttons -->
<div class="mt-4 text-center">
    <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition" id="cancelSelectedBookingsBtn">
        Cancel Selected Bookings
    </button>

    <button class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition ml-2" id="deleteSelectedBookingsBtn">
        Delete Selected Bookings
    </button>
</div>

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

    // Handle canceling selected bookings
    document.getElementById('cancelSelectedBookingsBtn').addEventListener('click', function() {
        const selectedBookings = Array.from(document.querySelectorAll('.booking-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedBookings.length === 0) {
            alert('Please select at least one booking to cancel.');
            return;
        }

        const confirmCancel = confirm("Are you sure you want to cancel the selected bookings?");
        if (confirmCancel) {
            fetch('/cancel-bookings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    booking_ids: selectedBookings
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    selectedBookings.forEach(bookingId => {
                        const bookingElement = document.getElementById(`booking-${bookingId}`);
                        if (bookingElement) {
                            bookingElement.style.display = 'none';
                        }
                    });
                    alert("Selected bookings have been canceled.");
                } else {
                    alert("Failed to cancel the selected bookings. Please try again.");
                }
            })
            .catch(error => {
                alert("An error occurred. Please try again later.");
            });
        }
    });
</script>
</body>
</html>
