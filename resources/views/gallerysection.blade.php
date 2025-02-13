<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }
        .modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
        }
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Larger images on PC */
            gap: 16px;
            width: 100%;
            max-width: 1400px;
            margin-top: 16px;
        }
        .gallery-item img {
            width: 100%;
            height: 300px; /* Larger height for PC */
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .gallery-container {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }
            .gallery-item img {
                height: 150px; /* Smaller height for mobile */
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 to-green-200 flex flex-col items-center p-6">

    <!-- Header -->
    <header class="bg-green-700 text-white text-xl font-bold p-4 rounded-lg w-full flex justify-between items-center">
        <span>Gallery</span>
        <a href="/" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
            Home
        </a>
    </header>

    <!-- Image Gallery -->
    <div class="gallery-container">
        @forelse($galleryItems as $item)
            <div class="gallery-item bg-transparent rounded-lg p-3 shadow-md">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->image_name }}" onclick="openModal(this.src)">
                <p class="text-center mt-2 text-gray-700">{{ $item->description }}</p>
            </div>
        @empty
            <p class="text-gray-500">No images found in the gallery.</p>
        @endforelse
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <img id="modalImage" src="" alt="">
    </div>

    <script>
        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
    </script>
</body>
</html>
