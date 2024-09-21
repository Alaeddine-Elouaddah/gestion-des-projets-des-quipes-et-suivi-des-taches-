<?php
// insert_chef.php

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
$email = $_POST['chef-email'];
$password = $_POST['chef-password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hachage du mot de passe

$sql = "INSERT INTO users (email, password, role) VALUES (?, ?, 'chefprojet')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashed_password);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Chef de Projet ajouté avec succès";
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
