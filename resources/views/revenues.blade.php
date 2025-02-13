<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Revenue Dashboard</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100"> 
    <div class="min-h-screen p-6">
        <header class="bg-gradient-to-r from-blue-500 to-blue-700 text-white font-bold text-2xl p-4 rounded-xl mb-6 flex justify-between items-center">
            <span class="text-white">Revenue Dashboard</span>
            
            <!-- Home Button -->
            <a href="dashboard" class="bg-white text-blue-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition text-sm sm:text-base">
                Home
            </a>
        </header>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-blue-800 mb-4">Revenue Overview</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 shadow rounded-lg">
                    <h2 class="text-lg font-semibold">Total Revenue</h2>
                    <p class="text-2xl font-bold" id="totalRevenue">$0</p>
                </div>
                <div class="bg-white p-4 shadow rounded-lg">
                    <h2 class="text-lg font-semibold">Annual Revenue</h2>
                    <p class="text-2xl font-bold" id="annualRevenue">$0</p>
                </div>
                <div class="bg-white p-4 shadow rounded-lg">
                    <h2 class="text-lg font-semibold">Monthly Revenue</h2>
                    <p class="text-2xl font-bold" id="monthlyRevenue">$0</p>
                </div>
                <div class="bg-white p-4 shadow rounded-lg">
                    <h2 class="text-lg font-semibold">Daily Revenue</h2>
                    <p class="text-2xl font-bold" id="dailyRevenue">$0</p>
                </div>
            </div>

            <!-- Revenue Breakdown Table -->
            <div class="bg-white p-6 shadow rounded-lg overflow-x-auto">
                <h2 class="text-xl font-semibold mb-4">Revenue Breakdown</h2>
                
                <table class="w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 text-left">Date</th>
                            <th class="p-2 text-left">Daily Revenue</th>
                            <th class="p-2 text-left">Monthly Revenue</th>
                            <th class="p-2 text-left">Annual Revenue</th>
                        </tr>
                    </thead>
                    <tbody id="revenueTableBody">
                        <!-- Data will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Fetch Revenue Data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/revenue-data') // Replace with your actual route
                .then(response => response.json())
                .then(data => {
                    let totalRevenue = 0;
                    let annualRevenue = 0;
                    let monthlyRevenue = 0;
                    let dailyRevenue = 0;

                    const tableBody = document.getElementById('revenueTableBody');

                    data.forEach(item => {
                        totalRevenue += item.total_revenue;
                        annualRevenue = item.annual_revenue;
                        monthlyRevenue = item.monthly_revenue;
                        dailyRevenue = item.daily_revenue;

                        const row = tableBody.insertRow();
                        row.insertCell().textContent = item.date;
                        row.insertCell().textContent = `$${item.daily_revenue.toLocaleString()}`;
                        row.insertCell().textContent = `$${item.monthly_revenue.toLocaleString()}`;
                        row.insertCell().textContent = `$${item.annual_revenue.toLocaleString()}`;
                    });

                    document.getElementById('totalRevenue').textContent = `$${totalRevenue.toLocaleString()}`;
                    document.getElementById('annualRevenue').textContent = `$${annualRevenue.toLocaleString()}`;
                    document.getElementById('monthlyRevenue').textContent = `$${monthlyRevenue.toLocaleString()}`;
                    document.getElementById('dailyRevenue').textContent = `$${dailyRevenue.toLocaleString()}`;
                });
        });
    </script>
</body>
</html>
