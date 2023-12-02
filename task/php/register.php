<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "userdb";


$conn = new mysqli($hostname, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    
    $FirstName = mysqli_real_escape_string($conn, $_POST['fname']);
    $DisplayName = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  
    $query = $pdo->prepare("INSERT INTO users (username, email, password) VALUES ('$FirstName','$LastName', '$email', '$password')");

 $stmt->execute([$FirstName,$LastName,$email, $password]);

    // Return a success message
    echo "Registration successful!";
} else {
    // Handle invalid request method
    http_response_code(405);
    echo "Invalid request method.";
}


 
    mysqli_close($conn);

    
    header("Location: C:\Users\soniy\OneDrive\Desktop\task\login.html");
    echo json_encode($response);
    exit();
?>
