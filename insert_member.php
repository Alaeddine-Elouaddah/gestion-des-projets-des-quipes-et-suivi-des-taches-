<?php
session_start();
$chef_id = $_SESSION['chef_id']; // Identifiant du Chef de Projet stocké en session

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionprojet');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $_POST['member-email'];
$password = $_POST['member-password'];
$group_id = $_POST['member-group'];

// Requête pour insérer un nouveau membre
$sql = "INSERT INTO members (email, password, group_id, chef_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssii', $email, $password, $group_id, $chef_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'Membre ajouté avec succès !';
} else {
    echo 'Erreur lors de l\'ajout du membre.';
}

$stmt->close();
$conn->close();
?>
