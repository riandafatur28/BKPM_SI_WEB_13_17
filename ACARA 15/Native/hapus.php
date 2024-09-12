<?php
require('koneksi.php');

$id = $_GET['id'];

// Prepare the SQL statement
$query = "DELETE FROM user_detail WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: home.php");
        exit();
    } else {
        echo "No user found with this ID.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($koneksi);
}
?>