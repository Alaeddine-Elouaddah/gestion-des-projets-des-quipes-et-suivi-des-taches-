<?php
// delete_project.php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Projet supprimé avec succès";
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
