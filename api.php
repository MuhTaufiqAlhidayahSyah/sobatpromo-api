<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include "db.php";

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        $stmt = $conn->query("SELECT * FROM promos ORDER BY id ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'show':
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM promos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        break;

    case 'create':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("INSERT INTO promos (title, description, valid_until)
                                VALUES (:title, :description, :valid_until)");
        $stmt->execute([
            'title' => $input['title'],
            'description' => $input['description'],
            'valid_until' => $input['valid_until']
        ]);
        echo json_encode(["message" => "Promo berhasil ditambahkan"]);
        break;

    case 'update':
        $id = $_GET['id'] ?? 0;
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $conn->prepare("UPDATE promos
                                SET title = :title, description = :description, valid_until = :valid_until
                                WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'title' => $input['title'],
            'description' => $input['description'],
            'valid_until' => $input['valid_until']
        ]);
        echo json_encode(["message" => "Promo berhasil diperbarui"]);
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare("DELETE FROM promos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        echo json_encode(["message" => "Promo dihapus"]);
        break;

    default:
        echo json_encode(["message" => "Gunakan parameter action (list, show, create, update, delete)"]);
}
?>
