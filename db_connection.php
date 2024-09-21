<?php
$host = 'localhost';
$db = 'gestionprojet';
$user = 'root';
$pass = ''; // Mettez votre mot de passe ici

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>
