<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
</head>

<body class="white flex flex-col items-center min-h-screen">

    <!-- Header -->
    <header class="bg-white dark:bg-gray-900 h-20 w-full flex items-center fixed top-0 left-0 z-50 shadow-md">
        <nav class="flex justify-start space-x-8 ml-6">
            <a href="/packages" class="text-green-600 hover:text-green-900 text-s">Back</a>
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
 <!-- Main Container -->
 <div class="flex-grow flex items-center justify-center w-full mt-24">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-2xl font-semibold text-center mb-4">Edit Package</h2>
        <!-- Display Success Message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit Package Form -->
        <form action="{{ route('editpackages.update', $packages->package_id) }}" method="POST">
    @csrf
    @method('PUT')
    @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <!-- Package Name (Text Input) -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Package Name</label>
        <input type="text" name="package_name" value="{{ $packages->package_name }}"
               class="w-full border p-2 rounded" required>
    </div>
    <!-- Description -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Description</label>
        <input type="text" name="description" value="{{ $packages->description }}"
               class="w-full border p-2 rounded" required>
    </div>
    <!-- Number of Persons -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Number of Persons</label>
        <input type="text" name="number_of_guests" value="{{ $packages->number_of_guests }}"
               class="w-full border p-2 rounded" required>
    </div>

    <!-- Base Price -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Base Price (₱)</label>
        <input type="number" name="price" value="{{ $packages->price }}"
               class="w-full border p-2 rounded" required min="0"
               oninput="validatePrice(this)">
    </div>

    <div class="mb-4">
    <label class="block font-semibold mb-1">Additional Price For Friday-Sunday (₱)</label>
    <input type="number" name="fri_sun_price" value="{{ $packages->fri_sun_price }}"
           class="w-full border p-2 rounded" required min="0"
           oninput="validatePrice(this)">
</div>



    <!-- Initial Payment -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Initial Payment (₱)</label>
        <input type="number" name="initial_payment" value="{{ $packages->initial_payment}}"
               class="w-full border p-2 rounded" required min="0"
               oninput="validatePrice(this)">
    </div>

    <!-- Number of Days -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Number of Days</label>
        <input type="number" name="number_of_days" value="{{ $packages->number_of_days }}"
               class="w-full border p-2 rounded" required min="1"
               oninput="validateDays(this)">
    </div>

    <!-- Price for Extra Pax -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Price for Extra Pax (₱)</label>
        <input type="number" name="extra_pax_price" value="{{ $packages->extra_pax_price }}"
               class="w-full border p-2 rounded" required min="0"
               oninput="validatePrice(this)">
    </div>

    <!-- Price Per Night -->
    <div class="mb-4">
        <label class="block font-semibold mb-1">Extra Day Price (₱)</label>
        <input type="number" name="per_day_price" value="{{ $packages->per_day_price }}"
               class="w-full border p-2 rounded" required min="0"
               oninput="validatePrice(this)">
    </div>
    <div class="mb-4">
    <label class="block font-semibold mb-1">Availability</label>
    <div class="flex items-center">
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="available" value="1" class="sr-only peer" {{ $packages->available ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
        </label>
    </div>
</div>
<div class="form-group">
    <label for="check_in_time">Check In Time</label>
    <input type="time" name="check_in_time" id="check_in_time" class="form-control" value="{{ old('check_in_time', $packages->check_in_time) }}" required>
</div>

<div class="form-group">
    <label for="check_out_time">Check Out Time</label>
    <input type="time" name="check_out_time" id="check_out_time" class="form-control" value="{{ old('check_out_time', $packages->check_out_time) }}" required>
</div>
    <!-- Submit & Cancel Buttons -->
    <div class="mt-6 flex justify-between">
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save Changes</button>
    </div>
</form>

<!-- JavaScript for Preventing Negative Values -->
<script>
    function validatePrice(input) {
        if (input.value < 0) {
            input.value = 0; // Prevent negative numbers
        }
    }

    function validateDays(input) {
        if (input.value < 1) {
            input.value = 1; // Minimum of 1 day required
        }
    }
</script>

</body>
</html>
