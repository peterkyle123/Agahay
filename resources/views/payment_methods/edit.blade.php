<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment Method</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 h-screen flex flex-col justify-center items-center">
    <header class="bg-white dark:bg-gray-900 h-20 w-full flex items-center fixed top-0 left-0 z-50 shadow-md">
        <nav class="flex justify-start space-x-8 ml-6">

            <a href="#" onclick="window.history.back(); return false;" class="text-green-600 hover:text-green-900 text-s">Back</a>
            <a href="/dashboard" class="text-green-600 hover:text-green-900 text-s">Home</a>
            <a href="/packages" class="text-green-600 hover:text-green-900 text-s">Packages</a>
            {{-- drop down for bookings --}}
            <div class="relative" x-data="{ open: false }">
                <button class="text-green-600 hover:text-green-900 text-s"
                    @click="open = !open">
                    Bookings ▼
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute mt-2 w-48 bg-white border rounded-lg shadow-lg z-50">
                    <a href="/approved-bookings"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Approved</a>
                    <a href="/approvedCanceled"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Canceled</a>
                    <a href="/archives"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Done</a>
                    <a href="/cancelrequestA"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Requesting for Cancellation</a>
                </div>
            </div>

            <!-- Dropdown for Revenues -->
            <div class="relative" x-data="{ open: false }">
                <button class="text-green-600 hover:text-green-900 text-s"
                    @click="open = !open">
                    Revenues ▼
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute mt-2 w-48 bg-white border rounded-lg shadow-lg z-50">
                    <a href="/total-revenues"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Done Revenues</a>
                    <a href="/approvedCanceled"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Canceled Revenues</a>
                </div>
            </div>

            <a href="/adminlogout" class="text-green-600 hover:text-green-900 text-s">Logout</a>
        </nav>
    </header>

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md mt-20">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit Payment Method</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('payment_methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Payment Method</label>
                <input type="text" name="name" value="{{ $paymentMethod->name }}" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Account Number</label>
                <input type="text" name="account_number" value="{{ $paymentMethod->account_number }}" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Account Name</label>
                <input type="text" name="account_name" value="{{ $paymentMethod->account_name }}" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">QR Code Image (optional)</label>
                <input type="file" name="qr_code_image" class="w-full p-2 border rounded-md focus:ring focus:ring-blue-200" accept="image/*">
                @if($paymentMethod->qr_code_image)
                    <div class="mt-2 text-center">
                        <img src="{{ asset('storage/' . $paymentMethod->qr_code_image) }}" alt="QR Code" class="w-32 h-auto mx-auto">
                    </div>
                @endif
            </div>
            <div class="text-center">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-300 ease-in-out">Update Payment Method</button>
            </div>
        </form>
    </div>
</body>
</html>
