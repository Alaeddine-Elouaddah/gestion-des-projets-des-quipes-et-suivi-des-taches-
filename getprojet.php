<?php
// getprojet.php

session_start();

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

// Vérifier si l'utilisateur est connecté et est un chef de projet
if (isset($_SESSION['user_email']) && $_SESSION['role'] === 'chefprojet') {
    $email = $_SESSION['user_email'];

    // Sélectionner les projets assignés à ce chef de projet
    $sql = "SELECT name, end_date, budget, description FROM projects WHERE manager_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $projects = [];
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }

    // Affichage pour débogage
    if (empty($projects)) {
        echo json_encode(["message" => "Aucun projet trouvé pour cet utilisateur."]);
    } else {
        echo json_encode($projects);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Utilisateur non connecté ou rôle invalide."]);
}

$conn->close();
?>
