<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'email de l'utilisateur connecté (par exemple via session)
$user_id = $_SESSION['user_id'];  // Utiliser une session pour gérer l'utilisateur connecté
$sql = "SELECT email FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$email = $user['email'];

// Récupérer les tâches associées à cet utilisateur
$sql = "SELECT tasks.id, tasks.title AS task_title, tasks.status AS task_status, groups.name AS group_name 
        FROM tasks 
        JOIN groups ON tasks.group_id = groups.id 
        WHERE tasks.assignee_id = (SELECT id FROM users WHERE email = ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

header('Content-Type: application/json');
echo json_encode($tasks);

$stmt->close();
$conn->close();
?>
