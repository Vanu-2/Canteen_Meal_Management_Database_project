<?php
session_start();
include 'db.php';

// Redirect to login page if user is not logged in as a student
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'student') {
    header('Location: ../login_form.php');
    exit;
}

$message = '';

// Fetching Dinner and Lunch Menu IDs
$fetch_menu_ids_sql = "SELECT Dinner_Menu_Id, Lunch_Menu_Id FROM available_menu WHERE `Date` = CURDATE()";
$result_menu_ids = $conn->query($fetch_menu_ids_sql);

if ($result_menu_ids->num_rows > 0) {
    $row_menu_ids = $result_menu_ids->fetch_assoc();
    $dinner_menu_id = $row_menu_ids['Dinner_Menu_Id'];
    $lunch_menu_id = $row_menu_ids['Lunch_Menu_Id'];
} else {
    $message = "Error: No menu available for today.";
}

// Process date range form submission
if (isset($_POST['dateRange'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Fetch dinner orders within the date range
    $fetch_dinner_orders_sql = "SELECT menu.Food_item, payment.Value 
                                FROM `order`
                                INNER JOIN menu ON `order`.Menu_id = menu.Menu_id
                                INNER JOIN payment ON `order`.Order_id = payment.Order_id
                                WHERE `order`.Type = 'dinner' AND `order`.Date BETWEEN '$startDate' AND '$endDate'";
    $result_dinner_orders = $conn->query($fetch_dinner_orders_sql);

    // Fetch lunch orders within the date range
    $fetch_lunch_orders_sql = "SELECT menu.Food_item, payment.Value 
                               FROM `order`
                               INNER JOIN menu ON `order`.Menu_id = menu.Menu_id
                               INNER JOIN payment ON `order`.Order_id = payment.Order_id
                               WHERE `order`.Type = 'lunch' AND `order`.Date BETWEEN '$startDate' AND '$endDate'";
    $result_lunch_orders = $conn->query($fetch_lunch_orders_sql);
}

$conn->close();
?>

<!-- HTML for Date Range Selection and History Display -->
<div class="mt-8">
    <form action="" method="post">
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" required>
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" required>
        <button type="submit" name="dateRange" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Show History</button>
    </form>

    <?php if (isset($result_dinner_orders) && $result_dinner_orders->num_rows > 0): ?>
        <h2 class="text-2xl mt-4">Dinner Orders</h2>
        <table class="mt-2 w-full border-collapse border border-green-800">
            <thead>
                <tr>
                    <th class="border border-green-600 px-4 py-2">Food Item</th>
                    <th class="border border-green-600 px-4 py-2">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_dinner_orders->fetch_assoc()): ?>
                    <tr>
                        <td class="border border-green-600 px-4 py-2"><?php echo $row['Food_item']; ?></td>
                        <td class="border border-green-600 px-4 py-2">$<?php echo $row['Value']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if (isset($result_lunch_orders) && $result_lunch_orders->num_rows > 0): ?>
        <h2 class="text-2xl mt-4">Lunch Orders</h2>
        <table class="mt-2 w-full border-collapse border border-green-800">
            <thead>
                <tr>
                    <th class="border border-green-600 px-4 py-2">Food Item</th>
                    <th class="border border-green-600 px-4 py-2">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_lunch_orders->fetch_assoc()): ?>
                    <tr>
                        <td class="border border-green-600 px-4 py-2"><?php echo $row['Food_item']; ?></td>
                        <td class="border border-green-600 px-4 py-2">$<?php echo $row['Value']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
