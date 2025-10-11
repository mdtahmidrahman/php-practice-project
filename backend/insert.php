<?php
global $conn;

header("Access-Control-Allow-Origin: http://localhost:63342");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
ini_set('display_errors', 1);
include 'db.php';

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

if (!empty($name) && !empty($email)) {
    $sql = "INSERT INTO User (name, email) VALUES ('$name', '$email')";
    if ($conn->query($sql) === TRUE) {
        $id = $conn->insert_id;
        $result = $conn->query("SELECT * FROM User WHERE id = $id");
        $row = $result->fetch_assoc();

        echo json_encode([
            "status" => "success",
            "id" => $row['id'],
            "name" => htmlspecialchars($row['name']),
            "email" => htmlspecialchars($row['email'])
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insert failed: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Please fill out both fields."]);
}

$conn->close();
?>