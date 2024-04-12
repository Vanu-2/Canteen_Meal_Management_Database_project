<?php
include 'db.php';

if (isset($_POST['updateOngoingMeals'])) {
    $dinnerMenuId = (int) $_POST['dinnerMenuId'];
    $lunchMenuId = (int) $_POST['lunchMenuId'];
    
    // Get today's date
    $today = date('Y-m-d');

    // Delete existing ongoing meal for today
    $conn->query("DELETE FROM ongoing_meal WHERE date = '$today'");
    
    // Insert new ongoing meal for today
    $result = $conn->query("INSERT INTO ongoing_meal (Date, Dinner_Menu_Id, Lunch_Menu_Id) VALUES ('$today', '$dinnerMenuId', '$lunchMenuId')");
    
    if ($result) {
        echo "<script>alert('Ongoing meals updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating ongoing meals');</script>";
    }

    header('Location: dashboard.php');
}

$conn->close();
?>
