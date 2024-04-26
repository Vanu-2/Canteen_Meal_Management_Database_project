<?php
include 'db.php';

$current_price = 0; // Default price
$menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;

if (isset($_POST['edit'])) {
    //fetch price
    $sql = "SELECT Menu.Price 
    FROM Menu 
    WHERE Menu.Menu_id = $menu_id";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $current_price = $row['Price'];
    } else {
        echo "Error fetching menu item.";
        exit();
    }
}

if (isset($_POST['update'])) {
    $menu_id = $_POST['menu_id'];
    $price = $_POST['price'];

    // Update Menu table
    $sql = "UPDATE Menu SET Price = $price WHERE Menu_id = $menu_id";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating price: " . $conn->error;
        exit();
    }

    echo "<script>alert('Price updated successfully');</script>";
    header('Location: edit_package.php');
}

$conn->close();
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
    
    <!-- Manager Dashboard Sidebar -->
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
                <a href="delete_package.php" class="block">Delete Package</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Food Item</h1>
        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
            <form action="edit_item.php" method="post">
                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                
                <!-- Price -->
                <div class="mb-4">
                    <label for="price" class="block text-white mb-2">Price:</label>
                    <input type="number" name="price" value="<?php echo $current_price; ?>" class="border border-gray-300 p-2 w-full rounded mb-2" placeholder="Enter price" required>
                </div>
                <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

</body>

</html>
