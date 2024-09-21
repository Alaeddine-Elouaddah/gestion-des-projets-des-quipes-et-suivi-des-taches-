<?php
// Démarrer la session
session_start();

// Informations de connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplacez par votre utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$dbname = "gestionprojet"; // Nom de votre base de données

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Définir l'en-tête pour renvoyer une réponse JSON
header('Content-Type: application/json');

// Récupérer les données JSON envoyées par la requête
$input = json_decode(file_get_contents('php://input'), true);

// Vérifier que les données ont été reçues correctement
if (isset($input['taskId']) && isset($input['status'])) {
    $taskId = $input['taskId'];
    $status = $input['status'];
    
    // Préparer la requête de mise à jour du statut
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $taskId);

    // Exécuter la requête et vérifier si elle a réussi
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Le statut a été mis à jour avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du statut.']);
    }

    // Fermer la requête préparée
    $stmt->close();
} else {
    // Si les données ne sont pas correctes, renvoyer une erreur
    echo json_encode(['success' => false, 'message' => 'Données manquantes ou invalides.']);
}

// Fermer la connexion
$conn->close();
?>
