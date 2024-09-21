<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestionprojet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$member_id = $_POST['member-id'];
$member_email = $_POST['member-email'];
$member_password = $_POST['member-password'];
$member_group = $_POST['member-group'];

$sql = "UPDATE members SET email='$member_email', password='$member_password', group_id='$member_group' WHERE id='$member_id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success", "message" => "Membre mis à jour avec succès"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erreur : " . $conn->error]);
}

$conn->close();
?>
