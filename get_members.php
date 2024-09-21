<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les membres
$sql = "SELECT id, email FROM users WHERE role = 'membre'";
$result = $conn->query($sql);

$members = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
}

// Renvoyer les membres en format JSON
header('Content-Type: application/json');
echo json_encode($members);

$conn->close();
?>
