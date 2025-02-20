<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Revenues</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="white">
    <div class="min-h-screen p-6">
        <header class="bg-gradient-to-r from-green-500 to-green-800 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
            <span class="text-white">Total Revenues</span>
            <div class="flex space-x-4">
                <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                    Home
                </a>
            </div>
        </header>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Revenues from Completed Bookings</h2>

            <form action="{{ route('total.revenues') }}" method="GET" class="mb-4">
                <div class="flex items-center space-x-4">
                    <label for="filter" class="block text-sm font-medium text-gray-700">Filter By:</label>
                    <select name="filter" id="filter" class="mt-1 p-2 border rounded-md">
                        <option value="total">Total</option>
                        <option value="date_range">Date Range</option>
                    </select>

                    <div id="dateRangeInputs" class="flex space-x-4 hidden">
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
                </div>
            </form>

            @if(isset($filteredRevenues))
                <p class="text-lg">
                    <strong>Revenues:</strong> ₱{{ number_format($filteredRevenues, 2) }}
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
                                <td class="px-4 py-2">{{ $booking->tracking_code }}</td>
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