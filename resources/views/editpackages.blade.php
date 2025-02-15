<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
</head>

<body class="bg-gray-100 flex flex-col items-center min-h-screen">

    <!-- Header -->
    <header class="bg-green-700 text-white text-xl font-bold p-4 rounded-lg w-full flex justify-between items-center">
        <span>Packages</span>
        <div> <a href="/dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
            Home
        </a>
        <a href="/packages" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
           Back
        </a>
        </div>
       
    

    </header>
 <!-- Main Container -->
 <div class="flex-grow flex items-center justify-center w-full">
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
        <label class="block font-semibold mb-1">Price Per Day (₱)</label>
        <input type="number" name="per_day_price" value="{{ $packages->per_day_price }}" 
               class="w-full border p-2 rounded" required min="0" 
               oninput="validatePrice(this)">
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
