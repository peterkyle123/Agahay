<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Approved Bookings</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Approved Bookings</h1>

    @if (session('success'))
      <div class="bg-green-200 text-green-800 p-4 mb-6 rounded shadow-md">
        {{ session('success') }}
      </div>
    @endif

    @if (count($bookings) > 0)
      <div class="mb-4 flex justify-between">
        <button id="deleteSelectedBtn" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition" onclick="deleteSelected()">
          Delete Selected
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
          <thead class="bg-gray-50">
            <tr>
              <th class="border border-gray-300 p-3 text-center">
                <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
              </th>
              <th class="border border-gray-300 p-3 text-left">Tracking Code</th>
              <th class="border border-gray-300 p-3 text-left">Customer Name</th>
              <th class="border border-gray-300 p-3 text-left">Check-in Date</th>
              <th class="border border-gray-300 p-3 text-left">Check-out Date</th>
              <th class="border border-gray-300 p-3 text-center">Days Staying</th>
              <th class="border border-gray-300 p-3 text-left">Phone</th>
              <th class="border border-gray-300 p-3 text-left">Extra Pax</th>
              <th class="border border-gray-300 p-3 text-left">Special Request</th>
              <th class="border border-gray-300 p-3 text-left">Category</th>
              <th class="border border-gray-300 p-3 text-left">Payment</th>
              <th class="border border-gray-300 p-3 text-left">Downpayment</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($bookings as $booking)
              <tr class="hover:bg-gray-100">
                <td class="border border-gray-300 p-3 text-center">
                  <input type="checkbox" class="bookingCheckbox" value="{{ $booking->id }}">
                </td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->tracking_code }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->customer_name }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->check_in_date }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->check_out_date }}</td>
                <td class="border border-gray-300 p-3 text-center">{{ $booking->days_staying }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->phone }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->extra_pax }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->special_request ?? 'None' }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->package_name }}</td>
                <td class="border border-gray-300 p-3 text-sm">{{ $booking->payment }}</td>
                <td class="border border-gray-300 p-3 text-sm">
                    <div class="w-16 h-16 overflow-hidden rounded-lg cursor-pointer hover:opacity-80 transition">
                    <img 
                        src="{{ asset('storage/' . $booking->proof_of_payment) }}" 
                        alt="No Proof" 
                        class="w-full h-full object-cover"
                        onclick="openModal('{{ asset('storage/' . $booking->proof_of_payment) }}')"> <!-- Fix: Added onclick -->
                    </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-center text-gray-600">No approved bookings found.</p>
    @endif
  </div>
   <!-- Modal for Enlarged Proof of Payment Image -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg relative p-4 max-w-2xl w-full">
        <!-- Close button -->
        <span class="absolute top-2 right-2 text-gray-600 text-2xl cursor-pointer hover:text-gray-800" onclick="closeModal()">&times;</span>
        <!-- Modal Image -->
        <img id="modal-image" src="" alt="Proof of Payment" class="w-full h-auto rounded">
    </div>
</div>
    <script>
         // Open modal and set image source
    function openModal(imageSrc) {
        const modal = document.getElementById('modal');
        const modalImage = document.getElementById('modal-image');
        modalImage.src = imageSrc;
        modal.classList.remove('hidden'); // Show modal
        modal.classList.add('flex'); // Ensure flex display for centering
    }

    // Close modal function
    function closeModal() {
        const modal = document.getElementById('modal');
        modal.classList.add('hidden'); // Hide modal
        modal.classList.remove('flex'); // Remove flex display
    }

    // Close modal when clicking outside the image
    document.getElementById('modal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeModal();
        }
    });
    // Function to toggle "Select All" checkbox
    function toggleSelectAll(source) {
      let checkboxes = document.querySelectorAll(".bookingCheckbox");
      checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
      });
    }

    // Function to delete multiple selected bookings
    function deleteSelected() {
      let selectedBookings = [];
      document.querySelectorAll(".bookingCheckbox:checked").forEach(checkbox => {
        selectedBookings.push(checkbox.value);
      });

      if (selectedBookings.length === 0) {
        alert("Please select at least one booking to delete.");
        return;
      }

      if (!confirm("Are you sure you want to delete the selected bookings?")) {
        return;
      }

      fetch(`/bookings/delete-multiple`, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ bookingIds: selectedBookings })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Selected bookings deleted successfully.");
          location.reload();
        } else {
          alert("Failed to delete bookings.");
        }
      })
      .catch(error => console.error("Error deleting bookings:", error));
    }
  </script>
</body>
</html>
