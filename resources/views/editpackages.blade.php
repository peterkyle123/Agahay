<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-center mb-4">Edit Package</h2>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit Package Form -->
        <form action="{{ route('admin.updatePackage', $bookings->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Package Name</label>
                <input type="text" name="name" value="{{ $packages->package_name }}" class="w-full border p-2 rounded" required>
            </div>
    
            <div class="mb-4">
                <label class="block font-semibold mb-1">Base Price (₱)</label>
                <input type="number" name="base_price" value="{{ $bookings->package_price }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Price for Extra Pax (₱)</label>
                <input type="number" name="extra_pax_price" value="{{ $bookings->extra_pax_price }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Price Per Night (₱)</label>
                <input type="number" name="per_day_price" value="{{ $packages->per_day_price }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="/admin/packages" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
