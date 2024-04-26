<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

    <div class="form-container">
        <h2 class="form-title">Register</h2>
        <form method="post" action="register.php">
            
            <select id="userType" name="userType" class="border border-gray-300 p-2 w-full rounded">
                <option value="manager">Manager</option>
                <option value="student">Student</option>
            </select>
            <input type="text" name="id" placeholder="ID" required><br>
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="text" name="mobile" placeholder="Mobile No" required><br>
            <input type="text" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="register" value="Register">
        </form>
    </div>
</body>
</html>
