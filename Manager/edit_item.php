<?php
include 'db.php';

if (isset($_POST['edit'])) {
    $menu_id = $_POST['menu_id'];
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

    // Fetch current food items  for the selected menu item
    $sql = "SELECT Menu_food.Food_item
            FROM Menu_food
            WHERE Menu_food.Menu_id = $menu_id";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $food_items = [];
        while ($row = $result->fetch_assoc()) {
            $food_items[] = $row['Food_item'];
        }
        $current_food_items = implode(', ', $food_items);
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
                <a href="delete_package.php" class="block">Delete Package</a>
            </li>
        </ul>
    </div>

<body class="bg-green-100 font-sans">

<div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Food Item</h1>
        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
            <form action="edit_item.php" method="post">
                <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
                
                <!-- Food Items -->
                <div id="foodItemsContainer">
                    <?php 
                    $food_items_array = explode(', ', $current_food_items);
                    foreach ($food_items_array as $food_item) {
                        echo '<div class="mb-4">';
                        echo '<label class="block text-white mb-2">Food Item:</label>';
                        echo '<input type="text" name="food_items[]" value="' . $food_item . '" class="border border-gray-300 p-2 w-full rounded mb-2" required>';
                        echo '<button type="button" class="bg-red-500 text-white px-2 py-1 rounded deleteBtn">Delete</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
                
                <!-- Add More Button -->
                <button type="button" id="addMoreBtn" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Add More</button>
                
                <!-- Price -->
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addMoreBtn = document.getElementById('addMoreBtn');
        const foodItemsContainer = document.getElementById('foodItemsContainer');

        addMoreBtn.addEventListener('click', function() {
            const newDiv = document.createElement('div');
            newDiv.className = 'mb-4';

            const label = document.createElement('label');
            label.className = 'block text-white mb-2';
            label.textContent = 'Food Item:';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'food_items[]';
            input.className = 'border border-gray-300 p-2 w-full rounded mb-2';
            input.required = true;

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'bg-red-500 text-white px-2 py-1 rounded deleteBtn';
            deleteBtn.textContent = 'Delete';

            newDiv.appendChild(label);
            newDiv.appendChild(input);
            newDiv.appendChild(deleteBtn);

            foodItemsContainer.appendChild(newDiv);

            deleteBtn.addEventListener('click', function() {
                foodItemsContainer.removeChild(newDiv);
            });
        });

        // Event delegation for dynamic delete buttons
        foodItemsContainer.addEventListener('click', function(e) {
            if (e.target && e.target.className.includes('deleteBtn')) {
                const parentDiv = e.target.parentElement;
                foodItemsContainer.removeChild(parentDiv);
            }
        });
    });
</script>


</body>

</html>
