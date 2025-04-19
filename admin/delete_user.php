<?php
// Include necessary files and configurations
require_once('../Includes/config.php');
require_once('../Includes/session.php');
require_once('../Includes/admin.php');

// Establish SQL connection
$con = mysqli_connect($host, $mysql_user, $mysql_pwd, $dbms);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Check if user is logged in
if ($logged == false) {
    header("Location:../index.php");
    exit; // Ensure script stops execution after redirection
}

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Perform the deletion operation
    if (delete_user($con, $user_id)) {
        // Redirect back to the page with success message or any appropriate action
        header("Location: users.php?deleted=true");
        exit;
    } else {
        // Handle deletion failure, maybe redirect back with an error message
        header("Location: users.php?deleted=false");
        exit;
    }
} else {
    // Redirect back if user ID is not provided
    header("Location: users.php");
    exit;
}

// Function to delete user
function delete_user($con, $user_id) {
    // Perform the deletion operation
    $query = "DELETE FROM user WHERE id = $user_id";
    if (mysqli_query($con, $query)) {
        return true; // Deletion successful
    } else {
        return false; // Deletion failed
    }
}
?>
