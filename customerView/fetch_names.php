<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garageGuru";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Retrieve the date value from the query parameter
$date = $_GET['date'];

// Prepare SQL query to retrieve mechanic names
$sql = "SELECT mechanicName FROM appointment WHERE appointmentDate = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $date);

// Execute the query
mysqli_stmt_execute($stmt);

// Store the result set
mysqli_stmt_store_result($stmt);

// Bind the result set to variables
mysqli_stmt_bind_result($stmt, $mechanicName);

// Create an array to store the mechanic names
$mechanicNames = array();
$uniqueMechanicNames = array();

// Iterate over the result set and store the mechanic names in the array
while (mysqli_stmt_fetch($stmt)) {
    $name = $mechanicName;
    $mechanicNames[] = $name;
    if (!in_array($name, $uniqueMechanicNames)) {
        $uniqueMechanicNames[] = $name;
    }
}
mysqli_stmt_close($stmt);

if (count($uniqueMechanicNames) != 0) {
    $sql = "SELECT name FROM mechanic";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $allMechanicName);


    while (mysqli_stmt_fetch($stmt)) {
        $name = $allMechanicName;
        if (!in_array($name, $uniqueMechanicNames))
            $uniqueMechanicNames[] = $name;
    }

    mysqli_stmt_close($stmt);

    $mechanicCount = array();

    // Iterate over the unique names and count how many times they appear in the $mechanicNames array
    foreach ($uniqueMechanicNames as $uniqueName) {
        $count = 0;
        foreach ($mechanicNames as $name) {
            if ($name == $uniqueName) {
                $count++;
            }
        }
        $mechanicCount[$uniqueName] = $count;
    }

    // $uniqueMechanicNames = array_unique($mechanicNames);
// $mechanicCount = array();

    foreach ($uniqueMechanicNames as $name) {
        // Fetch the maxCarCount for the current mechanic from the mechanic table
        $sql = "SELECT carCount FROM mechanic WHERE name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $maxCarCount);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Calculate the number of remaining appointments for the current mechanic
        $count = $maxCarCount - $mechanicCount[$name];
        $mechanicCount[$name] = $count;
    }

    $availableMechanics = array();
    foreach ($mechanicCount as $mechanicName => $count) {
        if ($count > 1) {
            $availableMechanics[] = $mechanicName;
        }
    }

    // Close the statement
    // mysqli_stmt_close($stmt);

    // Return the array of mechanic names as a JSON response
    echo json_encode($availableMechanics);

} else {
    $sql = "SELECT name FROM mechanic";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $mechanicName);

    $mechanicNames = array();

    // Iterate over the result set and store the mechanic names in the array
    while (mysqli_stmt_fetch($stmt)) {
        $name = $mechanicName;
        $mechanicNames[] = $name;
    }
    mysqli_stmt_close($stmt);
    // Return the array of available mechanics as a JSON string
    echo json_encode($mechanicNames);
}
?>