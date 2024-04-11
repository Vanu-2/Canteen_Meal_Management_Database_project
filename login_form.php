<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <form method="post" action="login.php">
            <select type = "user_type" name="user_type">
                <option value="student">Student</option>
                <option value="provost">Provost</option>
                <option value="manager">Manager</option>
            </select><br>
            <input type="text" name="id" placeholder="Id"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>
