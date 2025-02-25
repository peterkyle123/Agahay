<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Filtered Bookings</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-6">
        <header class="bg-gradient-to-r from-green-500 to-green-800 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
            <span>Filtered Bookings</span>
            <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                Home
            </a>
        </header>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-green-800 mb-4">Filter Bookings</h2>
            
            <div class="flex space-x-4 mb-4">
                <button class="filter-btn bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700" data-status="Pending">Pending</button>
                <button class="filter-btn bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" data-status="Approved">Approved</button>
                <button class="filter-btn bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700" data-status="Declined">Declined</button>
            </div>

            <div id="bookings-container">
                @include('bookings_table', ['bookings' => $bookings])
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function fetchBookings(url) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(url, {
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('bookings-container').innerHTML = data;
                    attachPaginationEvents();
                })
                .catch(error => console.error('Error fetching data:', error));
            }

            function attachPaginationEvents() {
                document.querySelectorAll('#bookings-container .pagination a').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        fetchBookings(this.getAttribute('href'));
                    });
                });
            }

            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function () {
                    fetchBookings(`/filter_bookings/${this.getAttribute('data-status')}`);
                });
            });

            attachPaginationEvents();
        });
    </script>
</body>
</html>
