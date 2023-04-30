<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

$name = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$address = $_POST['address'];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, phone, password, address) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $hashedPassword, $address);
if (mysqli_stmt_execute($stmt)) {
    echo "User created successfully!";
    header("Location: login.html");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);

?>