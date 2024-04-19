<?php
include 'db.php';

if (isset($_POST['updateOngoingMeals'])) {
    $dinnerMenuId = (int) $_POST['dinnerMenuId'];
    $lunchMenuId = (int) $_POST['lunchMenuId'];
    $dinnerMenuPrice = (int) $_POST['dinnerMenuPrice'];
    $lunchMenuPrice = (int) $_POST['lunchMenuPrice'];
    // Get today's date
    $today = date('Y-m-d');

    // Check if dinner menu price is 0, then get default price from menu table
    if ($dinnerMenuPrice === 0) {
        $result_dinner_price = $conn->query("SELECT Price FROM menu WHERE Menu_id = $dinnerMenuId");
        if ($result_dinner_price->num_rows > 0) {
            $row = $result_dinner_price->fetch_assoc();
            $dinnerMenuPrice = $row['Price'];
        }
    }

    // Check if lunch menu price is 0, then get default price from menu table
    if ($lunchMenuPrice === 0) {
        $result_lunch_price = $conn->query("SELECT Price FROM menu WHERE Menu_id = $lunchMenuId");
        if ($result_lunch_price->num_rows > 0) {
            $row = $result_lunch_price->fetch_assoc();
            $lunchMenuPrice = $row['Price'];
        }
    }

    // Delete existing ongoing meal for today
    $conn->query("DELETE FROM available_menu WHERE date = '$today'");
    
    // Insert new ongoing meal for today
    $result = $conn->query("INSERT INTO available_menu(Date, Dinner_Menu_Id, Dinner_price, Lunch_Menu_Id, Lunch_price) VALUES ('$today', '$dinnerMenuId', '$dinnerMenuPrice', '$lunchMenuId', '$lunchMenuPrice')");
    
    if ($result) {
        echo "<script>alert('Ongoing meals updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating ongoing meals');</script>";
    }

    header('Location: dashboard.php');
}

$conn->close();
?>
