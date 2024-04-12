<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Add Food Package</title>
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

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Add Food Package</h1>
        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md">
            <form action="add_package.php" method="post">
                <div class="mb-4">
                    <label for="MenuId" class="block text-white">Menu Id:</label>
                    <input type="number" id="MenuId" name="MenuId" class="border border-gray-300 p-2 w-full rounded" placeholder="Enter Menu Id" required>
                </div>
                <div id="foodItemsContainer" class="mb-4">
                    <label for="foodItems" class="block text-white mb-2">Food Items:</label>
                    <div id="foodItems">
                        <input type="text" name="foodItems[]" class="border border-gray-300 p-2 w-full rounded mb-2" placeholder="Enter food item" required>
                    </div>
                    <button type="button" id="addFoodItem" style="background-color: #6bba62;" class=" text-white px-4 py-2 rounded">Add More</button>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-white">Price:</label>
                    <input type="number" id="price" name="price" class="border border-gray-300 p-2 w-full rounded" placeholder="Enter price" required>
                </div>
                <button type="submit"   style="background-color: #6bba62;" name="submit" class=" text-white px-4 py-2 rounded">Add Package</button>
            </form>
        </div>
    </div>

    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

    <script>
        document.getElementById('addFoodItem').addEventListener('click', function() {
            const foodItemsContainer = document.getElementById('foodItems');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'foodItems[]';
            input.className = 'border border-gray-300 p-2 w-full rounded mb-2';
            input.placeholder = 'Enter food item';
            input.required = true;
            foodItemsContainer.appendChild(input);
        });
    </script>

    <?php
    include 'db.php';

    if (isset($_POST['submit'])) {
        $foodItems = $_POST['foodItems'];
        $price = (int)$_POST['price'];
        $menu_id = (int)$_POST['MenuId'];
    
        // Debugging: Check the data type and contents of $foodItems
    
        // Insert into Menu table
        $sql = "INSERT INTO Menu (Menu_id, Price, Manager_id) VALUES ($menu_id, $price, 1)"; // Replace 1 with actual Manager_Id
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
    
            // Insert into Menu_food table
            foreach ($foodItems as $foodItem) {
                $sql = "INSERT INTO Menu_food (Menu_id, Food_item) VALUES ($menu_id, '$foodItem')";
                if ($conn->query($sql) !== TRUE) {
                    echo "<script>alert('Error adding food item: " . $conn->error . "');</script>";
                    break;  // Exit the loop if an error occurs
                }
            }
    
            echo "<script>alert('Food package added successfully');</script>";
        } else {
            echo "<script>alert('Error adding food package: " . $conn->error . "');</script>";
        }
        
        $conn->close();
    }
    ?>    

</body>

</html>
