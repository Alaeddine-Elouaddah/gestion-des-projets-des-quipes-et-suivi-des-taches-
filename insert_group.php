<?php
session_start();
$chef_id = $_SESSION['chef_id']; // Identifiant du Chef de Projet stocké en session

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionprojet');
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$group_name = $_POST['group-name'];

// Requête pour insérer un nouveau groupe
$sql = "INSERT INTO groups (name, chef_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $group_name, $chef_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'Groupe ajouté avec succès !';
} else {
    echo 'Erreur lors de l\'ajout du groupe.';
}

$stmt->close();
$conn->close();
?>
