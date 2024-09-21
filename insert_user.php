<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Modifiez selon votre configuration
$password = ""; // Modifiez selon votre configuration
$dbname = "gestionprojet";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Données de l'utilisateur
$email = 'ocpgroup@gmail.com';
$plain_password = 'ocp123';

// Hachage du mot de passe
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashed_password);

if ($stmt->execute()) {
    echo "Utilisateur inséré avec succès.";
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
