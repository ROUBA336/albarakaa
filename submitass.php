<?php
include 'db_conn.php';
// Start the session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $type = $_POST["type"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $rationfood = $_POST["rationfood"];
    // Retrieve selected food types
    $foodTypes = isset($_POST["meat"]) ? $_POST["meat"] : "";
    $foodTypes .= isset($_POST["sweet"]) ? ", " . $_POST["sweet"] : "";
    $foodTypes .= isset($_POST["cooked"]) ? ", " . $_POST["cooked"] : "";
    $foodTypes .= isset($_POST["baked"]) ? ", " . $_POST["baked"] : "";

    // Retrieve username from session
    $username = $_SESSION['username'];

    // Create connection
 

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the name already exists
    $sql_check = "SELECT * FROM association WHERE name = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $name);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "Name already exists. Please choose a different name.";
    } else {
        // Prepare SQL statement
        $sql_insert = "INSERT INTO association (username, name, type, address, phone, rationfood, foodtype) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssiss", $username, $name, $type, $address, $phone, $rationfood, $foodTypes);

        // Execute SQL statement
        if ($stmt_insert->execute() === TRUE) {
            echo "New record inserted successfully";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }

    // Close connections
    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
} else {
    echo "Form not submitted";
}
?>
