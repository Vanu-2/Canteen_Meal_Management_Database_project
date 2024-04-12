<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">

    <!-- Sidebar -->
    <div style="background-color: #4c9173;" class="text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="student_dashboard.php" class="block">Dashboard</a>
            </li>
            <!-- Add more menu items as needed -->
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">

        <h1 class="text-3xl font-bold mb-8">Student Dashboard</h1>

        <!-- Available Packages -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Available Packages</h2>
            <div class="grid grid-cols-2 gap-4">
                <!-- Lunch Card -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Lunch</h3>
                    <p class="text-lg">Package: <span class="font-semibold"><?php echo $availableLunchPackage; ?></span></p>
                </div>

                <!-- Dinner Card -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Dinner</h3>
                    <p class="text-lg">Package: <span class="font-semibold"><?php echo $availableDinnerPackage; ?></span></p>
                </div>
            </div>
        </div>

    </div>

    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

</body>

</html>
