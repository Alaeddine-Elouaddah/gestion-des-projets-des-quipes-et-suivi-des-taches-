<?php
header('Content-Type: application/json');
include 'db_connection.php';

$query = "SELECT * FROM users WHERE role = 'membre'";
$stmt = $pdo->query($query);
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($members);
?>
