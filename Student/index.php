<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'student') {
    header('Location: ../login_form.php');
    exit;
}

// Logout logic
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login_form.php');
    exit;
}

// Fetch student details
$sql = "SELECT Student_id, Student_name, Mobile_No, Email FROM student WHERE Student_id = '" . $_SESSION['userid'] . "'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$message = '';

// Update profile details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newEmail = $_POST['email'];
    $newMobile = $_POST['mobile'];
    $newPassword = ($_POST['password']);

    $updateSql = "UPDATE student SET Email = '$newEmail', Mobile_No = '$newMobile', Password = '$newPassword' WHERE Student_id = '" . $_SESSION['userid'] . "'";
    if ($conn->query($updateSql) === TRUE) {
        $message = 'Profile updated successfully!';
    } else {
        $message = 'Error updating profile: ' . $conn->error;
    }
}

// Fetch student details
$sql = "SELECT Student_id, Student_name, Mobile_No, Email FROM student WHERE Student_id = '" . $_SESSION['userid'] . "'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$conn->close();
?>

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
    
    <!-- Sidebar -->
    <div style="background-color: #4c9173"  class=" text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="index.php" class="block">Profile</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="order.php" class="block">Order</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="help.php" class="block">Help</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-600">
                <a href="history.php" class="block">Order History</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Profile Details</h1>
            <div class="flex items-center space-x-4">
                <span class="font-semibold text-black">Logged In As <?php echo $student["Student_name"]; ?>.</span>
                <form action="index.php" method="post">
                    <button type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 mb-8">
            <!-- Profile Details -->
            <div class="border rounded-lg shadow-md bg-white p-6">
                <p class="font-semibold text-lg mb-2">ID: <?php echo $student["Student_id"]; ?></p>
                <p class="font-semibold text-lg mb-2">Name: <?php echo $student["Student_name"]; ?></p>

                <!-- Profile Update Form -->
                <form action="index.php" method="post">
                    <div class="mb-4">
                        <label for="email" class="block text-lg font-semibold mb-2">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $student['Email']; ?>" class="border border-gray-300 p-2 w-full rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="mobile" class="block text-lg font-semibold mb-2">Mobile No:</label>
                        <input type="text" id="mobile" name="mobile" value="<?php echo $student['Mobile_No']; ?>" class="border border-gray-300 p-2 w-full rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-lg font-semibold mb-2">Password:</label>
                        <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full rounded" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Profile</button>
                </form>
                <?php if ($message): ?>
                    <p class="text-green-500 mt-4"><?php echo $message; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-yellow-500 text-white py-4 fixed bottom-0 w-full">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Daining Meal Management System</p>
        </div>
    </footer>
</body>
</html>
