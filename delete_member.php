<?php
header('Content-Type: application/json');
include 'db_connection.php';

$userId = $_POST['user_id'];

$query = "DELETE FROM users WHERE id = ? AND role = 'membre'";
$stmt = $pdo->prepare($query);
if ($stmt->execute([$userId])) {
    echo json_encode(['status' => 'success', 'message' => 'Membre supprimé avec succès.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression du membre.']);
}
?>
