<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Downpayment Paid</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<!-- <body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Mark Downpayment as Paid</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-2">Booking Information</h2>

            <p><strong>Tracking Code:</strong> {{ $booking->tracking_code }}</p>
            <p><strong>Customer Name:</strong> {{ $booking->customer_name }}</p>
            <p><strong>Check-in Date:</strong> {{ $booking->check_in_date }}</p>
            <p><strong>Check-out Date:</strong> {{ $booking->check_out_date }}</p>
            <p><strong>Phone:</strong> {{ $booking->phone }}</p>
            <p><strong>Payment:</strong> {{ $booking->payment }}</p>
            <p><strong>Downpayment Status:</strong> {{ $booking->downpayment }}</p>
            <p><strong>Balance:</strong> ₱{{ number_format($booking->balance, 2) }}</p>

            <form action="{{ route('admin.mark.downpayment.paid.process', $booking->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Mark Downpayment as Paid
                </button>
            </form>
        </div>
    </div>
</body> -->
</html>