<?php
include 'connect.php';

// Check if the parameter is set in the URL
if (isset($_GET['selectedValue'])) {
    // Assign the value to $selectedValue
    $selectedValue = $_GET['selectedValue'];
} else {
    // Handle the case when the parameter is not set
    // You might want to provide a default value or show an error message
    // For example, $selectedValue = 'default_value'; or die('Error: selectedValue not set');
}

// Assuming $selectedValue is already defined
$query = "SELECT dell_name, dell_ip, riujie_name, riujie_ip, zerotrust_name, zerotrust_ip, watchguard_name, watchguard_ip FROM place_ne3 WHERE name_place = ?";
$stmt = $conn->prepare($query);

// Bind the parameter
$stmt->bindParam(1, $selectedValue, PDO::PARAM_INT); // Assuming id_place is an integer, adjust accordingly

$stmt->execute();

// Fetch the data
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the row is not empty
if ($row) {
    // Echo dell_name
    echo $row['dell_name'];
} else {
    echo "No data found";
}

// Close the statement
$stmt->closeCursor();
?>
