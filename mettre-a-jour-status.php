<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['updates']) && is_array($input['updates'])) {
    $updates = $input['updates'];
    $responses = [];
    
    $conn->autocommit(FALSE); // Désactiver l'autocommit pour la transaction

    try {
        foreach ($updates as $update) {
            $taskId = $update['taskId'];
            $status = $update['status'];
            
            // Préparer et exécuter la requête de mise à jour
            $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $taskId);
            
            if ($stmt->execute()) {
                $responses[] = ['taskId' => $taskId, 'status' => $status, 'success' => true];
            } else {
                $responses[] = ['taskId' => $taskId, 'status' => $status, 'success' => false];
            }

            $stmt->close();
        }
        
        $conn->commit(); // Valider la transaction
        echo json_encode(['success' => true, 'responses' => $responses]);
    } catch (Exception $e) {
        $conn->rollback(); // Annuler la transaction en cas d'erreur
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Aucune donnée reçue ou données invalides.']);
}

$conn->close();
?>
