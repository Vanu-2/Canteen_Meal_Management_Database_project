
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">
    
    <div style = "background-color : #4c9173"; class=" text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="index.php" class="block">Profile</a>

                
                
            </li>
            
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="order.php" class="block">Order</a>
            </li>

            
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="help.php" class="block">Help</a>
            </li>
            
        </ul>
    </div>


    <div class="ml-64 p-8">

<h1 class="text-3xl font-bold mb-8 flex justify-between items-center">
Ongoing Meal
</h1>
<div class="grid grid-cols-2 gap-8 mb-8">


            <!-- Ongoing Meal -->
            <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Today's Ongoing Meals</h2>
            <!-- Fetch and display ongoing dinner and lunch items from menu_food table -->
            <?php
            include 'db.php';

            // Get today's date
            $today = date('Y-m-d');

            // Fetch ongoing dinner menu items
            $sql_dinner = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as dinner_items 
                        FROM menu_food 
                        WHERE Menu_id = (SELECT Dinner_Menu_Id FROM ongoing_meal WHERE date = '$today')";
            $result_dinner = $conn->query($sql_dinner);

            if ($result_dinner->num_rows > 0) {
                $row_dinner = $result_dinner->fetch_assoc();
                echo "<p class='text-lg'>Dinner: {$row_dinner['dinner_items']}</p>";
            } else {
                echo "<p class='text-lg'>Dinner: No ongoing meal</p>";
            }

           
        // Fetch ongoing lunch menu items
            $sql_lunch = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as lunch_items 
                        FROM menu_food 
                        WHERE Menu_id = (SELECT Lunch_Menu_Id FROM ongoing_meal WHERE date = '$today')";
            $result_lunch = $conn->query($sql_lunch);

            if ($result_lunch->num_rows > 0) {
                $row_lunch = $result_lunch->fetch_assoc();
                echo "<p class='text-lg mt-4'>Lunch: {$row_lunch['lunch_items']}</p>";
            } else {
                echo "<p class='text-lg mt-4'>Lunch: No ongoing meal</p>";
            }

            $sql_lunch_price = "SELECT Price
                                FROM menu 
                                WHERE Menu_id = (SELECT Lunch_Menu_Id FROM ongoing_meal WHERE date = '$today')";
            $result_sql_lunch_price = $conn->query($sql_lunch_price);
            
            if ($result_sql_lunch_price -> num_rows > 0) {
                $row_lunch_price = $result_sql_lunch_price->fetch_assoc();
                echo "<p class='text-lg'>Price : {$row_lunch_price['Price']}</p>";
            } else {
                echo "<p class='text-lg'>Price : </p>";
            }
            $conn->close();
            ?>
        </div>

        </div>

        </div>



    <footer class="bg-yellow-500 text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Daining Meal Management System</p>
        </div>
    </footer>
</body>
</html>
