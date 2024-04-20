<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'admin') {
    header('Location: ../login_form.php');
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login_form.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Administrator Dashboard</title>
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
                <a href="admin_dashboard.php" class="block">Dashboard</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="approve_student_requests.php" class="block">Approve Student Requests</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="approve_manager_requests.php" class="block">Approve Manager Requests</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="modify_student_info.php" class="block">Modify Student Information</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="modify_manager_info.php" class="block">Modify Manager Information</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="reports.php" class="block">Reports</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class =  "font-semibold text-black"> Logged In As Admin. </span>
                <form action="admin_dashboard.php" method="post">
                    <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
            </div>
        </div>
        
        <!-- Today's Order Status and Ongoing Meals -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <!-- Today's Order Status -->
            <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Today's Order Status</h2>
            
            <?php
            include 'db.php';

            // Get today's date
            $today = date('Y-m-d');

            // Query to get total orders for today
            $sql_total = "SELECT COUNT(*) as total FROM `Order` WHERE Date = '$today'";
            $result_total = $conn->query($sql_total);
            $row_total = $result_total->fetch_assoc();
            $totalOrders = $row_total['total'];

            // Query to get lunch orders for today
            $sql_lunch = "SELECT COUNT(*) as lunch FROM `Order` WHERE Date = '$today' AND Type = 3";
            $result_lunch = $conn->query($sql_lunch);
            $row_lunch = $result_lunch->fetch_assoc();
            $lunchOrders = $row_lunch['lunch'];

            // Query to get dinner orders for today
            $sql_dinner = "SELECT COUNT(*) as dinner FROM `Order` WHERE Date = '$today' AND Type = 2";
            $result_dinner = $conn->query($sql_dinner);
            $row_dinner = $result_dinner->fetch_assoc();
            $dinnerOrders = $row_dinner['dinner'];

            $conn->close();
            ?>

            <p class="text-lg">Total Orders Today: <span class="font-semibold"><?php echo $totalOrders; ?></span></p>
            <p class="text-lg mt-4">Lunch Orders: <span class="font-semibold"><?php echo $lunchOrders; ?></span></p>
            <p class="text-lg mt-4">Dinner Orders: <span class="font-semibold"><?php echo $dinnerOrders; ?></span></p>
        </div>

<!-- Today's Ongoing Meal -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Today's Ongoing Meals</h2>
    <!-- Fetch and display ongoing dinner and lunch items from menu_food table -->
    <?php
    include 'db.php';

    // Get today's date
    $today = date('Y-m-d');

    // Fetch ongoing dinner menu items
    $sql_dinner = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as dinner_items 
                   FROM menu_food 
                   WHERE Menu_id = (SELECT Dinner_Menu_Id FROM available_menu WHERE date = '$today')";
    $result_dinner = $conn->query($sql_dinner);

    if ($result_dinner->num_rows > 0) {
        $row_dinner = $result_dinner->fetch_assoc();
        echo "<p class='text-lg'>Dinner: {$row_dinner['dinner_items']}</p>";
    } else {
        echo "<p class='text-lg'>Dinner: No ongoing meal</p>";
    }

    $sql_dinner_price = "SELECT Dinner_price
                        FROM available_menu 
                        WHERE date = '$today' ";
    $result_sql_dinner_price = $conn->query($sql_dinner_price);
    
    if ($result_sql_dinner_price -> num_rows > 0) {
        $row_dinner_price = $result_sql_dinner_price->fetch_assoc();
        echo "<p class='text-lg'>Price : {$row_dinner_price['Dinner_price']}</p>";
    } else {
        echo "<p class='text-lg'>Price : </p>";
    }
    //header("refresh: 0");
    // Fetch ongoing lunch menu items
    $sql_lunch = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as lunch_items 
                  FROM menu_food 
                  WHERE Menu_id = (SELECT Lunch_Menu_Id FROM available_menu WHERE date = '$today')";
    $result_lunch = $conn->query($sql_lunch);

    if ($result_lunch->num_rows > 0) {
        $row_lunch = $result_lunch->fetch_assoc();
        echo "<p class='text-lg mt-4'>Lunch: {$row_lunch['lunch_items']}</p>";
    } else {
        echo "<p class='text-lg mt-4'>Lunch: No ongoing meal</p>";
    }

    $sql_lunch_price = "SELECT Lunch_price
                        FROM available_menu 
                        WHERE date = '$today' ";
    $result_sql_lunch_price = $conn->query($sql_lunch_price);
    
    if ($result_sql_lunch_price -> num_rows > 0) {
        $row_lunch_price = $result_sql_lunch_price->fetch_assoc();
        echo "<p class='text-lg'>Price : {$row_lunch_price['Lunch_price']}</p>";
    } else {
        echo "<p class='text-lg'>Price : </p>";
    }
    $conn->close();
    ?>
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