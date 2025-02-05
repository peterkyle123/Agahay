<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking List</title>
    <!-- Add styles for table and card layout here -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-100">

    <div class="min-h-screen p-6">
        <!-- Header Section -->
        <div class="text-green-800 font-bold text-2xl mb-6">
            <span class="text-green-900">Admin</span> - View Bookings
        </div>

        <!-- Bookings List Section -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-green-800 mb-4">List of Bookings</h2>
            
            <!-- Table displaying bookings (This is static for now) -->
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="text-green-800 border-b">
                        <th class="px-4 py-2 text-left">Booking ID</th>
                        <th class="px-4 py-2 text-left">Customer Name</th>
                        <th class="px-4 py-2 text-left">Check-in Date</th>
                        <th class="px-4 py-2 text-left">Check-out Date</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Payment</th> <!-- New Payment Column -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Example data, replace with dynamic content from your database -->
                    <tr>
                        <td class="px-4 py-2">#001</td>
                        <td class="px-4 py-2">John Doe</td>
                        <td class="px-4 py-2">2025-02-10</td>
                        <td class="px-4 py-2">2025-02-12</td>
                        <td class="px-4 py-2 text-green-600">Confirmed</td>
                        <td class="px-4 py-2 text-green-600">$200</td> <!-- Payment Info -->
                    </tr>
                    <tr>
                        <td class="px-4 py-2">#002</td>
                        <td class="px-4 py-2">Jane Smith</td>
                        <td class="px-4 py-2">2025-02-15</td>
                        <td class="px-4 py-2">2025-02-17</td>
                        <td class="px-4 py-2 text-red-600">Canceled</td>
                        <td class="px-4 py-2 text-red-600">N/A</td> <!-- Payment Info -->
                    </tr>
                    <!-- Additional rows will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Placeholder for Database Connection -->
        <!-- 
        <script>
            // This is where the database connection will be established once the database is created.
            // Example for connecting to MySQL using PHP (server-side scripting):
            // 
            // <?php
            // $conn = new mysqli('localhost', 'username', 'password', 'database_name');
            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }
            // 
            // $sql = "SELECT * FROM bookings";
            // $result = $conn->query($sql);
            // if ($result->num_rows > 0) {
            //     // Output data from database here
            //     while($row = $result->fetch_assoc()) {
            //         echo "<tr><td>" . $row["booking_id"] . "</td><td>" . $row["customer_name"] . "</td><td>" . $row["check_in_date"] . "</td><td>" . $row["check_out_date"] . "</td><td>" . $row["status"] . "</td><td>" . $row["payment"] . "</td></tr>";
            //     }
            // } else {
            //     echo "No bookings found";
            // }
            // $conn->close();
            // ?>
        </script>
        -->
    </div>

</body>
</html>
