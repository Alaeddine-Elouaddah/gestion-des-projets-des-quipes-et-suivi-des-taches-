<?php
header('Content-Type: application/json');

// Configuration de la connexion à la base de données
$servername = "localhost"; // Remplacez par votre serveur de base de données
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "gestionprojet"; // Remplacez par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer l'email passé en paramètre
$email = isset($_GET['email']) ? $conn->real_escape_string($_GET['email']) : '';

if (empty($email)) {
    echo json_encode(['error' => 'Email parameter is required']);
    exit;
}

// Préparer la requête SQL
$sql = "
    SELECT 
        tasks.title AS task_title, 
        tasks.status AS task_status, 
        groups.name AS group_name, 
        users.email AS member_email
    FROM 
        tasks
    INNER JOIN 
        users ON tasks.assignee_id = users.id
    INNER JOIN 
        groups ON tasks.group_id = groups.id
    WHERE 
        users.email = ? 
        AND users.role = 'membre'
";

// Préparer et exécuter la requête
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Récupérer les données
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Envoyer les résultats au format JSON
echo json_encode($tasks);

// Fermer la connexion
$stmt->close();
$conn->close();
?>
