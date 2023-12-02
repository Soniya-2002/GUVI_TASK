<?php

//  Include your MySQL database connection file
include 'mysql_db.php';
$userId = 123; // Replace with the actual user ID
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$userSession = json_decode($redis->get("user_session:$userId"), true);
// Include MongoDB PHP library
require 'vendor/autoload.php';

// Connect to MongoDB
$mongoClient = new MongoDB\Client('mongodb://localhost:27017');

// Select the database
$mongoDb = $mongoClient->selectDatabase('userprofiles');

// Select the collection
$mongoCollection = $mongoDb->selectCollection('users');
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Use the find method to fetch user profile details
    $profile = $collection->findOne(['user_id' => $userId], ['projection' => ['_id' => 0]]);

    // Return user profile details as JSON
    echo json_encode($profile);
} else {
    // Handle invalid request method or missing user ID
    http_response_code(400);
    echo "Invalid request.";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Sanitize and validate input data
    $dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'], FILTER_SANITIZE_STRING);
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);

    // Select the database and collection
    $db = $mongoClient->selectDatabase('userdb');
    $collection = $db->selectCollection('user_profiles');

    // Use the updateOne method to update user profile details
    $updateResult = $collection->updateOne(
        ['user_id' => $userId],
        ['$set' => ['dob' => $dob, 'contact' => $contact, 'age' => $age]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        // Return a success message
        echo "Profile updated successfully!";
    } else {
        // Return an error message if the profile update fails
        echo "Failed to update profile.";
    }
} else {
    // Handle invalid request method or missing user ID
    http_response_code(400);
    echo "Invalid request.";
}
?>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <h2>User Profile</h2>
    <p>Welcome, <?php echo $username; ?>!</p>
    <p>Email: <?php echo $email; ?></p>
    <a href="edit_profile.html">Edit Profile</a>
</body>
</html>
<!-- reflects the user details -->