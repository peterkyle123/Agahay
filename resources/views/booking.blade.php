<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Form</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f4f4f4;
      background: url('{{ asset("images/Green.jpg") }}') no-repeat center center fixed;
      background-size: cover;
      background-position: center;
      overflow-y: auto;
    }
    .form-container {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 900px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: flex-start;
      margin: 50px auto;
    }
    .form-title {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      width: 100%;
      margin-bottom: 20px;
    }
    .input-container {
      width: 48%;
      margin-bottom: 15px;
    }
    .input-field, textarea {
      width: 100%;
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      color: #333;
      box-sizing: border-box;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-size: 14px;
      color: #555;
      text-align: left;
    }
    .submit-btn {
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px;
      font-size: 16px;
      width: 100%;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }
    .submit-btn:hover {
      background-color: #0056b3;
    }
    .full-width {
      width: 100%;
    }
    .success-message {
      background-color: #28a745;
      color: white;
      padding: 12px;
      text-align: center;
      border-radius: 8px;
      margin-bottom: 20px;
      width: 100%;
    }
    /* Responsive Adjustments for Tablets */
    @media (max-width: 768px) {
      .form-container {
        flex-direction: column;
        align-items: center;
      }
      .input-container {
        width: 100%;
      }
    }
    /* Responsive Adjustments for Phones */
    @media (max-width: 480px) {
      .form-container {
        padding: 20px;
      }
      .form-title {
        font-size: 20px;
      }
      .input-field, textarea {
        font-size: 14px;
        padding: 8px;
      }
      label {
        font-size: 13px;
      }
      .submit-btn {
        font-size: 14px;
        padding: 10px;
      }
    }
    .no-border-button {
      border: none;
    }
    .tracking-code-alert {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 15px 20px;
      background: rgba(0, 255, 55, 0.8);
      color: white;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
      z-index: 9999;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      pointer-events: none;
    }
  </style>
</head>
<body>
  @if(session('tracking_code'))
    <div id="tracking-code-alert" class="tracking-code-alert">
      <strong>Screenshot or save Your Tracking Code: </strong>{{ session('tracking_code') }}
    </div>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const trackingCodeAlert = document.getElementById('tracking-code-alert');
        setTimeout(() => { trackingCodeAlert.style.display = 'none'; }, 10000);
        fetch("{{ route('clear.tracking.code') }}", {
          method: "POST",
          headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Content-Type": "application/json" },
          body: JSON.stringify({})
        });
      });
    </script>
  @endif

  <div class="absolute top-4 left-4 flex justify-between w-full z-50">
    <div class="flex space-x-4">
      <button class="bg-white text-green-800 px-4 py-2 rounded-md font-semibold shadow-sm hover:bg-gray-100 transition-colors duration-300 ease-in-out no-border-button">
        <a href="/">Home</a>
      </button>
      <button class="bg-white text-green-700 px-4 py-2 rounded-md font-semibold shadow-sm hover:bg-gray-100 transition-colors duration-300 ease-in-out">
        <a href="{{ route('book') }}">Back</a>
      </button>
    </div>
    <div class="flex">
      <button class="bg-white text-green-700 px-4 py-2 rounded-md font-semibold shadow-sm hover:bg-gray-100 transition-colors duration-300 ease-in-out mr-8">
        <a href="{{ route('user.calendar') }}">Calendar</a>
      </button>
    </div>
  </div>

  <form action="/bookform" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-container">
      <h1 class="form-title">{{ $packages->package_name }}</h1>

      @if($errors->any())
        <div>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
      @endif

      @if(session('error1'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4 mx-auto w-fit">
          {{ session('error1') }}
        </div>
      @endif

      <div class="input-container">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="customer_name" required class="input-field" placeholder="Enter your full name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
      </div>
      <div class="input-container">
        <label for="guest_name">Name of Guest (if different from customer)</label>
        <input type="text" name="guest_name" id="guest_name" required class="input-field" placeholder="Enter guest name">
      </div>
      <div class="input-container">
        <label for="checkin">Check-in Date</label>
        <input type="date" id="checkin" name="check_in_date" required class="input-field">
      </div>
      <div class="input-container">
        <label for="check_in_time">Check In Time</label>
        <input type="time" id="check_in_time" name="check_in_time" class="input-field" value="{{ $packages->check_in_time }}" readonly>
    </div>
      <div class="input-container">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" required class="input-field" placeholder="Enter your phone number" pattern="^\d{11}$" maxlength="11" title="Phone number must be exactly 11 digits">
      </div>
      <div class="input-container">
        <label for="checkout">Check-out Date</label>
        <input type="date" id="checkout" name="check_out_date" required class="input-field">
      </div>
      <div class="input-container">
        <label for="check_out_time">Check Out Time</label>
        <input type="time" id="check_out_time" name="check_out_time" class="input-field" value="{{ $packages->check_out_time }}" readonly>
    </div>
      <div class="input-container">
        <label for="extra_pax">Extra Pax</label>
        <input type="number" id="extra_pax" name="extra_pax" required class="input-field" placeholder="Extra Pax?" min="0" step="1">
      </div>
      <div class="input-container full-width">
        <label for="special_requests">Special Requests</label>
        <textarea id="special_requests" name="special_request" class="input-field" placeholder="Any special requests?" rows="4"></textarea>
      </div>
      <div class="input-container full-width">
        <label for="downpayment">Downpayment: Check Payment Method</label>
        <input type="text" id="downpayment" name="downpayment" class="input-field" value="₱{{ number_format($packages->initial_payment, 2) }}" readonly>
        <!-- Payment Methods Button -->
        <button id="showPaymentBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2">
            View Payment Methods
        </button>
    </div>
      <div>
        <label for="proof_of_payment">Proof of Downpayment (JPG, PNG, PDF only):</label>
        <input type="file" name="proof_of_payment" id="proof_of_payment" required>
      </div>

      <!-- Hidden fields for price calculations -->
      <input type="hidden" id="package_price" value="{{ $packages->price }}">
      <!-- Use number_of_days if that’s the correct property -->
      <input type="hidden" id="package_days" value="{{ $packages->number_of_days }}">
      <input type="hidden" id="extra_pax_price" value="{{ $packages->extra_pax_price }}">
      <input type="hidden" id="extra_day_price" value="{{ $packages->per_day_price }}">
      <input type="hidden" id="fri_sun_price" value="{{ $packages->fri_sun_price }}">
      <input type="hidden" id="package_name" name="package_name" value="{{ $packages->package_name }}">

      <!-- For customer booking, discount remains 0 -->
      <input type="hidden" id="discount_value" name="discount" value="0">

      <div class="input-container full-width">
        <!-- Set the computed payment as plain numeric string -->
        <label for="total_payment">Total Payment</label>
        <input type="text" id="total_payment" name="payment" class="input-field" readonly>

      </div>
      <button class="bg-gradient-to-r from-green-500 to-green-700 submit-btn full-width" type="submit">Submit Booking</button>
    </div>
  </form>
<!-- Payment Methods Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg relative w-full max-w-sm overflow-y-auto max-h-screen text-center">
        <h2 class="text-2xl font-bold mb-4">Payment Methods</h2>
        <ul class="space-y-4">
            @foreach($paymentMethods as $method)
            <li class="mb-2">
                <strong>{{ $method->name }}</strong>: {{ $method->account_number }} - {{ $method->account_name }}
                @if($method->qr_code_image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $method->qr_code_image) }}" alt="QR Code for {{ $method->name }}" class="w-64 h-auto mx-auto">
                    </div>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>


  <!-- JavaScript Section -->
  <script>

