<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">
    
    <div style = "background-color : #4c9173"; class=" text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="#" class="block">Dashboard</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="#" class="block">Reports</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="#" class="block">Food Menu</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="#" class="block">Food Package</a>
            </li>
        </ul>
    </div>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Menu</h1>
        <div style="background-color: #4c9173"; class="p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Dinner Menu</h2>
            <div id="dinnerOrderInfo">
                <p>Total Orders Today: <span id="totalDinnerOrders">0</span></p>
                <ul id="dinnerOrderList" class="list-disc ml-8">
                    <!-- List of students who ordered dinner will be displayed here -->
                </ul>
            </div>
            <form id="dinnerMenuForm">
                <input type="text" id="dinnerItem" name="dinnerItem" class="border border-gray-300 p-2 w-full rounded mb-2" placeholder="Add dinner item">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add</button>
            </form>
            <!-- Add other menu items and forms here -->
        </div>
    </div>

    <footer class="bg-white-500 text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Canteen Management System</p>
        </div>
    </footer>
</body>
</html>
