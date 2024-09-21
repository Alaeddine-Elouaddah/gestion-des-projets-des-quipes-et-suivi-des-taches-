<?php
header('Content-Type: application/json');
include 'db_connection.php';

$query = "SELECT * FROM groups";
$stmt = $pdo->query($query);
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($groups);
?>
