<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Prepare SQL query to retrieve appointment details
$sql = "SELECT * FROM appointment";
$result = mysqli_query($conn, $sql);

// Check if any appointments are found
if (mysqli_num_rows($result) > 0) {
    // Loop through each appointment and store its details in an array
    $appointments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
    }
} else {
    $appointments = array();
}


// Close the database connection
mysqli_close($conn);

// Return the appointments array as JSON
header('Content-Type: application/json');
echo json_encode($appointments);
?>