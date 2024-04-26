<?php
include 'db.php';

if (isset($_POST['approveUser'])) {
    $approveUserId = $_POST['approveUserId'];

    // Get today's date
    $today = date("Y-m-d");

    // Update end_date for current manager in manager_valid_time table
    $sql_update_end_date = "UPDATE manager_valid_time SET End_date = '$today' WHERE  End_date IS NULL";
    if ($conn->query($sql_update_end_date) === TRUE) {
        // Update other managers to type 2
        $sql_update_other_managers = "UPDATE manager SET Type = 'inactive' WHERE Manager_id != $approveUserId AND Type = 'active'";
        if ($conn->query($sql_update_other_managers) === TRUE) {
            // Update the selected manager to type 1
            $sql_approve = "UPDATE manager SET Type = 'active' WHERE Manager_id = $approveUserId";

            if ($conn->query($sql_approve) === TRUE) {
                // Insert new row in manager_valid_time table for the new manager
                $sql_insert_valid_time = "INSERT INTO manager_valid_time (Manager_id, Start_date) VALUES ($approveUserId, '$today')";
                
                if ($conn->query($sql_insert_valid_time) === TRUE) {
                    echo "<script>alert('User approved successfully and valid time added!');</script>";
                } else {
                    echo "<script>alert('Error adding valid time: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Error approving user: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Error updating other managers: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error updating end date: " . $conn->error . "');</script>";
    }
    
    $conn->close();
    header('Location: approve_manager_requests.php'); // Redirect back to approve_manager_requests.php after approval
    exit;
} else {
    header('Location: approve_manager_requests.php'); // Redirect back to approve_manager_requests.php if approve button was not pressed
    exit;
}
?>
