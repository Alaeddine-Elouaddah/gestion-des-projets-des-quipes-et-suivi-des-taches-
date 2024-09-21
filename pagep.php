<?php
session_start();

header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Remplacez par votre utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

//  la Vérifiez connexion
if ($conn->connect_error) {
    die(json_encode(['error' => 'Échec de la connexion à la base de données.']));
}

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];
            
            $response['redirect'] = ($user['role'] == 'chefprojet') ? 'chefprojet.html' :
                                    (($user['role'] == 'admin') ? 'admin.html' : 'membre.html');
        } else {
            $response['error'] = 'Le mot de passe est incorrect. Veuillez réessayer.';
        }
    } else {
        $response['error'] = 'Aucun utilisateur trouvé avec cet email.';
    }

    $stmt->close();
}

$conn->close();

echo json_encode($response);
?>
