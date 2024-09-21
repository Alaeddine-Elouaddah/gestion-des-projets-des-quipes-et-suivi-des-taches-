<?php
// insert_project.php

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
$name = $_POST['project-name'];
$manager_email = $_POST['manager-email'];
$end_date = $_POST['date'];
$budget = $_POST['budget'];
$description = $_POST['description'];

$sql = "INSERT INTO projects (name, manager_email, end_date, budget, description) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $manager_email, $end_date, $budget, $description);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Projet ajouté avec succès";
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
