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
                <a href="reports.php" class="block">Reports</a>
            </li>
        </ul>
    </div>


    <!-- Main Content -->
    <div class="ml-64 p-8">

        <h1 class="text-3xl font-bold mb-8">Approve Managers</h1>

        <!-- Managers Table -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Managers</h2>
            <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr style="background-color: #694b7c;">
                            <th class="px-5 py-3 border-b-2 border-gray-500 text-left font-semibold text-white">ID</th>
                            <th class="px-5 py-3 border-b-2 border-gray-500 text-left font-semibold text-white">Name</th>
                            <th class="px-5 py-3 border-b-2 border-gray-500 text-left font-semibold text-white">Email</th>
                            <th class="px-5 py-3 border-b-2 border-gray-500 text-left font-semibold text-white">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm divide-y divide-gray-300">
                        <?php
                        include 'db.php';
                        $sql_managers = "SELECT * FROM manager WHERE manager.Type = '0'";
                        $result_managers = $conn->query($sql_managers);

                        if ($result_managers->num_rows > 0) {
                            while ($row = $result_managers->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td style='background-color: #e2eff1;' class='px-5 py-5 border-b border-gray-500 text-sm'>" . $row["Manager_id"] . "</td>";
                                echo "<td style='background-color: #dbef98;' class='px-5 py-5 border-b border-gray-500 text-sm'>" . $row["Manager_name"] . "</td>";
                                echo "<td style='background-color: #e5f1e3;' class='px-5 py-5 border-b border-gray-500 text-sm'>" . $row["Email"] . "</td>";
                                echo "<td style='background-color: #dbef98;' class='px-5 py-5 border-b border-gray-500 text-sm'>";                           
                                echo "<form action='approve_manager.php' method='post'>";
                                echo "<input type='hidden' name='approveUserId' value='" . $row["Manager_id"] . "'>";
                                echo "<button type='submit' name='approveUser' class='bg-green-500 text-white px-4 py-2 rounded'>Approve</button>";
                                echo "</form>";
                                echo "</td>";
                            }
                            
                        } else {
                            echo "<tr><td colspan='4' style='background-color: white;' class='px-5 py-5 border-b border-gray-500 text-sm'>No managers found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

</body>

</html>
