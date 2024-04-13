<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Approve Requests</title>
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
                <a href="approve_requests.php" class="block">Approve Requests</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="modify_info.php" class="block">Modify Information</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="reports.php" class="block">Reports</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">

        <h1 class="text-3xl font-bold mb-8">Approve Requests</h1>

        <!-- Managers Table -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Managers</h2>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';

                    $sql_managers = "SELECT * FROM manager WHERE manager.Type = '1'";
                    $result_managers = $conn->query($sql_managers);

                    if ($result_managers->num_rows > 0) {
                        while ($row_req = $result_managers->fetch_assoc())
                         
                        {
                            echo "<tr>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . $row_req["Manager_id"] . "</td>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . $row_req["Manager_name"] . "</td>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . $row_req["Email"] . "</td>";
                            echo "</tr>";
                        }
                    } 
                    else {
                        echo "<tr><td colspan='3' class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>No managers found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Students Table -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Students</h2>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">Name</th>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-5 py-3 border-b-2 text-left font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_students = "SELECT * FROM student WHERE type = 0";
                    $result_students = $conn->query($sql_students);

                    if ($result_students->num_rows > 0) {
                        while ($row = $result_students->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . $row["Student_id"] . "</td>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . $row["Student_name"] . "</td>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>" . $row["Email"] . "</td>";
                            echo "<td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'><form action='approve_requests.php' method='post'><input type='hidden' name='approveUserId' value='" . $row["Student_id"] . "'><button type='submit' name='approveUser' class='bg-blue-500 text-white px-4 py-2 rounded'>Approve</button></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>No students found.</td></tr>";
                    }

                    if (isset($_POST['approveUser'])) {
                        $approveUserId = $_POST['approveUserId'];

                        $sql_approve = "UPDATE users SET type = 1 WHERE id = $approveUserId";

                        if ($conn->query($sql_approve) === TRUE) {
                            echo "<script>alert('User approved successfully!');</script>";
                        } else {
                            echo "<script>alert('Error approving user: " . $conn->error . "');</script>";
                        }
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
