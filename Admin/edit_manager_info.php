<?php
include 'db.php';

$name = "";
$email = "";
$mobile = "";
$type = "";
$manager_id = 0;

if (isset($_POST['delete'])) {
    $manager_id = (int)$_POST['manager_id'];

    $sql = "DELETE FROM manager WHERE Manager_id = $manager_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Manager deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting manager: " . $conn->error . "');</script>";
    }
    header('Location: modify_manager_info.php');
}

if (isset($_POST['block'])) {
    $manager_id = (int)$_POST['manager_id'];

    $sql = "UPDATE manager SET Type = 'inactive' WHERE Manager_id = $manager_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Manager blocked successfully');</script>";
    } else {
        echo "<script>alert('Error blocking manager: " . $conn->error . "');</script>";
    }
    header('Location: modify_manager_info.php');
}

if (isset($_POST['update'])) {
    $manager_id = (int)$_POST['manager_id'];
    $sql = "SELECT * FROM manager WHERE Manager_id = $manager_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Manager_name'];
        $email = $row['Email'];
        $mobile = $row['Mobile_No'];
        $type = $row['Type'];
    } else {
        echo "<script>alert('Manager not found');</script>";
    }
}

if (isset($_POST['submit'])) {
    $manager_id = (int)$_POST['manager_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $type = $_POST['type'];

    $sql = "UPDATE manager SET Manager_name = '$name', Email = '$email', Mobile_No = '$mobile', Type = '$type' WHERE Manager_id = $manager_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Manager updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating manager: " . $conn->error . "');</script>";
    }
    $conn->close();
    header('Location: modify_manager_info.php');
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Edit Student Info</title>
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
                <a href="reports.php" class="block">Add New Admin</a>
            </li>
        </ul>
    </div>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Edit Manager Info</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="edit_manager_info.php" method="post">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" class="border p-2 w-full" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" name="email" id="email" class="border p-2 w-full" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="mobile" class="block text-gray-700 text-sm font-bold mb-2">Mobile:</label>
                    <input type="text" name="mobile" id="mobile" class="border p-2 w-full" placeholder="Mobile" value="<?php echo htmlspecialchars($mobile); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                    <input type="text" name="type" id="type" class="border p-2 w-full" placeholder="Type" value="<?php echo htmlspecialchars($type); ?>" required>
                </div>
                <input type="hidden" name="manager_id" value="<?php echo $manager_id; ?>">
                <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
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
