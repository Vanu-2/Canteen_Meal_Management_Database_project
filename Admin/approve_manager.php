<?php
include 'db.php';

if (isset($_POST['approveUser'])) {
    $approveUserId = $_POST['approveUserId'];

    // Update other managers to type 2
    $sql_update_other_managers = "UPDATE manager SET Type = 'inactive' WHERE Manager_id != $approveUserId AND Type = 'active'";
    if ($conn->query($sql_update_other_managers) === TRUE) {
        // Update the selected manager to type 1
        $sql_approve = "UPDATE manager SET Type = 'active' WHERE Manager_id = $approveUserId";

        if ($conn->query($sql_approve) === TRUE) {
            echo "<script>alert('User approved successfully!');</script>";
        } else {
            echo "<script>alert('Error approving user: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error updating other managers: " . $conn->error . "');</script>";
    }
    
    $conn->close();
    header('Location: approve_manager_requests.php'); // Redirect back to approve_manager_requests.php after approval
    exit;
} else {
    header('Location: approve_manager_requests.php'); // Redirect back to approve_manager_requests.php if approve button was not pressed
    exit;
}
?>
