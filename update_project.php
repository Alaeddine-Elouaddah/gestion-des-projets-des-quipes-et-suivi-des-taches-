<?php
// update_project.php

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

// Préparer et lier
$id = $_POST['edit-project-id'];
$name = $_POST['edit-project-name'];
$manager_email = $_POST['edit-manager-email'];
$end_date = $_POST['edit-date'];
$budget = $_POST['edit-budget'];
$description = $_POST['edit-description'];

$sql = "UPDATE projects SET name = ?, manager_email = ?, end_date = ?, budget = ?, description = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $name, $manager_email, $end_date, $budget, $description, $id);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Projet modifié avec succès";
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
