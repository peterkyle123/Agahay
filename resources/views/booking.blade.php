    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Form</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;  
                background-color: #f4f4f4;
                background: url('{{ asset("images/Green.jpg") }}') no-repeat center center fixed;
                background-size: cover;
                background-position: center;
                overflow-y: auto;

            }

            /* Centering form container */
            .form-container {
                background-color: rgba(255, 255, 255, 0.8);
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                width: 90%;
                max-width: 900px;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: flex-start;
                margin-top: 150px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .form-title {
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                width: 100%;
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
            }

            .submit-btn:hover {
                background-color: #0056b3;
            }

            .full-width {
                width: 100%;
            }

            /* Success message styling */
            .success-message {
                background-color: #28a745;
                color: white;
                padding: 12px;
                text-align: center;
                border-radius: 8px;
                margin-bottom: 20px;
                width: 100%;
                max-width: 900px;
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                .form-container {
                    flex-direction: column;
                    align-items: center;
                }

                .input-container {
                    width: 100%;
                }
            }

            .no-border-button {
    border: none;
}
        </style>
    </head>
    <body>
    </div>
        @if(session('tracking_code'))
    <div id="tracking-code-alert" class="tracking-code-alert">
        <strong>Screenshot or save Your Tracking Code: </strong>{{ session('tracking_code') }}
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', () => { // Use DOMContentLoaded
            const trackingCodeAlert = document.getElementById('tracking-code-alert');
            setTimeout(() => {
                trackingCodeAlert.style.display = 'none';
            }, 10000); // 10 seconds

            fetch("{{ route('clear.tracking.code') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            });
        });
   
        // Remove the tracking code after a few seconds (optional)
        setTimeout(function() {
            document.getElementById('tracking-code-alert').style.display = 'none';
        }, 10000); // 10 seconds

        // Remove tracking code from session via AJAX (to avoid it showing after refresh)
        fetch("{{ route('clear.tracking.code') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
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

    <!-- Position the success message at the top -->


    <form action="/bookform" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-container">
        <h1 class="form-title text-xs">{{ $packages->package_name }}</h1>

            @if($errors->any())
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

                  <!-- Error for Proof of Payment -->
            @if (session('error1'))
                <div class="bg-red-500 text-white p-3 rounded-md mb-4 mx-auto w-fit">
                        {{ session('error1') }}
                </div>
            @endif
            
            @if (session('error1'))
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
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required class="input-field" placeholder="Enter your phone number" pattern="^\d{11}$" maxlength="11" title="Phone number must be exactly 11 digits">
            </div>

            <div class="input-container">
                <label for="checkout">Check-out Date</label>
                <input type="date" id="checkout" name="check_out_date" required class="input-field">
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
            <label for="downpayment">Downpayment: Pay downpayment to avail cancellation of bookings</label>
            <input type="text" id="downpayment" name="downpayment" class="input-field" value="₱{{ number_format($packages->initial_payment, 2) }}" readonly>
        </div>
            <div>
                <label for="proof_of_payment">Proof of Downpayment (JPG, PNG, PDF only):</label>
                <input type="file" name="proof_of_payment" id="proof_of_payment" required>
            </div>



            <!-- Hidden fields for price calculations -->
            <input type="hidden" id="package_price" value="{{ $packages->price }}">
            <input type="hidden" id="package_days" value="{{ $packages->days_included }}">
            <input type="hidden" id="extra_pax_price" value="{{ $packages->extra_pax_price }}">
            <input type="hidden" id="extra_day_price" value="{{ $packages->extra_day_price }}">
            <input type="hidden" id="fri_sun_price" value="{{ $packages->fri_sun_price}}">
            <input type="hidden" id="package_name" name="package_name" value="{{ $packages->package_name }}">
            <div class="input-container full-width">
                <label for="total_payment">Total Payment</label>
                <input type="text" id="total_payment" name="total_payment" class="input-field" readonly>
            </div>
           
            <button class="bg-gradient-to-r from-green-500 to-green-700 submit-btn full-width" type="submit">Submit Booking</button>
        </div>
    </form>

    <script>
        // Get the input elements
        const checkinInput = document.getElementById('checkin');
    const checkoutInput = document.getElementById('checkout');
    const extraPaxInput = document.getElementById('extra_pax');
    const totalPaymentField = document.getElementById('total_payment');
    const friSunPrice = {{ $packages->fri_sun_price }};

    // Package details (replace with actual values from your database)
    const packagePrice = {{ $packages->price }}; // Price for the full package
    const packageDays = {{ $packages->number_of_days }};   // Number of days included in the package
    const extraDayRate = {{ $packages->per_day_price }};  // Charge per extra day (set as needed)
    const extraPaxRate = {{ $packages->extra_pax_price }};  // Charge per extra pax per day

    // Function to calculate total payment
    function calculateTotalPayment() {
        const checkinDate = new Date(checkinInput.value);
        const checkoutDate = new Date(checkoutInput.value);
        const extraPax = parseInt(extraPaxInput.value) || 0;

        if (isNaN(checkinDate) || isNaN(checkoutDate)) {
            totalPaymentField.value = "";
            return;
        }

        // Calculate number of days booked
        const timeDifference = checkoutDate - checkinDate;
        const bookedDays = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

        if (bookedDays <= 0) {
            totalPaymentField.value = "Invalid dates";
            return;
        }

        let totalPayment = packagePrice; // Start with package price

        // Check for extra days beyond the package limit
        if (bookedDays > packageDays) {
            const extraDays = bookedDays - packageDays;
            totalPayment += extraDays * extraDayRate;
        }
     

        // Add extra pax charges
        totalPayment += extraPax * extraPaxRate;

        // Check if check-in is Friday, Saturday, or Sunday
        if (checkinDate.getDay() === 5 || checkinDate.getDay() === 6 || checkinDate.getDay() === 0) {
                totalPayment += friSunPrice;
            }

        // Display the calculated total
        totalPaymentField.value = totalPayment.toLocaleString("en-PH", { style: "currency", currency: "PHP" });
    }

    // Attach event listeners to update total payment
    checkinInput.addEventListener("change", calculateTotalPayment);
    checkoutInput.addEventListener("change", calculateTotalPayment);
    extraPaxInput.addEventListener("input", calculateTotalPayment);

     
    </script>
    
        </div>
    </form>


        <style>
            /* Overlay filter effect */
            .tracking-code-alert {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 15px 20px;
                background: rgba(0, 255, 55, 0.8); /* Red transparent background */
                color: white; /* Ensure text is readable */
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
                z-index: 9999;
            }

            /* Full-screen background filter */
            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                pointer-events: none; /* This ensures it does not block inputs */
            }

        </style>
        <script>
        // Get the check-in and check-out date inputs
        const checkInInput = document.getElementById('checkin');
        const checkOutInput = document.getElementById('checkout');

        

        // Set the minimum check-out date to be the selected check-in date
        checkinInput.addEventListener('change', function() {
            const checkinDate = checkinInput.value;
            checkoutInput.setAttribute('min', checkinDate);
            
            // Optionally, if the user selects a check-in date that is later than the current check-out date, adjust the check-out date
            if (checkoutInput.value && checkoutInput.value < checkinDate) {
                checkoutInput.value = checkinDate;
            }
        });
  
    </script>
    <script src="{{ asset('js/booking.js') }}"></script>
    </body>
    </html>
