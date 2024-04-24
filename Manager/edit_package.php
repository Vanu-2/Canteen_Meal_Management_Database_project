<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'manager') {
    header('Location: ../login_form.php');
    exit;
}

if (isset($_POST['delete'])) {
    $menu_id = $_POST['menu_id'];

    // Set isDeleted = 1 for the menu
    $sql = "UPDATE menu SET isDeleted = 1 WHERE Menu_id = $menu_id";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating menu: " . $conn->error;
        exit();
    }

    header('Location: edit_package.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Edit Food Package</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">
    
    <div style="background-color: #4c9173;" class="text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="dashboard.php" class="block">Dashboard</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="reports.php" class="block">Reports</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="edit_package.php" class="block">Edit Package</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="add_package.php" class="block">Add Package</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="delete_package.php" class="block">Retrive Deleted Packages</a>
            </li>
        </ul>
    </div>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Food Package</h1>
        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr style="background-color : #694b7c;">
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Menu ID
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Food Items
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Price
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';

                    $sql = "SELECT menu.Menu_id, GROUP_CONCAT(menu_food.Food_item SEPARATOR ', ') as FoodItems, menu.Price 
                    FROM menu, menu_food
                    WHERE menu.Menu_id = menu_food.Menu_id and menu.isDeleted = 0
                    GROUP BY menu.Menu_id;
                    ";
                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td style='background-color : #e2eff1;' class='px-5 py-5 border-b border-gray-500 text-sm'>";
                            echo $row["Menu_id"];
                            echo "</td>";
                            echo "<td style='background-color : #dbef98;' class='px-5 py-5 border-b border-gray-500 text-sm'>";
                            echo $row["FoodItems"];
                            echo "</td>";
                            echo "<td style='background-color : #e5f1e3;' class='px-5 py-5 border-b border-gray-500 text-sm'>";
                            echo "৳ " . $row["Price"];
                            echo "</td>";
                            echo "<td style='background-color : #dbef98;' class='px-5 py-5 border-b border-gray-500 text-sm'>";
                            echo "<form action='edit_item.php' method='post' class='inline'>";
                            echo "<input type='hidden' name='menu_id' value='" . $row["Menu_id"] . "'>";
                            echo "<button type='submit' name='edit' class='bg-blue-500 text-white px-4 py-2 rounded mr-2'>Edit</button>";
                            echo "</form>";
                            echo "<form action='' method='post' class='inline'>";
                            echo "<input type='hidden' name='menu_id' value='" . $row["Menu_id"] . "'>";
                            echo "<button type='submit' name='delete' class='bg-red-500 text-white px-4 py-2 rounded'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='px-5 py-5 border-b border-gray-200 bg-white text-sm text-center'>No records found.</td></tr>";
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