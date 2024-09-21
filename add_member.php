<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Hachage du mot de passe pour plus de sécurité
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insérer le nouveau membre dans la table `users`
$sql = "INSERT INTO users (email, password, role) VALUES ('$email', '$hashed_password', 'membre')";

if ($conn->query($sql) === TRUE) {
    echo "Nouveau membre ajouté avec succès";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
