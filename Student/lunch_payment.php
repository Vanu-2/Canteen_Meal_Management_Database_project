<?php
session_start();
include 'db.php';

// Redirect to login page if user is not logged in as a student
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

$message = '';

// Fetching Lunch Menu ID
$fetch_menu_ids_sql = "SELECT Lunch_Menu_Id FROM available_menu WHERE `Date` = CURDATE()";
$result_menu_ids = $conn->query($fetch_menu_ids_sql);

if ($result_menu_ids->num_rows > 0) {
    $row_menu_ids = $result_menu_ids->fetch_assoc();
    $lunch_menu_id = $row_menu_ids['Lunch_Menu_Id'];
} else {
    $message = "Error: No lunch menu available for today.";
}

// Process payment form submission
if (isset($_POST['type']) && $_POST['type'] === 'lunch') {
    // Get user ID from session
    $id = $_SESSION['userid'];
    // Get today's date
    $today = date('Y-m-d');
    // Set the meal type to lunch
    $type = 'lunch';

    // Check if the student has already ordered lunch today
    $check_order_sql = "SELECT Order_id FROM `order` WHERE Student_id = '$id' AND `Date` = '$today' AND `Type` = '$type'";
    $result_check_order = $conn->query($check_order_sql);

    if ($result_check_order->num_rows > 0) {
        // If the student has already ordered lunch today, display an error message
        $message = "Error: You have already ordered lunch today.";
    } else {
        // Fetch the price for lunch for today from the database
        $fetch_price_sql = "SELECT Price FROM menu WHERE menu.Menu_id = '$lunch_menu_id'";
        $result_fetch_price = $conn->query($fetch_price_sql);

        if ($result_fetch_price->num_rows > 0) {
            // If price is found, fetch the price value
            $row_price = $result_fetch_price->fetch_assoc();
            $value = $row_price['Price'];

            // Insert into the order table
            $insert_order_sql = "INSERT INTO `order` (Date, Type, Student_id, Menu_id) VALUES ('$today', '$type', '$id', '$lunch_menu_id')";
            if ($conn->query($insert_order_sql) === TRUE) {
                // If order is inserted successfully, fetch the order ID
                $order_id = $conn->insert_id;

                // Insert into the payment table
                $insert_payment_sql = "INSERT INTO payment (Payment_id, Value, Order_id) VALUES ('$order_id', '$value', '$order_id')";
                if ($conn->query($insert_payment_sql) === TRUE) {
                    header('Location: index.php');
                    exit;
                } else {
                    // Error in inserting payment
                    $message = "Error: " . $conn->error;
                }
            } else {
                // Error in inserting order
                $message = "Error: " . $conn->error;
            }
        } else {
            // No price found for lunch for today
            $message = "Error: No price found for lunch for today.";
        }
    }
}

echo "Payment Done Redirecting in 4 sec";
sleep(1);
header("Location: order.php");
$conn->close();
?>
