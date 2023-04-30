<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Retrieve the date value from the query parameter
$mechanicName = $_POST['mechanicName'];
$carCount = $_POST['carCount'];

$sql = "INSERT INTO mechanic (name, carCount) VALUES (?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $mechanicName, $carCount);
if (mysqli_stmt_execute($stmt)) {
    header("Location: success.html");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);

?>