<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Dashboard</title>
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
                <a href="dashboard.php" class="block">Dashboard</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="reports.php" class="block">Reports</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="edit_package.php" class="block">Edit Package</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="add_package.php" class="block">Add Package</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="delete_package.php" class="block">Delete Package</a>
            </li>
        </ul>
    </div>

<!-- Main Content -->
<div class="ml-64 p-8">

    <h1 class="text-3xl font-bold mb-8">Manager Dashboard</h1>

    <!-- Update Dinner and Lunch Items -->
    <div class="grid grid-cols-2 gap-8 mb-8">

        <!-- Update Dinner Items Form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Update Dinner Items</h2>
            <form action="update_items.php" method="post">
                <div class="mb-4">
                    <label for="dinnerMenuId" class="block text-lg font-semibold mb-2">Dinner Menu ID:</label>
                    <select id="dinnerMenuId" name="dinnerMenuId" class="border border-gray-300 p-2 w-full rounded">
                        <?php
                        include 'db.php';

                        $sql = "SELECT Menu_id FROM Menu";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["Menu_id"] . "'>" . $row["Menu_id"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No Menu IDs available</option>";
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>
                <!-- Add more form fields for updating dinner items -->
                <button type="submit" name="updateDinner" class="bg-blue-500 text-white px-4 py-2 rounded">Update Dinner</button>
            </form>
        </div>

        <!-- Update Lunch Items Form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Update Lunch Items</h2>
            <form action="update_items.php" method="post">
                <div class="mb-4">
                    <label for="lunchMenuId" class="block text-lg font-semibold mb-2">Lunch Menu ID:</label>
                    <select id="lunchMenuId" name="lunchMenuId" class="border border-gray-300 p-2 w-full rounded">
                        <?php
                        include 'db.php';

                        $sql = "SELECT Menu_id FROM Menu";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["Menu_id"] . "'>" . $row["Menu_id"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No Menu IDs available</option>";
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>
                <!-- Add more form fields for updating lunch items -->
                <button type="submit" name="updateLunch" class="bg-blue-500 text-white px-4 py-2 rounded">Update Lunch</button>
            </form>
        </div>
    </div>
        <div class="grid grid-cols-1 gap-8 mb-8">
        <!-- Today's Order Status -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Today's Order Status</h2>
            <!-- Placeholder for today's order status -->
            <p class="text-lg">Total Orders Today: <span class="font-semibold">50</span></p>
            <p class="text-lg mt-4">Lunch Orders: <span class="font-semibold">30</span></p>
            <p class="text-lg mt-4">Dinner Orders: <span class="font-semibold">20</span></p>
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
