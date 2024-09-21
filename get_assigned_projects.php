<?php
// Activer les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionprojet');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer l'email du Chef de Projet depuis la session ou un autre mécanisme d'authentification
session_start();
$chef_email = $_SESSION['chef_email']; // Modifier selon votre méthode d'authentification

// Préparer et exécuter la requête SQL
$sql = "SELECT * FROM projects WHERE manager_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $chef_email);
$stmt->execute();
$result = $stmt->get_result();

$projects = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Envoyer les données en JSON
header('Content-Type: application/json');
echo json_encode($projects);

$stmt->close();
$conn->close();
?>
