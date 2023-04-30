<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

$customerName = $_POST['name'];
$mobbileNumber = $_POST['phone'];
$carColor = $_POST['color'];
$carLicense = $_POST['license'];
$carEngine = $_POST['engine'];
$appointmentDate = $_POST['date'];
$mechanicName = $_POST['mechanic'];

$sql = "INSERT INTO appointment (customerName, mobbileNumber, carColor,carLicense, carEngineNumber, appointmentDate, mechanicName) VALUES (?, ?, ?, ?, ?,?,?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssss", $customerName, $mobbileNumber, $carColor, $carLicense, $carEngine, $appointmentDate, $mechanicName);
if (mysqli_stmt_execute($stmt)) {
    echo "User created successfully!";
    header("Location: success.html");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);

?>