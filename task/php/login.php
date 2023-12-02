<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "userdb";


$conn = new mysqli($hostname, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
   
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];


    $query =  $pdo->prepare("SELECT * FROM users WHERE email = '$email'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password and create a session if successful
    if ($user && password_verify($password, $user['password'])) {
        // Use local storage for session management
        echo json_encode(['success' => true, 'email' => $user['email']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} else {
    // Handle invalid request method
    http_response_code(405);
    echo "Invalid request method.";
}
    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();

?>
