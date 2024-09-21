<?php
session_start();
$member_id = $_SESSION['member_id']; // ID du membre connecté

$conn = new mysqli('localhost', 'username', 'password', 'gestionprojet');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tasks WHERE assigne_id = '$member_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['title']}</td>
                <td>{$row['group_id']}</td>
                <td>{$row['assigne_id']}</td>
                <td>
                    <form method='POST' action='update_task.php'>
                        <input type='hidden' name='task-id' value='{$row['id']}'>
                        <select name='task-status'>
                            <option value='en cours'" . ($row['statut'] == 'en cours' ? ' selected' : '') . ">En cours</option>
                            <option value='fait'" . ($row['statut'] == 'fait' ? ' selected' : '') . ">Fait</option>
                            <option value='pas encore'" . ($row['statut'] == 'pas encore' ? ' selected' : '') . ">Pas encore</option>
                        </select>
                        <button type='submit'>Modifier</button>
                    </form>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='4'>Aucune tâche trouvée</td></tr>";
}

$conn->close();
?>
