<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'gestionprojet');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nom du groupe depuis le formulaire
    $groupName = $conn->real_escape_string($_POST['group-name']);

    // Préparer et exécuter la requête SQL pour insérer le groupe dans la base de données
    $sql = "INSERT INTO groups (name) VALUES ('$groupName')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Groupe créé avec succès."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la création du groupe : " . $conn->error]);
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
