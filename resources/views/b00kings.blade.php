<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin - Booking List</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white">
  <div class="min-h-screen p-6">
    <header class="bg-gradient-to-r from-green-500 to-green-800 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
      <span class="text-white">Archived Bookings</span>
      <div class="flex space-x-4">
        <a href="{{ route('approved.bookings') }}" class="bg-white text-red-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
          Approved Bookings
        </a>
        <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
          Home
        </a>
      </div>
    </header>

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
      <h2 class="text-xl font-semibold text-green-800 mb-4">Search Bookings</h2>
      <form action="{{ route('b00kings') }}" method="GET" class="flex items-center space-x-4">
        <input type="text" name="search" placeholder="Tracking Code, Name, Date" class="border p-2 rounded-md flex-grow">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Search</button>
      </form>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
      <h2 class="text-xl font-semibold text-green-800 mb-4">List of Bookings</h2>
      @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
          {{ session('success') }}
        </div>
      @endif

      <div class="mb-4">
        <a href="{{ route('b00kings', ['sort' => 'asc', 'search' => request('search')]) }}" class="text-green-600 hover:text-green-800">Sort Ascending (Check-in)</a> |
        <a href="{{ route('b00kings', ['sort' => 'desc', 'search' => request('search')]) }}" class="text-green-600 hover:text-green-800">Sort Descending (Check-in)</a>
      </div>

      @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('admin.updateBookingsStatus', ['id' => 0]) }}" method="POST">
        @csrf
        @method('PATCH')
        <table class="min-w-full bg-white shadow-md rounded-lg">
          <thead>
            <tr class="text-green-800 border-b">
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
              <th class="px-4 py-2 text-left">Discount (%)</th>
              <th class="px-4 py-2 text-left">Final Payment</th>
              <th class="px-4 py-2 text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($bookings as $booking)
              @if ($booking->status !== 'Canceled' && $booking->status !== 'Done')
                <tr class="@if($booking->highlight) bg-green-200 @endif">
                  <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
                  <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                  <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                  <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                  <td class="px-4 py-2 text-center">{{ $booking->days_staying }}</td>
                  <td class="px-4 py-2 text-green-600">{{ $booking->phone }}</td>
                  <td class="px-4 py-2">{{ $booking->extra_pax }}</td>
                  <td class="px-4 py-2 text-left whitespace-normal break-words max-w-xs">
                    <p class="block">{{ $booking->special_request ?? 'None' }}</p>
                  </td>
                  <td class="px-4 py-2">{{ $booking->status ?? 'Pending' }}</td>
                  <td class="px-4 py-2">{{ $booking->package_name }}</td>
                  <!-- Payment cell: store both base and original payment -->
                  <td class="px-4 py-2">
                    <!-- Final Payment column uses model's computed accessor -->
                    ₱{{ number_format($booking->final_payment, 2) }}
                  </td>
                  <td class="px-4 py-2">
                    <input type="number" class="discount-input border p-2 rounded w-20"
                           data-id="{{ $booking->id }}" value="{{ $booking->discount }}" min="0" max="100">
                  </td>

                  <td class="px-4 py-2" id="payment-{{ $booking->id }}" data-original="{{ $booking->payment }}" data-base="{{ $booking->payment }}">
                    ₱{{ number_format($booking->payment, 2) }}
                  </td>
                  <td class="px-4 py-2">
                    @if ($booking->status == 'Pending')
                      <button type="submit" name="action" value="approve" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md" formaction="{{ route('admin.updateBookingsStatus', ['id' => $booking->id]) }}">
                        Approve
                      </button>
                      <button type="button" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md open-modal" data-booking-id="{{ $booking->id }}">
                        Decline
                      </button>
                    @elseif ($booking->status == 'Declined')
                      <button type="submit" name="action" value="delete" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md" formaction="{{ route('admin.updateBookingsStatus', ['id' => $booking->id]) }}">
                        Delete
                      </button>
                    @endif
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </form>

      <!-- Decline Modal -->
      <div id="declineModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Decline Booking</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Enter the reason for declining this booking.</p>
              <form id="declineForm" method="PATCH">
                @csrf
                @method('PATCH')
                <input type="hidden" id="modalBookingId" name="booking_id">
                <textarea id="declineReason" name="decline_reason" class="border rounded w-full p-2" placeholder="Reason"></textarea>
                <div class="mt-4">
                  <button type="button" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2 close-modal">Cancel</button>
                  <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Decline</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- General Modal Handling Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const selectAllCheckbox = document.getElementById('select-all');
      const checkboxes = document.querySelectorAll('.booking-checkbox');

      if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
          checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
          });
        });
      }

      checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
          if (selectAllCheckbox) {
            selectAllCheckbox.checked = [...checkboxes].every(cb => cb.checked);
          }
        });
      });
    });

    document.querySelectorAll('.open-modal').forEach(button => {
      button.addEventListener('click', function() {
        const bookingId = this.getAttribute('data-booking-id');
        document.getElementById('modalBookingId').value = bookingId;
        document.getElementById('declineModal').classList.remove('hidden');
      });
    });

    document.querySelectorAll('.close-modal').forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('declineModal').classList.add('hidden');
      });
    });

    document.getElementById('declineForm').addEventListener('submit', function(event) {
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
  </script>

  <!-- Discount Update Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.discount-input').forEach(input => {
        input.addEventListener('input', function () {
          let discount = parseFloat(this.value) || 0;
          let bookingId = this.getAttribute('data-id');
          let paymentCell = document.getElementById(`payment-${bookingId}`);
          // Always use the fixed original amount stored in data-base for calculations
          let basePayment = parseFloat(paymentCell.getAttribute('data-base'));

          if (discount < 0 || discount > 100) {
            alert('Discount must be between 0 and 100');
            this.value = 0;
            discount = 0;
          }

          // Calculate new final payment based on discount
          let newPayment = basePayment * (1 - discount / 100);
          // Update Payment cell display (with currency formatting)
          paymentCell.textContent = '₱' + newPayment.toFixed(2);

          // Send AJAX request to update discount (and final payment in database)
          let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          fetch(`/admin/bookings/update-discount/${bookingId}`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ discount: discount })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              console.log('Discount updated successfully');
              // Do not update data-base so that base remains fixed
            } else {
              alert('Failed to update discount');
            }
          })
          .catch(error => console.error('Error:', error));
        });
      });
    });
  </script>
</body>
</html>
