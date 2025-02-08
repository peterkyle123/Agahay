<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
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
    <div class="overflow-x-auto whitespace-nowrap bg-white p-4 shadow-lg rounded-lg mt-6 w-full max-w-screen-lg" id="gallery-scroll">
        <div class="flex gap-4">
            @forelse($galleryItems as $item)
                <div class="bg-white rounded-lg p-3 shadow-md min-w-[250px] max-w-[250px]">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->image_name }}" class="w-full h-48 object-cover rounded-md">
                    <p class="text-center mt-2 text-gray-700">{{ $item->description }}</p>
                </div>
            @empty
                <p class="text-gray-500">No images found in the gallery.</p>
            @endforelse
        </div>
    </div>

    <script>
        // Drag to Scroll Feature
        const slider = document.getElementById('gallery-scroll');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => isDown = false);
        slider.addEventListener('mouseup', () => isDown = false);
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    </script>

</body>
</html>
