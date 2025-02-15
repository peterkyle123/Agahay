<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's In?</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-green-50 to-green-100 text-gray-800">

    <!-- Navigation Bar -->
<nav class="bg-gradient-to-r from-green-600 to-green-800 shadow-md fixed w-full z-10 top-0">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <h1 class="text-3xl font-bold text-white">What's In Agahay?</h1>
            <ul class="hidden md:flex space-x-6">
                <li><a href="/" class="text-white hover:text-green-300 transition duration-300">Home</a></li>
                <li><a href="#about" class="text-white hover:text-green-300 transition duration-300">About Us</a></li>
                <li><a href="#contact" class="text-white hover:text-green-300 transition duration-300">Contact</a></li>
            </ul>
            <button class="md:hidden text-white focus:outline-none" id="menu-toggle">
                ☰
            </button>
        </div>
        <ul class="md:hidden hidden flex-col space-y-2 pb-4" id="mobile-menu">
            <li><a href="/" class="text-white hover:text-green-300 transition duration-300 block">Home</a></li>
            <li><a href="#about" class="text-white hover:text-green-300 transition duration-300 block">About Us</a></li>
            <li><a href="#contact" class="text-white hover:text-green-300 transition duration-300 block">Contact</a></li>
        </ul>
    </div>
</nav>


    <!-- Hero Section -->
    <section class="relative min-h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('images/8.jpg');">
        <div class="absolute inset-0 bg-gradient-to-b from-black via-transparent to-black opacity-70"></div>
        <div class="relative z-10 text-center text-white p-6 sm:p-10 max-w-3xl">
            <h1 class="text-3xl sm:text-5xl font-bold mb-4">A Resort Experience You Shall Never Forget!</h1>
            <a href="#services" class="mt-6 inline-block px-6 sm:px-8 py-3 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-800 transition duration-300">Get to Know Us!</a>
        </div>
    </section>

    <!-- About Us -->
    <section id="about" class="py-20 bg-gradient-to-b from-white to-green-50">
        <div class="max-w-4xl mx-auto text-center px-4">
            <img src="images/8.jpg" alt="Resort Image" class="mx-auto w-32 sm:w-40 h-32 sm:h-40 rounded-full object-cover shadow-lg">
            <h2 class="mt-4 text-3xl sm:text-4xl font-semibold">Get to <span class="text-green-600">Know Us</span></h2>
            <p class="mt-4 text-base sm:text-lg text-gray-700 leading-relaxed">
                "Agahay Resort is a peaceful haven, set amidst the beauty of nature, offering guests the perfect blend of relaxation, comfort, and adventure..."
            </p>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="py-20 bg-gradient-to-r from-green-100 to-green-200">
        <div class="max-w-6xl mx-auto text-center px-4">
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white shadow-lg rounded-lg">
                    <h3 class="text-2xl font-semibold text-green-700">Mission</h3>
                    <p class="mt-2 text-gray-600">To give you the best vacation experience!</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-lg">
                    <h3 class="text-2xl font-semibold text-green-700">Vision</h3>
                    <p class="mt-2 text-gray-600">A resort that offers the best and memorable experience that everybody can afford.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-lg">
                    <h3 class="text-2xl font-semibold text-green-700">Core Values</h3>
                    <p class="mt-2 text-gray-600">Exceptional Service, Hospitality, and Guest-Centric Values.</p>
                </div>
            </div>
        </div>
    </section>
<!-- REVIEW SECTION -->
    <section id="contact" class="py-20 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="mt-4 text-3xl sm:text-4xl font-semibold text-green-700">Get In Touch</h2>
        <p class="mt-4 text-base sm:text-lg text-gray-700 leading-relaxed">
            Have any questions? Feel free to reach out to us, and we’ll be happy to assist you.
        </p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('reviews.store') }}" method="POST" class="mt-8 space-y-4">
            @csrf  
            <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">

            <input type="email" name="email" placeholder="Your Email (Optional)" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">

            <textarea name="message" rows="4" placeholder="Your Message" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>

            <div class="flex items-center space-x-2">
                <span class="text-gray-700">Rate Us:</span>
                <div class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="star text-gray-400 text-2xl" data-value="{{ $i }}">★</button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" required>  </div>

            <button type="submit" class="w-full p-3 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-800 transition duration-300">
                Send Message
            </button>
        </form>
    </div>
</section>
<!-- STARS -->
<script>
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            let value = this.getAttribute('data-value');
            ratingInput.value = value;
            stars.forEach(s => s.classList.remove('text-yellow-500'));
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('text-yellow-500');
            }
        });
    });
</script>
    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-500 to-green-700 text-white text-center py-6">
        <p>&copy; 2025 Agahay Guesthouse. All Rights Reserved.</p>
    </footer>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
