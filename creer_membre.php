<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifiez que l'email et le mot de passe ne sont pas vides
    if (empty($email) || empty($password)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'gestionprojet');

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die('Erreur de connexion : ' . $conn->connect_error);
    }

    // Rôle par défaut
    $role = 'membre';

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion du membre dans la table users
    $stmt = $conn->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "Membre créé avec succès.";
    } else {
        echo "Erreur lors de la création du membre.";
    }

    // Fermeture de la connexion et de la requête
    $stmt->close();
    $conn->close();
}
?>
