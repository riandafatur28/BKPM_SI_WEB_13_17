<?php
require('koneksi.php');

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['txt_email'];
    $pass = $_POST['txt_pass'];

    if (!empty(trim($email)) && !empty(trim($pass))) {
        
        // Prepare the SQL statement
        $query = "SELECT * FROM user_detail WHERE user_email = ?";
        $stmt = mysqli_prepare($koneksi, $query);

        // Bind parameters and execute
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Fetch data
        $userVal = $pasVal = $username = $level = '';
        if ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $userVal = $row['user_email'];
            $pasVal = $row['user_password'];
            $username = $row['user_fullname'];
            $level = $row['level'];
        }

        // Verify user and password
        if ($userVal == $email && $pasVal == $pass) {
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $username;
            $_SESSION['level'] = $level;
            header('Location: home.php');
            exit();
        } else {
            $error = 'User atau password salah!!';
            header('Location: login.php?error=' . urlencode($error));
            exit();
        }
        
    } else {
        $error = 'Data Tidak Boleh Kosong';
        echo $error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Login</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="txt_email">Email:</label>
                <input type="text" id="txt_email" name="txt_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="txt_pass">Password:</label>
                <input type="password" id="txt_pass" name="txt_pass" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>