<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Admin</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="white min-h-screen">
  <!-- Header -->
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
<div class="mt-24">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

      <!-- Filter Options -->
      <div class="p-6 flex justify-center space-x-4 ">
        <button onclick="filterReviews('all')" class="bg-blue-500 text-white px-4 py-2 rounded-lg">All Reviews</button>
        <button onclick="filterReviews('positive')" class="bg-green-500 text-white px-4 py-2 rounded-lg">Positive Reviews</button>
        <button onclick="filterReviews('negative')" class="bg-red-500 text-white px-4 py-2 rounded-lg">Negative Reviews</button>
    </div>

    <!-- Reviews Container (4 per row on large screens) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
        @foreach ($reviews as $review)
        <div class="bg-white shadow-md rounded-lg p-4 review-item" data-rating="{{ $review->rating }}">
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

                <!-- Feature/Unfeature Button -->
                <form action="{{ route('reviews.toggleFeature', $review->id) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition w-full">
                        {{ $review->featured ? 'Unfeature' : 'Feature' }}
                    </button>
                </form>

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
        function filterReviews(type) {
            let reviews = document.querySelectorAll('.review-item');
            reviews.forEach(review => {
                let rating = parseInt(review.getAttribute('data-rating'));
                if (type === 'all') {
                    review.style.display = 'block';
                } else if (type === 'positive' && rating >= 3) {
                    review.style.display = 'block';
                } else if (type === 'negative' && rating <= 2) {
                    review.style.display = 'block';
                } else {
                    review.style.display = 'none';
                }
            });
        }

    </script>

</body>
</html>
