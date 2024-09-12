<?php
require('koneksi.php');

if (isset($_POST['update'])) {
    $userId = $_POST['txt_id'];
    $userMail = $_POST['txt_email'];
    $userPass = $_POST['txt_pass'];
    $userName = $_POST['txt_nama'];

    // Prepare the SQL statement
    $query = "UPDATE user_detail SET user_password = ?, user_fullname = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    
    if ($stmt) {
        // Bind parameters and execute
        mysqli_stmt_bind_param($stmt, 'ssi', $userPass, $userName, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: home.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($koneksi);
    }
}

// Fetch user data for the form
$id = $_GET['id'];
$query = "SELECT * FROM user_detail WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $userMail = $row['user_email'];
        $userPass = $row['user_password'];
        $userName = $row['user_fullname'];
    } else {
        echo "No user found with this ID.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($koneksi);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit User</h2>
        <form action="edit.php" method="POST">
            <input type="hidden" name="txt_id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="txt_email">Email:</label>
                <input type="text" id="txt_email" name="txt_email" class="form-control"
                    value="<?php echo htmlspecialchars($userMail); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="txt_pass">Password:</label>
                <input type="password" id="txt_pass" name="txt_pass" class="form-control"
                    value="<?php echo htmlspecialchars($userPass); ?>">
            </div>
            <div class="form-group">
                <label for="txt_nama">Nama:</label>
                <input type="text" id="txt_nama" name="txt_nama" class="form-control"
                    value="<?php echo htmlspecialchars($userName); ?>">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
        <p class="mt-3"><a href="home.php">Kembali</a></p>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>