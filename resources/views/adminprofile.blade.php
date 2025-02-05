<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account - Agahay Guesthouse</title>
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .custom-bg {
            background-image: url('https://www.example.com/your-image.jpg');
            background-size: cover;
            background-position: center;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .gradient-bg {
            background: linear-gradient(to right, #2e7d32, #81c784);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex flex-col">
   <!-- Header Section -->
    <div class="bg-green-900 text-white p-4 sm:p-6 shadow-md w-full">
        <div class="flex flex-wrap items-center justify-between">
            <h1 class="text-xl sm:text-2xl font-semibold">Edit Account - Admin</h1>
            <div class="flex items-center mt-2 sm:mt-0">
                <!-- Home Button -->
                <a href="dashboard" class="bg-white text-green-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-200 transition mr-2 sm:mr-4 text-sm sm:text-base">
                    Home
                </a>
                <span class="material-icons-outlined p-2 text-lg sm:text-2xl">notifications</span>
                <div class="bg-center bg-cover bg-no-repeat rounded-full h-10 w-10 sm:h-12 sm:w-12 ml-2" 
                     style="background-image: url(https://scontent.fmnl9-1.fna.fbcdn.net/v/t39.30808-6/472249971_1016588200482999_5303754963802870843_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=sJ53QmRi1gEQ7kNvgHtI0ML&_nc_zt=23&_nc_ht=scontent.fmnl9-1.fna&_nc_gid=ApNALXX88p-GVt8qvJEgI4n&oh=00_AYArajmlVejP0zbJGSR7MccIm-o2R4kKewYaLmx2DBfeiQ&oe=67A36AC7)">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="flex flex-col lg:flex-row p-6 sm:p-10">
        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 w-full lg:w-9/12 mx-auto">
            <form>
                <div class="space-y-6 sm:space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="full-name" class="text-gray-700 font-medium text-sm sm:text-lg">Full Name</label>
                            <input id="full-name" type="text" class="w-full p-2 sm:p-3 border-2 border-green-500 rounded-lg" placeholder="Enter full name" />
                        </div>
                        <div class="space-y-2">
                            <label for="email" class="text-gray-700 font-medium text-sm sm:text-lg">Email Address</label>
                            <input id="email" type="email" class="w-full p-2 sm:p-3 border-2 border-green-500 rounded-lg" placeholder="Enter email address" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="contact" class="text-gray-700 font-medium text-sm sm:text-lg">Contact Number</label>
                            <input id="contact" type="text" class="w-full p-2 sm:p-3 border-2 border-green-500 rounded-lg" placeholder="Enter contact number" />
                        </div>
                        <div class="space-y-2">
                            <label for="role" class="text-gray-700 font-medium text-sm sm:text-lg">Role</label>
                            <input id="role" type="text" class="w-full p-2 sm:p-3 border-2 border-green-500 rounded-lg" placeholder="Enter role" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="text-gray-700 font-medium text-sm sm:text-lg">Password</label>
                            <input id="password" type="password" class="w-full p-2 sm:p-3 border-2 border-green-500 rounded-lg" placeholder="Enter password" />
                        </div>
                        <div class="space-y-2">
                            <label for="confirm-password" class="text-gray-700 font-medium text-sm sm:text-lg">Confirm Password</label>
                            <input id="confirm-password" type="password" class="w-full p-2 sm:p-3 border-2 border-green-500 rounded-lg" placeholder="Confirm password" />
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end mt-4">
                        <button type="submit" class="bg-green-700 text-white font-semibold text-sm sm:text-lg py-3 px-6 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 w-full sm:w-auto">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
