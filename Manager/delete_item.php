<?php
include 'db.php';

if (isset($_POST['delete'])) {
    $menu_id = (int)$_POST['menu_id'];

    // Delete from Menu_food table first
    $sql_delete_food = "DELETE FROM Menu_food WHERE Menu_id = $menu_id";
    if ($conn->query($sql_delete_food) === TRUE) {
        // Delete from Menu table
        $sql_delete_menu = "DELETE FROM Menu WHERE Menu_id = $menu_id";
        if ($conn->query($sql_delete_menu) === TRUE) {
            echo "<script>alert('Menu item deleted successfully');</script>";
        } else {
            echo "<script>alert('Error deleting menu item from Menu table: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error deleting menu item from Menu_food table: " . $conn->error . "');</script>";
    }
    
    $conn->close();
    header('Location: delete_package.php'); // Redirect back to delete.php after deletion
    exit;
} else {
    header('Location: delete.php'); // Redirect back to delete.php if delete button was not pressed
    exit;
}
?>
