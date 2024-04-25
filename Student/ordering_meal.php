<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordering Meal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Today's Menu and Price</h1>

        <!-- PHP Code to Fetch and Display Menu and Price -->
        <?php
        include 'db.php'; // Include your database connection file

        // Get today's date
        $today = date('Y-m-d');

        if (isset($_GET['meal'])) {
            $meal_type = $_GET['meal'];
            $sql = "";

            switch ($meal_type) {
                case 'Only Dinner':
                    $sql = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as meal_items, Dinner_price as price 
                            FROM menu_food 
                            INNER JOIN available_menu ON menu_food.Menu_id = available_menu.Dinner_Menu_Id 
                            WHERE available_menu.date = '$today'";
                    break;
                case 'Only Lunch':
                    $sql = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as meal_items, Lunch_price as price 
                            FROM menu_food 
                            INNER JOIN available_menu ON menu_food.Menu_id = available_menu.Lunch_Menu_Id 
                            WHERE available_menu.date = '$today'";
                    break;
                case 'Both Dinner and Lunch':
                    $sql_dinner = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as dinner_items, Dinner_price 
                                    FROM menu_food 
                                    INNER JOIN available_menu ON menu_food.Menu_id = available_menu.Dinner_Menu_Id 
                                    WHERE available_menu.date = '$today'";
                    $result_dinner = $conn->query($sql_dinner);

                    $sql_lunch = "SELECT GROUP_CONCAT(Food_item SEPARATOR ', ') as lunch_items, Lunch_price 
                                    FROM menu_food 
                                    INNER JOIN available_menu ON menu_food.Menu_id = available_menu.Lunch_Menu_Id 
                                    WHERE available_menu.date = '$today'";
                    $result_lunch = $conn->query($sql_lunch);

                    if ($result_dinner->num_rows > 0 && $result_lunch->num_rows > 0) {
                        $row_dinner = $result_dinner->fetch_assoc();
                        $row_lunch = $result_lunch->fetch_assoc();
                        $dinner_items = $row_dinner['dinner_items'];
                        $lunch_items = $row_lunch['lunch_items'];
                        $total_price = $row_dinner['Dinner_price'] + $row_lunch['Lunch_price'];

                        echo "<p class='text-lg'>Dinner: $dinner_items</p>";
                        echo "<p class='text-lg'>Lunch: $lunch_items</p>";
                        echo "<p class='text-lg'>Total Price: $total_price</p>";
                    } else {
                        echo "<p class='text-lg'>No ongoing meal</p>";
                    }
                    break;
                default:
                    echo "<p class='text-lg'>Invalid request</p>";
            }

            if ($sql != "") {
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $meal_items = $row['meal_items'];
                    $price = $row['price'];

                    echo "<p class='text-lg'>$meal_type: $meal_items</p>";
                    echo "<p class='text-lg'>Price: $price</p>";
                } else {
                    echo "<p class='text-lg'>No ongoing meal</p>";
                }
            }
        } else {
            echo "<p class='text-lg'>Invalid request</p>";
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
