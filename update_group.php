<?php
$host = 'localhost';
$db = 'gestionprojet';
$user = 'root';
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $conn->real_escape_string($_POST['email']);
$newPassword = $conn->real_escape_string($_POST['new_password']);

$sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email' AND role = 'membre'";
$conn->query($sql);

header('Content-Type: application/json');
echo json_encode(['success' => true]);

$conn->close();
?>
