<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Revenues</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white">
    <div class="min-h-screen p-6">
             <!-- Header -->
             <header class="bg-white dark:bg-gray-900 h-20 w-full flex items-center fixed top-0 left-0 z-50 shadow-md">
                <nav class="flex justify-start space-x-8 ml-6">
                    <a href="/packages" class="text-green-600 hover:text-green-900 text-s">Back</a>
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

        <div class="bg-white rounded-xl shadow-lg p-6 mt-24">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Revenues from Completed Bookings</h2>

            <form action="{{ route('total.revenues') }}" method="GET" class="mb-4">
                <div class="flex items-center space-x-4">
                    <label for="package_name" class="block text-sm font-medium text-gray-700">Filter by Package:</label>
                    <select name="package_name" id="package_name" class="mt-1 p-2 border rounded-md">
                        <option value="">All Packages</option>
                        @foreach($packages as $package)
                            <option value="{{ $package }}" {{ request('package_name') == $package ? 'selected' : '' }}>{{ $package }}</option>
                        @endforeach
                    </select>

                    <label for="filter" class="block text-sm font-medium text-gray-700">Filter By:</label>
                    <select name="filter" id="filter" class="mt-1 p-2 border rounded-md">
                        <option value="total">Total</option>
                        <option value="date_range">Date Range</option>
                    </select>

                    <div id="dateRangeInputs" class="flex space-x-4 {{ request('filter', 'total') == 'date_range' ? '' : 'hidden' }}">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 p-2 border rounded-md" value="{{ $startDate ?? '' }}">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 p-2 border rounded-md" value="{{ $endDate ?? '' }}">
                        </div>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Filter</button>
                    <button type="button" onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Print Report</button>
                </div>
            </form>

            @if(isset($filteredRevenues))
                <p class="text-lg">
                    <strong>Gross Revenue:</strong> ₱{{ number_format($filteredRevenues, 2) }}
                </p>
            @endif

            @if(isset($bookingsForTable) && count($bookingsForTable) > 0)
                <table class="min-w-full bg-white shadow-md rounded-lg mt-4">
                    <thead>
                        <tr class="text-gray-800 border-b">
                            <th class="px-4 py-2 text-left">Tracking Code</th>
                            <th class="px-4 py-2 text-left">Customer Name</th>
                            <th class="px-4 py-2 text-left">Package Name</th>
                            <th class="px-4 py-2 text-left">Check-in Date</th>
                            <th class="px-4 py-2 text-left">Check-out Date</th>
                            <th class="px-4 py-2 text-left">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingsForTable as $booking)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $booking->tracking_code}}</td>
                                <td class="px-4 py-2">{{ $booking->customer_name }}</td>
                                <td class="px-4 py-2">{{ $booking->package_name }}</td>
                                <td class="px-4 py-2">{{ $booking->check_in_date }}</td>
                                <td class="px-4 py-2">{{ $booking->check_out_date }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $numericPayment = preg_replace('/[^0-9.]/', '', $booking->payment);
                                        if (is_numeric($numericPayment)) {
                                            echo '₱' . number_format(floatval($numericPayment), 2);
                                        } else {
                                            echo 'Invalid Payment';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('filter').addEventListener('change', function() {
            if (this.value === 'date_range') {
                document.getElementById('dateRangeInputs').classList.remove('hidden');
            } else {
                document.getElementById('dateRangeInputs').classList.add('hidden');
            }
        });

        document.getElementById('start_date').addEventListener('change', function() {
            let startDate = this.value;
            document.getElementById('end_date').setAttribute('min', startDate);
            let endDateInput = document.getElementById('end_date');
            if (endDateInput.value && endDateInput.value < startDate){
                endDateInput.value = startDate;
            }
        });
    </script>
</body>
</html>
