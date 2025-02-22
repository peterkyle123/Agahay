    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Statistics</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        <link rel="icon" href="{{ asset('images/palm-tree.png') }}" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="white">
        <div class="min-h-screen p-6">
            <header class="bg-gradient-to-r from-green-500 to-green-800 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
                <span class="text-white">Statistics</span>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="bg-white text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                        Home
                    </a>
                </div>
            </header>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    {{ $filter === 'canceled' ? 'Initial Payments' : 'Total Revenues' }} by Category
                </h2>

                <form action="{{ route('statistics') }}" method="GET" class="mb-4">
                    <div class="flex items-center space-x-4">
                        <label for="filter" class="block text-sm font-medium text-gray-700">Filter By:</label>
                        <select name="filter" id="filter" class="mt-1 p-2 border rounded-md">
                            <option value="total" {{ $filter === 'total' ? 'selected' : '' }}>Total</option>
                            <option value="date_range" {{ $filter === 'date_range' ? 'selected' : '' }}>Date Range</option>
                            <option value="canceled" {{ $filter === 'canceled' ? 'selected' : '' }}>Canceled Bookings</option>
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

                        <div id="canceledDateRangeInputs" class="flex space-x-4 {{ request('filter', 'canceled') == 'canceled' ? '' : 'hidden' }}">
                            <div>
                                <label for="canceled_start_date" class="block text-sm font-medium text-gray-700">Canceled Start Date</label>
                                <input type="date" name="canceled_start_date" id="canceled_start_date" class="mt-1 p-2 border rounded-md" value="{{ $canceledStartDate ?? '' }}">
                            </div>
                            <div>
                                <label for="canceled_end_date" class="block text-sm font-medium text-gray-700">Canceled End Date</label>
                                <input type="date" name="canceled_end_date" id="canceled_end_date" class="mt-1 p-2 border rounded-md" value="{{ $canceledEndDate ?? '' }}">
                            </div>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Filter</button>
                        <button type="button" onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Print Report</button>
                    </div>
                </form>

                @if(isset($revenuesByCategory) && $filter !== 'canceled')
                    <table class="min-w-full bg-white shadow-md rounded-lg mt-4">
                        <thead>
                            <tr class="text-gray-800 border-b">
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenuesByCategory as $category => $revenue)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $category }}</td>
                                    <td class="px-4 py-2">₱{{ number_format($revenue, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif(isset($initialPaymentsByCategory) && $filter === 'canceled')
                    <table class="min-w-full bg-white shadow-md rounded-lg mt-4">
                        <thead>
                            <tr class="text-gray-800 border-b">
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Total Initial Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($initialPaymentsByCategory as $category => $initialPayment)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $category }}</td>
                                    <td class="px-4 py-2">₱{{ number_format($initialPayment, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600 mt-4">No data found for the selected filters.</p>
                @endif
            </div>
        </div>

        <script>
            document.getElementById('filter').addEventListener('change', function() {
                if (this.value === 'date_range') {
                    document.getElementById('dateRangeInputs').classList.remove('hidden');
                    document.getElementById('canceledDateRangeInputs').classList.add('hidden');
                } else if (this.value === 'canceled') {
                    document.getElementById('canceledDateRangeInputs').classList.remove('hidden');
                    document.getElementById('dateRangeInputs').classList.add('hidden');
                } else {
                    document.getElementById('dateRangeInputs').classList.add('hidden');
                    document.getElementById('canceledDateRangeInputs').classList.add('hidden');
                }
            });

            document.getElementById('start_date').addEventListener('change', function() {
                let startDate = this.value;
                document.getElementById('end_date').setAttribute('min', startDate);
                let endDateInput = document.getElementById('end_date');
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = startDate;
                }
            });

            document.getElementById('canceled_start_date').addEventListener('change', function() {
                let startDate = this.value;
                document.getElementById('canceled_end_date').setAttribute('min', startDate);
                let endDateInput = document.getElementById('canceled_end_date');
                if (endDateInput.value && endDateInput.value < startDate) {
                    endDateInput.value = startDate;
                }
            });
        </script>
    </body>
    </html>