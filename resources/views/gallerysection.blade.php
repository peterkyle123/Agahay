<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gradient-to-r from-white-600 to-white-300 min-h-screen flex flex-col">
<button class="bg-gradient-to-r from-green-500 to-green-700 m-4 absolute text-white text-2xl font-medium px-4 py-2 rounded shadow"><a href="/">Back</a></button>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8 text-white">Gallery</h1>
<div>

   
    <!-- Image Gallery with Alpine.js -->
    <div x-data="{ showImage: false, activeImage: '' }">
        <div class="flex flex-wrap justify-center gap-6">
            @php
                $images = [
                    ['path' => 'images/8.jpg', 'title' => 'Beautiful Sunset'],
                    ['path' => 'images/image2.jpg', 'title' => 'Mountain Peak'],
                    ['path' => 'images/image3.jpg', 'title' => 'Serene Beach'],
                    ['path' => 'images/image4.jpg', 'title' => 'City Lights'],
                    ['path' => 'images/image5.jpg', 'title' => 'Forest Trail'],
                    ['path' => 'images/image6.jpg', 'title' => 'Desert Dunes'],
                ];
            @endphp

            @foreach($images as $image)
                <div class="bg-white rounded-lg shadow-md overflow-hidden w-64 transform transition-all duration-300 hover:scale-105 hover:shadow-xl cursor-pointer"
                     @click="activeImage = '{{ asset($image['path']) }}'; showImage = true">
                    <img src="{{ asset($image['path']) }}" alt="{{ $image['title'] }}" 
                         class="w-full h-64 object-cover">
                    <div class="p-4 text-center">
                        <h2 class="text-lg font-semibold text-green-800">{{ $image['title'] }}</h2>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal for Enlarged Image -->
        <div x-show="showImage"
             x-transition:enter="transition-opacity duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
             @click="showImage = false"
             style="display: none;">
            
            <!-- Image Container -->
            <div class="relative bg-green p-4 rounded-lg shadow-lg max-w-4xl mx-auto"
                 @click.stop>
                <!-- Close Button -->
                <button @click="showImage = false"
                        class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full shadow-md hover:bg-red-700 transition">
                    &times;
                </button>
                
                <!-- Enlarged Image -->
                <img :src="activeImage" class="max-w-full max-h-[80vh] rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</div>

</body>
</html>
