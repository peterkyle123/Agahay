<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking | Agahay Guesthouse</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <div class="bg-green-900 text-white p-4 sm:p-6 shadow-md w-full">
        <div class="flex items-center justify-between">
            <h1 class="text-lg sm:text-2xl font-semibold">Edit Booking</h1>
        </div>
    </div>

    <!-- Form Container -->
    <div class="container max-w-lg mx-auto mt-6 p-4 sm:p-6 bg-white rounded-lg shadow-md">
    <form action="{{ route('booking.update.user', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')

            <!-- Full Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                <input type="text" id="name" name="customer_name" value="{{ $booking->customer_name }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your full name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            </div>

            <!-- Check-in Date -->
            <div class="mb-4">
                <label for="checkin" class="block text-sm font-semibold text-gray-700">Check-in Date</label>
                <input type="date" id="checkin" name="check_in_date" value="{{ $booking->check_in_date }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Check-out Date -->
            <div class="mb-4">
                <label for="checkout" class="block text-sm font-semibold text-gray-700">Check-out Date</label>
                <input type="date" id="checkout" name="check_out_date" value="{{ $booking->check_out_date }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ $booking->phone }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your phone number" pattern="^\d{11}$" maxlength="11" title="Phone number must be exactly 11 digits">
            </div>

            <!-- Extra Pax -->
            <div class="mb-4">
                <label for="extra_pax" class="block text-sm font-semibold text-gray-700">Extra Pax</label>
                <input type="number" id="extra_pax" name="extra_pax" value="{{ $booking->extra_pax }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Extra Pax?" min="0" step="1">
            </div>

            <!-- Special Requests -->
            <div class="mb-4">
                <label for="special_requests" class="block text-sm font-semibold text-gray-700">Special Requests</label>
                <textarea id="special_requests" name="special_request" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Any special requests?" rows="4">{{ $booking->special_request }}</textarea>
            </div>

            <input type="hidden" name="payment" id="payment" value="{{ $booking->payment }}">

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-md transition duration-300">
                Update Booking
            </button>
        </form>
    </div>

    <!-- Error Modal -->
    <div id="error-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-semibold mb-4 text-center text-red-600">Error</h2>
            <p id="error-message" class="text-center text-gray-700"></p>
            <button id="close-error-modal" class="w-full mt-4 bg-red-600 hover:bg-red-700 text-white py-3 rounded-md transition duration-300">Close</button>
        </div>
    </div>

    <script>
        // Get the input elements
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        const extraPaxInput = document.getElementById('extra_pax');
        const paymentInput = document.getElementById('payment');

        // Package details (replace with actual values from your database)
        const packagePrice = {{ $booking->package->price }};
        const packageDays = {{ $booking->package->number_of_days }};
        const extraDayRate = {{ $booking->package->per_day_price }};
        const extraPaxRate = {{ $booking->package->extra_pax_price }};
        const friSunPrice = {{ $booking->package->fri_sun_price }};

        // Modal elements
        const errorModal = document.getElementById('error-modal');
        const errorMessage = document.getElementById('error-message');
        const closeErrorModal = document.getElementById('close-error-modal');

        function showError(message) {
            errorMessage.textContent = message;
            errorModal.classList.remove('hidden');
        }

        function hideError() {
            errorModal.classList.add('hidden');
        }

        closeErrorModal.addEventListener('click', hideError);

        function calculateTotalPayment() {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);
            const extraPax = parseInt(extraPaxInput.value) || 0;

            if (isNaN(checkinDate) || isNaN(checkoutDate)) {
                paymentInput.value = "";
                showError("Please enter valid check-in and check-out dates.");
                return;
            }

            const timeDifference = checkoutDate - checkinDate;
            const bookedDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

            if (bookedDays <= 0) {
                paymentInput.value = "Invalid dates";
                showError("Check-out date must be after check-in date.");
                return;
            }

            let totalPayment = packagePrice;

            if (bookedDays > packageDays) {
                const extraDays = bookedDays - packageDays;
                totalPayment += extraDays * extraDayRate;
            }

            totalPayment += extraPax * extraPaxRate;

            if (checkinDate.getDay() === 5 || checkinDate.getDay() === 6 || checkinDate.getDay() === 0) {
                totalPayment += friSunPrice;
            }

            paymentInput.value = totalPayment.toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP"
            });
        }

        checkinInput.addEventListener("change", calculateTotalPayment);
        checkoutInput.addEventListener("change", calculateTotalPayment);
        extraPaxInput.addEventListener("input", calculateTotalPayment);

        calculateTotalPayment();
    </script>
</body>
</html>
