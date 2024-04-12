<?php
include 'db.php';

if (isset($_POST['edit'])) {
    $menu_id = $_POST['menu_id'];

    // Fetch current food items and price for the selected menu item
    $sql = "SELECT Menu.Menu_id, GROUP_CONCAT(Menu_food.Food_item SEPARATOR ', ') AS FoodItems, Menu.Price 
            FROM Menu 
            LEFT JOIN Menu_food ON Menu.Menu_id = Menu_food.Menu_id 
            WHERE Menu.Menu_id = $menu_id 
            GROUP BY Menu.Menu_id";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_food_items = $row['FoodItems'];
        $current_price = $row['Price'];
    } else {
        echo "Error fetching menu item.";
        exit();
    }
}

if (isset($_POST['update'])) {
    $menu_id = $_POST['menu_id'];
    $food_items = $_POST['food_items'];
    $price = $_POST['price'];

    // Update Menu table
    $sql = "UPDATE Menu SET Price = $price WHERE Menu_id = $menu_id";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating price: " . $conn->error;
        exit();
    }

    // Delete existing food items for the selected menu
    $sql = "DELETE FROM Menu_food WHERE Menu_id = $menu_id";
    if ($conn->query($sql) !== TRUE) {
        echo "Error deleting food items: " . $conn->error;
        exit();
    }

    // Insert new food items for the selected menu
    foreach ($food_items as $food_item) {
        $sql = "INSERT INTO Menu_food (Menu_id, Food_item) VALUES ($menu_id, '$food_item')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error inserting food item: " . $conn->error;
            exit();
        }
    }

    echo "<script>alert('Menu item updated successfully');</script>";
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
    <title>DMeal - Edit Food Item</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Food Item</h1>
        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
            <form action="edit_item.php" method="post">
                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                <div class="mb-4">
                    <label for="food_items" class="block text-white mb-2">Food Items:</label>
                    <input type="text" name="food_items[]" value="<?php echo $current_food_items; ?>" class="border border-gray-300 p-2 w-full rounded mb-2" placeholder="Enter food items" required>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-white mb-2">Price:</label>
                    <input type="number" name="price" value="<?php echo $current_price; ?>" class="border border-gray-300 p-2 w-full rounded mb-2" placeholder="Enter price" required>
                </div>
                <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </div>

    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

</body>

</html>
