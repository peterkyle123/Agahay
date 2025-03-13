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
        <form id="edit-booking-form" action="{{ route('b00kings.update.user', $booking->id) }}" method="POST">
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
                <input type="date" id="checkin" name="check_in_date" value="{{ $booking->check_in_date }}" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" min="{{ date('Y-m-d') }}">
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

            <!-- Hidden Payment Input -->
            <input type="hidden" name="payment" id="payment" value="{{ $booking->payment }}">

            <!-- Display Payment -->
            <p class="text-lg font-semibold mt-2">
                Total Payment: <span id="payment-display">₱{{ number_format($booking->payment, 2) }}</span>
            </p>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-md transition duration-300">
                Update Booking
            </button>
        </form>
    </div>

    <script>
        // Get the input elements
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        const extraPaxInput = document.getElementById('extra_pax');
        const paymentInput = document.getElementById('payment');
        const paymentDisplay = document.getElementById('payment-display');

        // Package details from the booking's package (ensure these variables are set in your controller)
        const packagePrice = {{ $booking->package->price }};
        const packageDays = {{ $booking->package->number_of_days }};
        const extraDayRate = {{ $booking->package->per_day_price }};
        const extraPaxRate = {{ $booking->package->extra_pax_price }};
        const friSunPrice = {{ $booking->package->fri_sun_price }};

        // Function to show error (simple alert for now)
        function showError(message) {
            alert(message);
        }

        // Function to calculate total payment
        function calculateTotalPayment() {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);
            let extraPax = parseInt(extraPaxInput.value) || 0;

            if (isNaN(checkinDate) || isNaN(checkoutDate)) {
                showError("Please enter valid check-in and check-out dates.");
                return;
            }

            const timeDifference = checkoutDate - checkinDate;
            const bookedDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

            if (bookedDays <= 0) {
                showError("Check-out date must be after check-in date.");
                return;
            }

            // Base package price
            let totalPayment = packagePrice;

            // Extra days charge
            if (bookedDays > packageDays) {
                const extraDays = bookedDays - packageDays;
                totalPayment += extraDays * extraDayRate;
            }

            // Extra pax charge
            if (extraPax > 0) {
                totalPayment += extraPax * extraPaxRate;
            }

            // Weekend surcharge: if check-in day is Friday (5), Saturday (6), or Sunday (0)
            if ([5, 6, 0].includes(checkinDate.getDay())) {
                totalPayment += friSunPrice;
            }

            // Update hidden input and display element
            paymentInput.value = totalPayment;
            paymentDisplay.textContent = totalPayment.toLocaleString("en-PH", { style: "currency", currency: "PHP" });
        }

        // Attach event listeners to recalc payment when fields change
        checkinInput.addEventListener("change", calculateTotalPayment);
        checkoutInput.addEventListener("change", calculateTotalPayment);
        extraPaxInput.addEventListener("input", calculateTotalPayment);

        // Ensure the payment is updated before form submission
        document.getElementById("edit-booking-form").addEventListener("submit", function(event) {
            calculateTotalPayment();
        });

        // Initial calculation on page load
        calculateTotalPayment();
    </script>
</body>
</html>
