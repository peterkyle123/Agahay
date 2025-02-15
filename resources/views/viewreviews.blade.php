<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Admin</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{asset('images/palm-tree.png')}}" type="image/x-icon">
</head>
<body class="bg-gradient-to-b from-green-50 to-green-100 min-h-screen">

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

        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 overflow-x-auto"> <table class="min-w-full divide-y divide-gray-200 table-auto"> <thead class="bg-green-50">
                    <tr>
                        <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-left text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th scope="col" class="px-3 py-2 md:px-6 md:py-3 text-right text-xs md:text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr class="hover:bg-green-50">
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm text-gray-800">{{ $review->name }}</td>
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $review->email ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm text-gray-800">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <span class="text-yellow-500">★</span>
                                @endfor
                            </td>
                            <td class="px-3 py-2 md:px-6 md:py-4 text-sm text-gray-800">
                                <p class="line-clamp-3">{{ $review->message }}</p>
                            </td>
                            <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs md:text-base" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>