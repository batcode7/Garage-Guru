<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

$email = $_POST['email'];
$givenPassword = $_POST['password'];

$sql = "SELECT password,role FROM users where email = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) == 0) {
    echo "Wrong userName";
} else {
    mysqli_stmt_bind_result($stmt, $password, $role);
    mysqli_stmt_fetch($stmt);

    if (password_verify($givenPassword, $password)) {
        if ($role == "regular") {
            header("Location: ..\customerView\bookAppointment.html");
            exit();
        } else if ($role == "admin") {
            header("Location: ..\adminView\add_mechanics.html");
            exit();
        }
    } else {
        header("Location: login.html");
        exit();
    }
}

mysqli_stmt_close($stmt);

?>