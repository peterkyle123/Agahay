<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">

<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        margin: 0;
        padding: 0; /* Remove default padding */
        background: url('{{ asset("images/Green.jpg") }}') no-repeat center center fixed;
        background-size: cover;
        display: flex; /* Use flexbox for vertical centering */
        flex-direction: column; /* Align items vertically */
        min-height: 100vh; /* Ensure full viewport height */
    }

    .black {
        color: white;
    }

    .header {
        background: none; /* Light green gradient */
        color: white;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: none;
    }

    .header h1 {
        font-size: 24px;
        margin-left: 20px;
    }

    .home-btn {
        background-color: white;
        color: #2e7d32;
        padding: 8px 16px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 8px;
        text-decoration: none;
        margin-right: 20px;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        transition: background 0.3s ease;
    }

    .home-btn:hover {
        background-color: #e0e0e0;
    }

    .content-wrapper {  /* Added wrapper for content */
        flex: 1; /* Allow content to take up available space */
        padding: 20px; /* Add padding to content area */
    }

    .option-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 40px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .option {
        width: 400px;
        height: 400px;
        color: white;
        border-radius: 15px;
        cursor: pointer;
        transition: 0.3s;
        text-align: center;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-bottom: 20px;
        background-size: cover;
        background-position: center;
        text-decoration: none;
        overflow: hidden;
        position: relative;
    }

    .option:hover {
        transform: scale(1.05);
    }

    .option img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }

    .option-text {
        padding: 20px;
        font-size: 24px;
        font-weight: bold;
        background: rgba(0, 0, 0, 0.6);
    }

    .description-text {
        padding: 20px;
        font-size: 14px;
        font-weight: normal;
        text-align: justify;
        background: rgba(0, 0, 0, 0.6);
    }
    .option.disabled {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
}

.overlay.red-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 0, 0, 0.7);
    width: auto; /* Allow width to adjust to content */
    height: auto; /* Allow height to adjust to content */
    padding: 10px 20px;
    border-radius: 5px;
    z-index: 0; /* Ensure the filter is behind the text */
}

.overlay-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    white-space: nowrap;
    z-index: 100; /* Ensure the text is in front of the filter */
}

@media (max-width: 768px) {
    .overlay.red-overlay {
        padding: 8px 16px;
    }
}

@media (max-width: 480px) {
    .overlay.red-overlay {
        padding: 6px 12px;
    }
}

</style>
<body>
    <!-- Terms & Conditions Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50 transition-opacity duration-300">
    <div class="bg-white p-8 rounded-lg shadow-2xl max-w-lg w-full text-center relative">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Terms and Conditions</h2>
        <div class="overflow-y-auto max-h-64 px-2 text-gray-700 text-justify border-t pt-4">
            <p>By proceeding with the booking, you agree to abide by all resort policies, including downpayment fees, refund policies, and other regulations set forth by Agahay Guesthouse Resort.</p>
            <ul class="mt-3 list-disc list-inside text-sm">
                <li>To book, customers must pay the downpayment and upload proof of payment.</li>
                <li>Customers may cancel their booking at least 4 days before the check-in date. Late cancellations will result in NO REFUND of the downpayment.</li>
                <li>Editing booking info is allowed only if the admin has not yet approved the booking. Once confirmed, editing is no longer possible.</li>
                <li>The admin has the right to decline a booking, and the customer will be informed beforehand.</li>
                <li>Booking details, especially contact information, must be accurate and up to date.</li>
            </ul>
        </div>
        <div class="mt-6 flex justify-center gap-4">
            <button id="agreeBtn" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                I Agree
            </button>
            <button id="closeModal" class="text-gray-500 hover:text-gray-700 transition">
                Close
            </button>
        </div>
    </div>
</div>


<header class="header">
    <a href="/" class="home-btn">Back</a>
</header>

<div class="content-wrapper"> <div class="option-container">  @foreach ($packages as $package)
<a href="{{ $package->available ? route('frm', ['package_id' => $package->package_id]) : '#' }}"
   class="option {{ $package->available ? '' : 'disabled' }}"
   style="background-image: url('{{ asset($package->image) }}');">

    <div class="option-text">{{ $package->package_name }}</div>

    <div class="description-text">
        {{ $package->description }} <br>
        <strong>₱{{ number_format($package->price, 2) }}</strong> |
        Up to {{ $package->number_of_guests }} guests <br>
        <span style="color: red;">Extra Pax: ₱{{ number_format($package->extra_pax_price, 2) }} per person</span>
        <strong>Downpayment ₱{{ number_format($package->initial_payment, 2) }}</strong> |
    </div>

    @if(!$package->available)
    <div class="overlay red-overlay">
    <strong style="font-size:24px;">Not Available</strong>
    </div>
@endif



</a>

    @endforeach
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const termsModal = document.getElementById("termsModal");
    const agreeBtn = document.getElementById("agreeBtn");

    // Ensure modal is displayed if the user hasn't agreed
    if (!localStorage.getItem("agreedToTerms")) {
        termsModal.style.display = "flex";
    }

    // User must click "I Agree" to proceed
    agreeBtn.addEventListener("click", function () {
        localStorage.setItem("agreedToTerms", "true");
        termsModal.style.display = "none";
    });

    // Prevent closing the modal by clicking outside it
    termsModal.addEventListener("click", function (event) {
        if (event.target === termsModal) {
            event.stopPropagation();
        }
    });
});
</script>
</body>
</html>
