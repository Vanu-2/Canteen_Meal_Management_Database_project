<?php
// include 'db.php';

// // Check if delete button is pressed


// // // Check if update button is pressed
// // if (isset($_POST['update'])) {
// //     $student_id = (int)$_POST['student_id'];
// //     $name = $_POST['name'];
// //     $email = $_POST['email'];
// //     $mobile = $_POST['mobile'];

// //     $sql = "UPDATE student SET Student_name = '$name', Email = '$email', Mobile = '$mobile' WHERE Student_id = $student_id";
// //     if ($conn->query($sql) === TRUE) {
// //         echo "<script>alert('Student updated successfully');</script>";
// //     } else {
// //         echo "<script>alert('Error updating student: " . $conn->error . "');</script>";
// //     }
// // }
//header('Location: modify_student_info.php');
// $conn->close();
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Edit Student Info</title>
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
                <a href="reports.php" class="block">Add New Admin</a>
            </li>
        </ul>
    </div>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Student Info</h1>
        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr style = "background-color : #694b7c;">
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Student ID
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Mobile
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';

                    $sql = "SELECT * FROM student";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style = 'background-color : #e2eff1;' class='px-5 py-5 border-b border-gray-500  text-sm'>" . $row["Student_id"] . "</td>";
                            echo "<td style = 'background-color : #dbef98;' class='px-5 py-5 border-b border-gray-500  text-sm'>" . $row["Student_name"] . "</td>";
                            echo "<td style = 'background-color : #e5f1e3;' class='px-5 py-5 border-b border-gray-500  text-sm'>" . $row["Email"] . "</td>";
                            echo "<td style = 'background-color : #dbef98;' class='px-5 py-5 border-b border-gray-500  text-sm'>" . $row["Mobile_No"] . "</td>";
                            echo "<td style = 'background-color : #e5f1e3;' class='px-5 py-5 border-b border-gray-500  text-sm'>" . $row["Type"] . "</td>";
                            echo "<td style = 'background-color : #dbef98;' class='px-5 py-5 border-b border-gray-500  text-sm'>";
                            echo "<form action='edit_student_info.php' method='post' style='display: inline-block;'>";
                            echo "<input type='hidden' name='student_id' value='" . $row["Student_id"] . "'>";
                            echo "<button type='submit' name='update' class='bg-blue-500 text-white px-4 py-2 rounded'>Update</button>";
                            echo "</form>";
                            echo "<form action='edit_student_info.php' method='post' style='display: inline-block; margin-left: 10px;'>";
                            echo "<input type='hidden' name='student_id' value='" . $row["Student_id"] . "'>";
                            echo "<button type='submit' name='block' class='bg-red-500 text-white px-4 py-2 rounded'>Block</button>";
                            echo "</form>";
                            echo "<form action='edit_student_info.php' method='post' style='display: inline-block; margin-left: 10px;'>";
                            echo "<input type='hidden' name='student_id' value='" . $row["Student_id"] . "'>";
                            echo "<button type='submit' name='delete' class='bg-gray-500 text-white px-4 py-2 rounded'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                            
                        }
                    } else {
                        echo "<tr><td colspan='5' class='px-5 py-5 border-b border-gray-200 bg-white text-sm text-center'>No records found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

</body>

</html>
