<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .gallery-container {
            width: 100%;
            max-width: 100vw;
            padding: 15px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(4, auto);
            gap: 15px;
            justify-content: center;
        }

        .gallery-item {
            background: white;
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .upload-form {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .upload-form h2 {
            margin-bottom: 15px;
            text-align: center;
        }

        .upload-form label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        .upload-form input,
        .upload-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .upload-form button {
            width: 100%;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .upload-form button:hover {
            background: darkgreen;
        }

        .delete-button {
            display: block;
            width: 200px;
            padding: 12px;
            margin: 20px auto;
            background: red;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .delete-button:hover {
            background: darkred;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="white">
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



<form class="upload-form  mt-28 p-6 bg-gray-100 rounded-lg shadow-md w-1/2 mx-auto" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>Upload an Image</h2>
    <label for="image">Choose an image:</label>
    <input type="file" name="image" id="image" required>
    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>
    <button type="submit">Upload</button>
</form>

<form id="deleteForm" action="{{ route('gallery.destroyMultiple') }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="gallery-container">
        @forelse($galleryItems as $item)
            <div class="relative gallery-item">
                <label class="absolute top-2 left-2 bg-white bg-opacity-90 p-1 rounded-md cursor-pointer">
                    <input type="checkbox" name="selectedImages[]" value="{{ $item->id }}" class="hidden peer">
                    <span class="w-5 h-5 inline-flex items-center justify-center border border-gray-500 rounded-md peer-checked:bg-gray-700 peer-checked:text-white">
                        ✓
                    </span>
                </label>
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->image_name }}">
                <p class="text-center mt-2 text-gray-700">{{ $item->description }}</p>
            </div>
        @empty
            <p class="text-gray-500">No images found in the gallery.</p>
        @endforelse
    </div>
    <button type="submit" class="delete-button">Delete Selected</button>
</form>

<script>
    document.getElementById('deleteForm').addEventListener('submit', function (e) {
        const checkedBoxes = document.querySelectorAll('input[name="selectedImages[]"]:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert("Please select at least one image to delete.");
        }
    });
</script>
</body>
</html>
