<?php
session_start();

$servername = "localhost";
$username = "root"; // Remplacez par votre utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Préparer et lier les paramètres pour éviter les injections SQL
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Utiliser une requête préparée pour sécuriser l'interrogation de la base de données
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];  // Ajouter l'email à la session
            
            // Redirection basée sur le rôle de l'utilisateur
            if ($user['role'] == 'chefprojet') {
                header("Location: chefprojet.html");
            } elseif ($user['role'] == 'admin') {
                header("Location: admin.html");
            } elseif ($user['role'] == 'membre') {
                header("Location: membre.html");
            } else {
                echo "Rôle inconnu.";
            }
            exit(); // Assurez-vous de quitter après la redirection
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    $stmt->close();
}

$conn->close();
?>
