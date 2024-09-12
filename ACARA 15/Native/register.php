<?php
require('koneksi.php');

if (isset($_POST['register'])) {
    $userMail = $_POST['txt_email'];
    $userPass = $_POST['txt_pass'];
    $userName = $_POST['txt_nama'];

    // Hash the password
    $hashedPass = password_hash($userPass, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $query = "INSERT INTO user_detail (user_email, user_password, user_fullname, level) VALUES (?, ?, ?, 2)";
    $stmt = mysqli_prepare($koneksi, $query);
    
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sss', $userMail, $hashedPass, $userName);

        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            header('Location: login.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($koneksi);
    }
    
    // Close connection
    mysqli_close($koneksi);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="txt_email">Email:</label>
                <input type="email" id="txt_email" name="txt_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="txt_pass">Password:</label>
                <input type="password" id="txt_pass" name="txt_pass" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="txt_nama">Nama:</label>
                <input type="text" id="txt_nama" name="txt_nama" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
        <p class="mt-3"><a href="login.php">Login</a></p>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>