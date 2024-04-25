<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'student') {
    header('Location: ../login_form.php');
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login_form.php');
    exit;
}

// History section
if (isset($_POST['dateRange'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $id = $_SESSION['userid'];

    // Fetch dinner orders within the date range
    $fetch_dinner_orders_sql = "SELECT DATE(`order`.Date) AS Order_Date, GROUP_CONCAT(menu_food.Food_item SEPARATOR ', ') AS Food_items, (payment.Value) AS Total_price 
                                FROM `order`
                                INNER JOIN menu ON `order`.Menu_id = menu.Menu_id
                                INNER JOIN menu_food ON menu.Menu_id = menu_food.Menu_id
                                INNER JOIN payment ON `order`.Order_id = payment.Order_id
                                WHERE `order`.Type = 'dinner' AND `order`.Date BETWEEN '$startDate' AND '$endDate' AND `order`.Student_id ='$id'
                                GROUP BY `order`.Order_id";
    $result_dinner_orders = $conn->query($fetch_dinner_orders_sql);

    // Fetch lunch orders within the date range
    $fetch_lunch_orders_sql = "SELECT DATE(`order`.Date) AS Order_Date, GROUP_CONCAT(menu_food.Food_item SEPARATOR ', ') AS Food_items, (payment.Value) AS Total_price 
                               FROM `order`
                               INNER JOIN menu ON `order`.Menu_id = menu.Menu_id
                               INNER JOIN menu_food ON menu.Menu_id = menu_food.Menu_id
                               INNER JOIN payment ON `order`.Order_id = payment.Order_id
                               WHERE `order`.Type = 'lunch' AND `order`.Date BETWEEN '$startDate' AND '$endDate' AND `order`.Student_id ='$id'
                               GROUP BY `order`.Order_id";
    $result_lunch_orders = $conn->query($fetch_lunch_orders_sql);
}

$conn->close();
?>

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
    
    <!-- Sidebar -->
    <div style="background-color: #4c9173"  class=" text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="index.php" class="block">Profile</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="order.php" class="block">Order</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="help.php" class="block">Help</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="history.php" class="block">Order History</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Profile Details</h1>
            <div class="flex items-center space-x-4">
                <span class="font-semibold text-black">Logged In As <?php echo $_SESSION['userid']; ?>.</span>
                <form action="index.php" method="post">
                    <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 mb-8">
            <!-- History Section -->
            <div class="border rounded-lg shadow-md bg-white p-6">
                <h2 class="font-semibold text-2xl mb-4">Order History</h2>
                <form action="" method="post">
                    <div class="mb-4">
                        <label for="startDate" class="block text-lg font-semibold mb-2">Start Date:</label>
                        <input type="date" id="startDate" name="startDate" class="border border-gray-300 p-2 w-full rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="endDate" class="block text-lg font-semibold mb-2">End Date:</label>
                        <input type="date" id="endDate" name="endDate" class="border border-gray-300 p-2 w-full rounded" required>
                    </div>
                    <button type="submit" name="dateRange" class="bg-blue-500 text-white px-4 py-2 rounded">Show History</button>
                </form>

                <?php if (isset($result_dinner_orders) && $result_dinner_orders->num_rows > 0): ?>
                    <h3 class="text-xl font-semibold mt-6 mb-4">Dinner Orders</h3>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order Date</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Food Items</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_dinner_orders->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['Order_Date']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['Food_items']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">$<?php echo $row['Total_price']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if (isset($result_lunch_orders) && $result_lunch_orders->num_rows > 0): ?>
                    <h3 class="text-xl font-semibold mt-6 mb-4">Lunch Orders</h3>
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order Date</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Food Items</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_lunch_orders->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['Order_Date']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['Food_items']; ?></td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">$<?php echo $row['Total_price']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-yellow-500 text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Daining Meal Management System</p>
        </div>
    </footer>
</body>
</html>
