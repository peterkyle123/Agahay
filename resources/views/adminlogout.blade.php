<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Agahay Guesthouse Admin</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Confirm Logout</h1>
        <p class="text-gray-600 mb-6">Are you sure you want to log out?</p>

        <div class="flex justify-center gap-4">
            <!-- Logout Button -->
            <form action="/adminhome12" method="GET">
                <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-500 transition font-medium">
                    Logout
                </button>
            </form>
            
            <!-- Cancel Button -->
            <a href="{{ route('dashboard') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-medium">
                Cancel
            </a>
        </div>
    </div>

</body>
</html>
