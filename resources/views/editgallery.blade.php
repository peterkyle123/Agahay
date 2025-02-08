<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - {{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #a8e6a3, #d4f5c5);
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Upload Form */
        .upload-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
            text-align: center;
        }

        input[type="file"],
        textarea,
        button {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            background: linear-gradient(135deg, #5ba85b, #3c7c3c);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #3c7c3c, #5ba85b);
            transform: scale(1.05);
        }

        /* Horizontal Scroll Gallery */
        /* Improved Gallery Container */
        .gallery-container {
    width: 100%; /* Full width */
    max-width: 100vw; /* Prevents overflow beyond viewport */
    padding: 15px;
    border-radius: 10px;
    background: white;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    overflow-x: auto; /* Enables horizontal scrolling */
    overflow-y: hidden; /* Prevents vertical scrolling */
    display: flex;
    flex-direction: row; /* Ensures horizontal layout */
    flex-wrap: nowrap; /* Prevents wrapping */

    gap: 15px; /* Space between images */
    scrollbar-width: none; /* Hides scrollbar for Firefox */
    -ms-overflow-style: none; /* Hides scrollbar for IE/Edge */
    white-space: nowrap; /* Ensures items stay in one row */
}

/* Hide scrollbar for Webkit browsers (Chrome, Safari) */
.gallery-container::-webkit-scrollbar {
    display: none;
    width: 100%;
}

/* Gallery Items */
.gallery-item { 
    background: white;
    border-radius: 12px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    flex: 0 0 auto; /* Prevents shrinking */
    width: 270px; /* Fixed width */
}

.gallery-item:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Image Styling */
.gallery-item img {
    width: 100%;
    height: 200px; /* Adjust height for consistency */
    object-fit: cover;
    border-radius: 8px;
}


/* Checkbox Container - Ensures Visibility */
.checkbox-container {
    position: absolute;
    top: 5px;
    left: 5px;
    background: rgba(255, 255, 255, 0.9);
    padding: 5px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

/* Hide the default checkbox */
.checkbox-container input {
    appearance: none; /* Removes default checkbox */
    width: 20px;
    height: 20px;
    border: 2px solid #3c7c3c; /* Green border */
    border-radius: 4px;
    background: white;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease-in-out;
}

/* Add checkmark when checked */
.checkbox-container input:checked {
    background: #3c7c3c; /* Green background */
    border: 2px solid #3c7c3c;
}

/* Checkmark Icon */
.checkbox-container input:checked::after {
    content: '✔'; /* Unicode checkmark */
    font-size: 16px;
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: bold;
}


/* Hover Effect */
.gallery-item:hover .checkbox-container {
    background: rgba(0, 0, 0, 0.8); /* Slightly darker on hover */
}



/* Responsive Fixes */
@media (max-width: 768px) {
    .gallery-container {
        grid-template-columns: repeat(auto-fit, minmax(100%, 1fr)); /* Single column on smaller screens */
    }

    .gallery-item {
        min-width: 100%;
        max-width: 100%;
    }

    .gallery-item img {
        height: 200px; /* Adjust for better mobile viewing */
    }
}


        /* Delete Button */
        .delete-button {
            margin-top: 25px;
            padding: 12px 25px;
            font-size: 16px;
            background: #ff4e4e;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .delete-button:hover {
            background: #d43d3d;
            transform: scale(1.05);
        }

    .upload-form {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        margin-bottom: 30px;
        text-align: center;
    }

    .upload-form h2 {
        margin-bottom: 15px;
        font-size: 20px;
    }

    .upload-form label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        text-align: left;
    }

    .upload-form input[type="file"],
    .upload-form textarea,
    .upload-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .upload-form textarea {
        resize: vertical;
        min-height: 80px;
    }

    .upload-form button {
        background: linear-gradient(135deg, #5ba85b, #3c7c3c);
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .upload-form button:hover {
        background: linear-gradient(135deg, #3c7c3c, #5ba85b);
        transform: scale(1.05);
    }
</style>




</head>
<body>
<header class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold text-2xl p-6 rounded-xl mb-6 w-full flex justify-between items-center">
    <span class="text-white">Bookings</span>
    
            <!-- Home Button -->
            <a href="dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                Home
            </a>
</header>

       <!-- Upload Form -->
        <form class="upload-form" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>Upload an Image</h2>
    <label for="image">Choose an image:</label>
    <input type="file" name="image" id="image" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>

    <button type="submit">Upload</button>
</form>

    <!-- Delete Form -->
    <form id="deleteForm" action="{{ route('gallery.destroyMultiple') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="overflow-x-auto whitespace-nowrap p-4 bg-white shadow-lg rounded-lg" id="gallery-scroll">
    <div class="flex gap-4">
        @forelse($galleryItems as $item)
            <div class="relative bg-white rounded-lg p-3 shadow-md min-w-[250px] max-w-[250px]">
                <!-- Checkbox for Deletion -->
                <label class="absolute top-2 left-2 bg-white bg-opacity-90 p-1 rounded-md cursor-pointer">
                    <input type="checkbox" name="selectedImages[]" value="{{ $item->id }}" class="hidden peer">
                    <span class="w-5 h-5 inline-flex items-center justify-center border border-gray-500 rounded-md peer-checked:bg-gray-700 peer-checked:text-white">
                        ✓
                    </span>
                </label>

                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->image_name }}" class="w-full h-48 object-cover rounded-md">
                <p class="text-center mt-2 text-gray-700">{{ $item->description }}</p>
            </div>
        @empty
            <p class="text-gray-500">No images found in the gallery.</p>
        @endforelse
    </div>
</div>


        <!-- Delete Button -->
        <button type="submit" class="delete-button">Delete Selected</button>
    </form>

    <script>
        // Drag to Scroll Feature
        const slider = document.getElementById('gallery-scroll');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });

        // Confirm before deleting
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
