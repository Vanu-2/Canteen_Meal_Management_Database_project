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

// Get today's date
$today = date('Y-m-d');

// Check if an order exists for each meal type today
$sql_check_dinner = "SELECT * FROM `order` WHERE Student_id = '{$_SESSION['userid']}' AND Date = '$today' AND Type = 'dinner'";
$result_check_dinner = $conn->query($sql_check_dinner);

$sql_check_lunch = "SELECT * FROM `order` WHERE Student_id = '{$_SESSION['userid']}' AND Date = '$today' AND Type = 'lunch'";
$result_check_lunch = $conn->query($sql_check_lunch);

$sql_dinner = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as dinner_items, Dinner_price
               FROM menu_food 
               JOIN available_menu ON menu_food.Menu_id = available_menu.Dinner_Menu_Id
               WHERE available_menu.date = '$today'";
$result_dinner = $conn->query($sql_dinner);
$row_dinner = $result_dinner->fetch_assoc();

// Fetch ongoing lunch menu items and price
$sql_lunch = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as lunch_items, Lunch_price
              FROM menu_food 
              JOIN available_menu ON menu_food.Menu_id = available_menu.Lunch_Menu_Id
              WHERE available_menu.date = '$today'";
$result_lunch = $conn->query($sql_lunch);
$row_lunch = $result_lunch->fetch_assoc();

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
    <div style="background-color: #4c9173" class="text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="index.php" class="block">Profile</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="order.php" class="block">Order</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="help.php" class="block">Help</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="history.php" class="block">Order History</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8 flex justify-between items-center">
            Ongoing Meal
        </h1>

        <!-- Ongoing Meal Display -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <!-- Dinner Card -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Today's Ongoing Dinner</h2>
                <p class='text-lg'>Items: <?php echo $row_dinner['dinner_items'] ?? 'No ongoing meal'; ?></p>
                <p class='text-lg'>Price: <?php echo $row_dinner['Dinner_price'] ?? ''; ?></p>
                
                <!-- Dinner Order Form -->
                <form action="dinner_payment.php" method="post">
                    <input type="hidden" name="type" value="dinner">
                    <button type="submit" <?php echo ($result_check_dinner->num_rows > 0) ? 'disabled' : ''; ?> class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Order & Pay</button>
                </form>
            </div>

            <!-- Lunch Card -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Today's Ongoing Lunch</h2>
                <p class='text-lg'>Items: <?php echo $row_lunch['lunch_items'] ?? 'No ongoing meal'; ?></p>
                <p class='text-lg'>Price: <?php echo $row_lunch['Lunch_price'] ?? ''; ?></p>
                
                <!-- Lunch Order Form -->
                <form action="lunch_payment.php" method="post">
                    <input type="hidden" name="type" value="lunch">
                    <button type="submit" <?php echo ($result_check_lunch->num_rows > 0) ? 'disabled' : ''; ?> class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Order & Pay</button>
                </form>
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