document.addEventListener("DOMContentLoaded", function() {
      const showPaymentBtn = document.getElementById('showPaymentBtn');
      const paymentModal = document.getElementById('paymentModal');

      // Show modal on button click
      showPaymentBtn.addEventListener('click', function() {
          paymentModal.classList.remove('hidden');
      });

      // Close modal when clicking outside the modal content
      paymentModal.addEventListener('click', function(event) {
          if (event.target === paymentModal) {
              paymentModal.classList.add('hidden');
          }
      });
  });
    // Retrieve input elements
    const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const extraPaxInput = document.getElementById('extra_pax');
    const totalPaymentField = document.getElementById('total_payment');
    const friSunPrice = parseFloat(document.getElementById('fri_sun_price').value);

    // Package details from hidden inputs
    const packagePrice = parseFloat(document.getElementById('package_price').value);
    const packageDays = parseInt(document.getElementById('package_days').value);
    const extraDayRate = parseFloat(document.getElementById('extra_day_price').value);
    const extraPaxRate = parseFloat(document.getElementById('extra_pax_price').value);

    // Function to calculate total payment
    function calculateTotalPayment() {
      const checkinDate = new Date(checkinInput.value);
      const checkoutDate = new Date(checkoutInput.value);
      const extraPax = parseInt(extraPaxInput.value) || 0;

      if (isNaN(checkinDate) || isNaN(checkoutDate)) {
        totalPaymentField.value = "";
        return;
      }

      // Calculate booked days (inclusive: same day counts as 1)
      const timeDifference = checkoutDate - checkinDate;
      const bookedDays = Math.floor(timeDifference / (1000 * 60 * 60 * 24)) + 1;
      console.log("Booked Days:", bookedDays, "Package Days:", packageDays);

      if (bookedDays <= 0) {
        totalPaymentField.value = "Invalid dates";
        return;
      }

      let totalPayment = packagePrice;

      // Extra days calculation: if bookedDays > packageDays, add extra day charges
      if (bookedDays > packageDays) {
        const extraDays = bookedDays - packageDays;
        console.log("Extra Days:", extraDays);
        totalPayment += extraDays * extraDayRate;
      } else {
        console.log("No extra days");
      }

      // Add extra pax charges
      totalPayment += extraPax * extraPaxRate;

      // If check-in day is Friday (5), Saturday (6) or Sunday (0), add weekend surcharge
      if ([5, 6, 0].includes(checkinDate.getDay())) {
        totalPayment += friSunPrice;
      }

      // Subtract discount (hidden, always 0 for customer view)
      const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
      totalPayment -= discountValue;

      console.log("Total Payment computed:", totalPayment);
      // Set the numeric value as a plain number with two decimals for submission
      totalPaymentField.value = totalPayment.toFixed(2);
    }

    // Attach event listeners for recalculation
    checkinInput.addEventListener("change", calculateTotalPayment);
    checkoutInput.addEventListener("change", calculateTotalPayment);
    extraPaxInput.addEventListener("input", calculateTotalPayment);
  </script>

  <script>
    // Ensure checkout date is not before check-in date
    const checkInInput = document.getElementById('checkin');
    const checkOutInput = document.getElementById('checkout');
    checkInInput.addEventListener('change', function() {
      const checkinDate = checkInInput.value;
      checkOutInput.setAttribute('min', checkinDate);
      if (checkOutInput.value && checkOutInput.value < checkinDate) {
        checkOutInput.value = checkinDate;
      }
    });
  </script>
      <script src="{{ asset('js/booking.js') }}"></script>
</body>
</html>
