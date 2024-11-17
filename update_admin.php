<?php
// Database connection
include 'db_conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming form data is sent via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Assuming you have a password field in your form
    $newPassword = $_POST['newPassword']; // Assuming you have a field for new password
    $repeatPassword = $_POST['repeatPassword']; // Assuming you have a field to repeat new password
    $birthday = $_POST['birthday'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $twitter = $_POST['twitter'];
    $facebook = $_POST['facebook'];
    $linkedin = $_POST['linkedin'];
    $instagram = $_POST['instagram'];
    // Retrieve other form field values in a similar way

    // Check if new password and repeat password match
    if ($newPassword === $repeatPassword && !empty($newPassword) && !empty($repeatPassword)) {
        // If new password is not empty and matches the repeat password
        // SQL query to update admin table with new data including password
        $sqlAdmin = "UPDATE admin SET fname='$firstName', lname='$lastName', email='$email', pswd='$newPassword', bdate='$birthday', country='$country', phone='$phone', twitter='$twitter', facebook='$facebook', linkedin='$linkedin', instagram='$instagram' WHERE username='Rouba'"; // Assuming id=1 is the admin record to update

        // SQL query to update adminlogin table with new password
        $sqlAdminLogin = "UPDATE adminlogin SET password='$newPassword' WHERE username='Rouba'"; // Assuming id=1 is the admin record to update
    } else {
        // If new password is empty or does not match repeat password
        // Do not update the password field in admin table
        $sqlAdmin = "UPDATE admin SET fname='$firstName', lname='$lastName', email='$email', bdate='$birthday', country='$country', phone='$phone', twitter='$twitter', facebook='$facebook', linkedin='$linkedin', instagram='$instagram' WHERE username='Rouba'";

        // Do not update the password field in adminlogin table
        $sqlAdminLogin = "";
    }

    // Execute the queries
    if ($conn->query($sqlAdmin) === TRUE) {
        // If the query for admin table is executed successfully
        if (!empty($sqlAdminLogin)) {
            // Execute the query for adminlogin table only if it's not empty
            if ($conn->query($sqlAdminLogin) !== TRUE) {
                echo "Error updating adminlogin table: " . $conn->error;
            }
        }
        // Redirect back to the updateprofile page using JavaScript
        echo '<script>window.location.href = "updateprofile.php";</script>';
        exit; // Terminate PHP script execution
    } else {
        // If there's an error in executing the query for admin table
        echo "Error updating admin table: " . $conn->error;
    }
}

$conn->close(); // Close the database connection
?>
