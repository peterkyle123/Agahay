<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0Hhonpy0DGIFX37fBO4pNAcJdLjkHL5vBLadYYyIO2gQWXzOCGkgjb4BjS6D2WTRwiGGQzlCSw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100">
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

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Payment Methods</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 max-w-lg mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('payment_methods.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow transition duration-300 ease-in-out flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Payment Method
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Display Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($paymentMethods as $method)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $method->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $method->account_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $method->account_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $method->display ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $method->display ? 'Display' : "Not Displayed" }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('payment_methods.edit', $method) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded-md transition duration-300 ease-in-out flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('payment_methods.destroy', $method) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md transition duration-300 ease-in-out flex items-center" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    </form>
                                    <form action="{{ route('payment_methods.toggleDisplay', $method) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md transition duration-300 ease-in-out flex items-center">
                                            <i class="fas fa-eye{{ $method->display ? '-slash' : '' }} mr-1"></i> {{ $method->display ? 'Hide' : 'Display' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
