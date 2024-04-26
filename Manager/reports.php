<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'manager') {
    header('Location: ../login_form.php');
    exit;
}

$startDate = $_POST['startDate'] ?? date('Y-m-d', strtotime('-7 days'));
$endDate = $_POST['endDate'] ?? date('Y-m-d');
$reportType = $_POST['reportType'] ?? 'profit';

$profit = 0;
$reportData = [];
$managerId = $_SESSION['userid']; // Assuming managerId is stored in the session
$isValidDateRange = false;

$sqlCheckDateRange = "SELECT * FROM manager_valid_time 
                      WHERE Manager_id = '$managerId' 
                      AND Start_date <= '$startDate' 
                      AND (End_date IS NULL)";

$resultCheckDateRange = $conn->query($sqlCheckDateRange);

if ($resultCheckDateRange->num_rows > 0) {
    $isValidDateRange = true;
} else {
    $isValidDateRange = false;

    //echo "<script>alert('Selected date range is not valid for the manager.');</script>";
    // <div class="ml-64 p-8">
    //echo "<div class=' ml-64 p-8 bg-red-500 text-white rounded-md'>Selected date range is not valid for the manager.</div>";
    // sleep(1);
    // header('Location: reports.php');
}

if (($reportType === 'profit' || $reportType === 'totalOrders')&& $isValidDateRange) {
    $sql = "SELECT `order`.Date, SUM(payment.Value) AS totalValue
            FROM `order`
            LEFT JOIN payment ON `order`.Order_id = payment.Order_id
            WHERE `order`.Date BETWEEN '$startDate' AND '$endDate'
            GROUP BY `order`.Date;
            ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $reportData[$row['Date']]['totalValue'] = $row['totalValue'];
    }
}

