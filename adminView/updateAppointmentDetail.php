<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

$id = $_POST['id'];
$customerName = $_POST['name'];
$mobileNumber = $_POST['phone'];
$carColor = $_POST['color'];
$carLicense = $_POST['license'];
$carEngine = $_POST['engine'];
$appointmentDate = $_POST['date'];
$mechanicName = $_POST['mechanic'];

$sql = "UPDATE appointment SET customerName=?, mobbileNumber=?, carColor=?, carLicense=?, carEngineNumber=?, appointmentDate=?, mechanicName=? WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssssi", $customerName, $mobileNumber, $carColor, $carLicense, $carEngine, $appointmentDate, $mechanicName, $id);
if (mysqli_stmt_execute($stmt)) {
    // echo "Appointment updated successfully!";
    $redirectUrl = 'orderDetails.html';
    echo '<div class="response" data-url="' . $redirectUrl . '">Appointment updated successfully!</div>';
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>