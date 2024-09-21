<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionprojet');

// Vérifiez la connexion
if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}

// Requête pour récupérer les groupes
$sql = 'SELECT id, name FROM groups';
$result = $conn->query($sql);

$groups = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }
}

// Retourner les données en JSON
header('Content-Type: application/json');
echo json_encode($groups);

// Fermeture de la connexion
$conn->close();
?>