if ($reportType === 'profit' && $isValidDateRange) {
    $sql = "SELECT Date, SUM(Cost) as totalCost
            FROM daily_cost
            WHERE Date BETWEEN '$startDate' AND '$endDate'
            GROUP BY Date";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $reportData[$row['Date']]['totalCost'] = $row['totalCost'];
    }

    foreach ($reportData as $date => $data) {
        $profit += ($data['totalValue'] ?? 0) - ($data['totalCost'] ?? 0);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Profit & Reports</title>
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
        <h1 class="text-3xl font-bold mb-8">Reports</h1>


        <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4">Generate Reports</h2>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="reportType" class="block text-lg font-semibold mb-2">Report Type:</label>
                    <select id="reportType" name="reportType" class="border border-gray-300 p-2 w-full rounded">
                        <option value="profit">Profit Report</option>
                        <option value="yesterdayOrders">Student order List </option>
                        <option value="dailyMeals">Daily Meal Report</option>
                        <!-- <option value="dinnerLunchOrders">Number of Dinner and Lunch Orders</option> -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="startDate" class="block text-lg font-semibold mb-2">Start Date:</label>
                    <input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>" class="border border-gray-300 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="endDate" class="block text-lg font-semibold mb-2">End Date:</label>
                    <input type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>" class="border border-gray-300 p-2 w-full rounded">
                </div>
                <button type="submit" name="generateReport" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Generate Report</button>
            </form>
        </div>
<!-- ... -->

        <?php if ($reportType === 'yesterdayOrders'): ?>
            <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-semibold mb-4">List of Students who Ordered Meal in the Date Range</h2>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr style="background-color: #694b7c;">
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Order ID
                            </th>
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Student ID
                            </th>
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Order Type
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT `Date`, Order_id, Student_id, Type
                                FROM `order` 
                                WHERE `Date` BETWEEN '$startDate' AND '$endDate'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $rowColor = true; // Variable to track row color
                            while($row = $result->fetch_assoc()) {
                                $colorClass = $rowColor ? 'bg-gray-200' : 'bg-gray-100'; // Alternate row colors
                        ?>
                            <tr class="<?php echo $colorClass; ?>">
                                <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Date']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Order_id']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Student_id']; ?></td>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Type']; ?></td>
                            </tr>
                        <?php 
                                $rowColor = !$rowColor; // Toggle row color
                            }
                        } else {
                            echo "<tr><td colspan='4' class='px-5 py-5 border-b border-gray-500 text-sm'>No orders found for the selected date range.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
            <?php if ($reportType === 'profit'): ?>
            <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-semibold mb-4">Profit</h2>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr style="background-color: #694b7c;">
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Total Value
                            </th>
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Total Cost
                            </th>
                            <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Profit
                            </th>
                            <!-- <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Action
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($reportData as $date => $data): 
                            $profitForDate = ($data['totalValue'] ?? 0) - ($data['totalCost'] ?? 0);
                        ?>
                            <tr style='background-color : #e2eff1;'>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $date; ?></td>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm <?php echo ($data['totalValue'] ?? 0) > ($data['totalCost'] ?? 0) ? 'bg-green-200' : 'bg-red-200'; ?>"><?php echo $data['totalValue'] ?? 0; ?></td>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $data['totalCost'] ?? 0; ?></td>
                                <td class="px-5 py-5 border-b border-gray-500 text-sm <?php echo $profitForDate >= 0 ? 'bg-green-200' : 'bg-red-200'; ?>"><?php echo $profitForDate; ?></td>
                                
                            </tr>
                        <?php endforeach; ?>
                        <tr class="bg-blue-100">
                            <td class="px-5 py-5 border-b border-gray-500 text-sm">Total Profit</td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm" colspan="2"><?php echo $profit; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php if ($reportType === 'dailyMeals'): ?>
    <div style="background-color: #4c9173;" class="p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-semibold mb-4">Daily Meals Report</h2>

        <!-- Lunch Table -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Lunch</h3>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr style="background-color: #694b7c;">
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Price
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Items
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Total Orders
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sqlLunch = "SELECT am.`Date`, am.Lunch_price AS Price, 
                                        GROUP_CONCAT(DISTINCT mf.Food_item) AS Items,
                                        SUM(CASE WHEN o.Type = 'lunch' THEN 1 ELSE 0 END) AS Total_orders
                                 FROM available_menu am
                                 LEFT JOIN menu_food mf ON am.Lunch_Menu_Id = mf.Menu_id
                                 LEFT JOIN `order` o ON am.`Date` = o.`Date` AND o.Type = 'lunch'
                                 WHERE am.`Date` BETWEEN '$startDate' AND '$endDate'
                                 GROUP BY am.`Date`";
                    $resultLunch = $conn->query($sqlLunch);

                    if ($resultLunch->num_rows > 0) {
                        $rowColor = true; // Variable to track row color
                        while($row = $resultLunch->fetch_assoc()) {
                            $colorClass = $rowColor ? 'bg-gray-200' : 'bg-gray-100'; // Alternate row colors
                            $dt = $row['Date'];
                            $qr = "SELECT COUNT(*) as total FROM `order` WHERE Type = 'lunch' AND Date = '$dt'";
                            $resultDinnercount = $conn->query($qr);
                            $r = $resultDinnercount->fetch_assoc();
                    ?>
                        <tr class="<?php echo $colorClass; ?>">
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Date']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Price']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Items']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $r['total']; ?></td>
                        </tr>
                    <?php 
                            $rowColor = !$rowColor; // Toggle row color
                        }
                    } else {
                        echo "<tr><td colspan='4' class='px-5 py-5 border-b border-gray-500 text-sm'>No lunch meal data found for the selected date range.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Dinner Table -->
        <div>
            <h3 class="text-xl font-semibold mb-4">Dinner</h3>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr style="background-color: #694b7c;">
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Price
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Items
                        </th>
                        <th class="px-5 py-3 border-b-2 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Total Orders
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sqlDinner = "SELECT am.`Date`, am.Lunch_price AS Price, 
                               GROUP_CONCAT(DISTINCT mf.Food_item) AS Items,
                               SUM(CASE WHEN o.Type = 'dinner' THEN 1 ELSE 0 END) AS Total_orders
                               FROM available_menu am
                               LEFT JOIN menu_food mf ON am.Dinner_Menu_Id = mf.Menu_id
                               LEFT JOIN `order` o ON am.`Date` = o.`Date` AND o.Type = 'dinner'
                               WHERE am.`Date` BETWEEN '$startDate' AND '$endDate'
                               GROUP BY am.`Date` , o.Type = 'dinner'
                               ";
                    $resultDinner = $conn->query($sqlDinner);

                    if ($resultDinner->num_rows > 0) {
                        $rowColor = true; // Variable to track row color
                        while($row = $resultDinner->fetch_assoc()) {
                            $colorClass = $rowColor ? 'bg-gray-200' : 'bg-gray-100'; // Alternate row colors
                            $dt = $row['Date'];
                            $qr = "SELECT COUNT(*) as total FROM `order` WHERE Type = 'dinner' AND Date = '$dt'";
                            $resultDinnercount = $conn->query($qr);
                            $r = $resultDinnercount->fetch_assoc();
                            //$count_order = $conn->query("Select Coun");
                    ?>
                        <tr class="<?php echo $colorClass; ?>">
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Date']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Price']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $row['Items']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-500 text-sm"><?php echo $r['total']; ?></td>
                        </tr>
                    <?php 
                            $rowColor = !$rowColor; // Toggle row color
                        }
                    } else {
                        echo "<tr><td colspan='4' class='px-5 py-5 border-b border-gray-500 text-sm'>No dinner meal data found for the selected date range.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
<?php endif; ?>


    </div>

    <footer style="background-color: #42476d;" class="text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Dining Meal Management System</p>
        </div>
    </footer>

</body>

</html>