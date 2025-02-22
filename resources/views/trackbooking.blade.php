<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Booking | Agahay Guesthouse</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-100 font-sans">
    <div class="bg-green-900 text-white p-4 sm:p-6 shadow-md w-full">
        <div class="flex flex-wrap items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-semibold">Track Your Booking</h1>
            <div class="flex items-center mt-2 sm:mt-0">
                <a href="/" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                    Home
                </a>
            </div>
        </div>
    </div>

    <div class="container max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">Enter Your Booking Code</h2>

        <form action="{{ route('trackbooking') }}" method="POST" class="mb-4">
            @csrf
            <input type="text" name="tracking_code" id="bookingCode" placeholder="E.g., BKABC123" value="{{ old('tracking_code') }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring focus:border-green-300">
            <button class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white py-3 rounded-md transition duration-300">Search</button>
        </form>

        @error('tracking_code')
            <div class="text-red-600 mb-4">{{ $message }}</div>
        @enderror

        @if(isset($booking))
            <div class="border rounded-md p-4 bg-gray-50">
                <p><strong class="text-gray-700">Booking Code:</strong> {{ $booking->tracking_code }}</p>
                <p><strong class="text-gray-700">Guest Name:</strong> {{ $booking->customer_name }}</p>
                <p><strong class="text-gray-700">Check-in:</strong> {{ $booking->check_in_date }}</p>
                <p><strong class="text-gray-700">Check-out:</strong> {{ $booking->check_out_date }}</p>
                <p><strong class="text-gray-700">Status:</strong> {{ $booking->status }}</p>
                <p><strong class="text-gray-700">Package:</strong> {{ $booking->package_name }}</p>
                <p><strong class="text-gray-700">Initial Payment (Downpayment):</strong> 
                    @if($booking->package)
                        ₱{{ number_format($booking->package->initial_payment, 2) }}
                    @else
                        N/A
                    @endif
                </p>

                @if ($booking->status == 'Pending')
                    <form id="proof-of-payment-form" action="{{ route('booking.upload.proof', $booking->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <label for="proofOfPayment" class="block text-sm font-medium text-gray-700 mb-2">Upload Proof of Payment:</label>
                        <input type="file" name="proof_of_payment" id="proofOfPayment" required class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-green-300">
                        <button type="submit" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white py-3 rounded-md transition duration-300">Upload Proof of Payment</button>
                    </form>

                    <form id="cancel-form" action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display: none;" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-md transition duration-300">Apply for Cancellation</button>
                    </form>
                @elseif($booking->status == 'Request for Cancellation')
                    <p class="mt-4 text-center text-gray-600">Cancellation request pending.</p>
                @endif
            </div>
        @elseif(session('error'))
            <div class="text-red-600 mt-4 text-center">{{ session('error') }}</div>
        @endif
    </div>

    <script>
        // Proof of Payment Upload Handling
        document.getElementById('proof-of-payment-form')?.addEventListener('submit', function(event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    document.getElementById('cancel-form').style.display = 'block'; // Show cancellation button
                    form.style.display = 'none'; // Hide upload form
                } else if (data.error) {
                    alert(data.error);
                } else {
                    alert('An unexpected error occurred during upload.');
                    console.error('Data returned without success or error property:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred during proof of payment upload.");
            });
        });

        // Cancellation Form Handling
        document.getElementById('cancel-form')?.addEventListener('submit', function(event) {
            event.preventDefault();

            const form = this;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    _method: 'PATCH' // Important for Laravel if using POST method
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    form.style.display = 'none';
                    const messageElement = document.createElement('p');
                    messageElement.textContent = "Cancellation request pending.";
                    form.parentNode.insertBefore(messageElement, form.nextSibling);
                } else if (data.error) {
                    alert(data.error);
                } else {
                    alert("An unexpected error occurred.");
                    console.error('Data returned without success or error property:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred during cancellation.");
            });
        });
    </script>
</body>
</html>