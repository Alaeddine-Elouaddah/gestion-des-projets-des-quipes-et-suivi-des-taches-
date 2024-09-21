<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'gestionprojet';

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les tâches avec les noms du groupe et de l'utilisateur assigné
$query = "SELECT t.title, g.name AS group_name, u.email AS assignee, t.status 
          FROM tasks t 
          JOIN groups g ON t.group_id = g.id 
          JOIN users u ON t.assignee_id = u.id";
$result = $conn->query($query);

$tasks = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

// Retourner les données en format JSON
echo json_encode($tasks);

$conn->close();
?>
