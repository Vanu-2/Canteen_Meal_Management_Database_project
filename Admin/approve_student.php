<?php
    include 'db.php';

    if (isset($_POST['approveUser'])) {
        $approveUserId = $_POST['approveUserId'];

            $sql_approve = "UPDATE student SET student.type = 1 WHERE Student_id = $approveUserId";

            if ($conn->query($sql_approve) === TRUE) {
                echo "<script>alert('User approved successfully!');</script>";
                
            } else {
                echo "<script>alert('Error approving user: " . $conn->error . "');</script>";
            }
        

        $conn->close();
        header('Location: approve_student_requests.php'); 
        exit;
    }else {
        header('Location: approve_student_requests.php'); 
        exit;
    }
?>

