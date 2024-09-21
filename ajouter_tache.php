<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les données du POST
$title = $_POST['title'];
$group_id = $_POST['group_id'];
$assignee_id = $_POST['assignee_id'];
$status = $_POST['status']; // Recevoir le statut du formulaire

// Préparer la requête d'insertion
$query = "INSERT INTO tasks (title, group_id, assignee_id, status) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('siss', $title, $group_id, $assignee_id, $status);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Tâche ajoutée avec succès";
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
