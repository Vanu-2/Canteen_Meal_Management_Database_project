<?php
session_start();
include 'db.php';

// Redirect to login page if user is not logged in as a student
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'student') {
    header('Location: ../login_form.php');
    exit;
}

$message = '';

// Check if the form was submitted
if (isset($_POST['type']) && $_POST['type'] === 'lunch') {
    // Get user ID from session
    $id = $_SESSION['userid'];
    // Get today's date
    $today = date('Y-m-d');
    // Get the meal type from the form data
    $type = $_POST['type'];

    // Check if the student has already ordered lunch today
    $check_order_sql = "SELECT Order_id FROM `order` WHERE Student_id = '$id' AND `Date` = '$today' AND `Type` = '$type'";
    $result_check_order = $conn->query($check_order_sql);

    if ($result_check_order->num_rows > 0) {
        // If the student has already ordered lunch today, display an error message
        $message = "Error: You have already ordered lunch today.";
    } else {
        // Fetch the price for lunch from the database
        $fetch_price_sql = "SELECT Lunch_price FROM available_menu WHERE `Date` = CURDATE()";
        $result_fetch_price = $conn->query($fetch_price_sql);

        if ($result_fetch_price->num_rows > 0) {
            // If price is found, fetch the price value
            $row_price = $result_fetch_price->fetch_assoc();
            $value = $row_price['Lunch_price'];

            // Insert into the order table
            $insert_order_sql = "INSERT INTO `order` (Date, Type, Student_id) VALUES ('$today', '$type', '$id')";
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
} else {
    // Handle the case where the form was not submitted correctly
    $message = "Error: Form submission invalid.";
}

$conn->close();
?>