<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Table</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<table class="min-w-full bg-white shadow-md rounded-lg">
    <thead>
        <tr class="w-full bg-green-600 text-white">
            <th class="py-2 px-4">Tracking Code</th>
            <th class="py-2 px-4">Guest Name</th>
            <th class="py-2 px-4">Person Booking</th>
            <th class="py-2 px-4">Check-in</th>
            <th class="py-2 px-4">Check-out</th>
            <th class="py-2 px-4">Status</th>
            <th class="py-2 px-4">Action</th>

        </tr>
    </thead>
    <tbody>
    @foreach ($bookings as $booking)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $booking->tracking_code }}</td>
            <td class="py-2 px-4">{{ $booking->guest_name }}</td>
            <td class="py-2 px-4">{{ $booking->customer_name }}</td>
            <td class="py-2 px-4">{{ $booking->check_in_date }}</td>
            <td class="py-2 px-4">{{ $booking->check_out_date }}</td>
            <td class="py-2 px-4">{{ $booking->status }}</td>
            <td class="px-4 py-2">
                @if ($booking->status == 'Pending')
                    <form method="POST" action="{{ route('admin.updateBookingsStatus', ['id' => $booking->id]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="action" value="approve" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">Approve</button>
                    </form>
                    <button type="button" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md open-modal" data-booking-id="{{ $booking->id }}">
                        Decline
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
</table>


<div class="mt-4">
    {{ $bookings->links() }}
</div>

<div id="declineModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Decline Booking</h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Enter the reason for declining this booking.</p>
                <form id="declineForm">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="modalBookingId" name="booking_id">
                    <textarea id="declineReason" name="decline_reason" class="border rounded w-full p-2" placeholder="Reason"></textarea>
                    <div class="mt-4">
                        <button type="button" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded close-modal">Cancel</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Decline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', function () {
                const bookingId = this.getAttribute('data-booking-id');
                document.getElementById('modalBookingId').value = bookingId;
                document.getElementById('declineModal').classList.remove('hidden');
            });
        });

        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('declineModal').classList.add('hidden');
            });
        });

        document.getElementById('declineForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const bookingId = document.getElementById('modalBookingId').value;
            const declineReason = document.getElementById('declineReason').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/bookings/${bookingId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ action: 'decline', decline_reason: declineReason, _method: 'PATCH' }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    location.reload();
                } else {
                    alert('Failed to decline booking.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        });
    });
</script>
</body>
</html>
