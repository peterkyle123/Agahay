<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Admin</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="white min-h-screen">

    <!-- Header -->
    <header class="bg-gradient-to-r from-green-500 to-green-800 text-white text-xl font-bold p-4 rounded-lg w-full flex justify-between items-center">
        <span>Reviews</span>
        <a href="/dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
            Home
        </a>
    </header>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Reviews Container (4 per row on large screens) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
        @foreach ($reviews as $review)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold text-green-800">{{ $review->name }}</h3>
                <p class="text-sm text-gray-500">{{ $review->email ?? 'N/A' }}</p>
                
                <!-- Rating -->
                <div class="flex my-2">
                    @for ($i = 0; $i < $review->rating; $i++)
                        <span class="text-yellow-500 text-lg">★</span>
                    @endfor
                </div>

                <!-- Message -->
                <p class="text-gray-700 line-clamp-3">{{ $review->message }}</p>

                <!-- Uploaded Image -->
                @if ($review->img_upld)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $review->img_upld) }}" 
                             alt="Uploaded Image" 
                             class="w-full h-40 object-cover rounded-md cursor-pointer hover:opacity-80 transition"
                             onclick="openModal('{{ asset('storage/' . $review->img_upld) }}')">
                    </div>
                @endif

                <!-- Delete Button -->
                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition w-full"
                            onclick="return confirm('Are you sure you want to delete this review?')">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center hidden">
        <div class="relative">
            <button onclick="closeModal()" class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl">×</button>
            <img id="modalImage" src="" class="max-w-full max-h-screen rounded-lg shadow-lg">
        </div>
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>

</body>
</html>
