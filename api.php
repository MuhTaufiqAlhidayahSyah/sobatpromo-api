<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include "db.php";

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        $result = $conn->query("SELECT * FROM promos");
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        echo json_encode($data);
        break;

    case 'show':
        $id = $_GET['id'] ?? 0;
        $result = $conn->query("SELECT * FROM promos WHERE id=$id");
        echo json_encode($result->fetch_assoc());
        break;

    case 'create':
        $title = $_POST['title'] ?? '';
        $desc  = $_POST['description'] ?? '';
        $valid = $_POST['valid_until'] ?? '';
        $conn->query("INSERT INTO promos (title, description, valid_until) VALUES ('$title', '$desc', '$valid')");
        echo json_encode(["message" => "Promo berhasil ditambahkan"]);
        break;

    case 'update':
        $id    = $_POST['id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $desc  = $_POST['description'] ?? '';
        $valid = $_POST['valid_until'] ?? '';
        $conn->query("UPDATE promos SET title='$title', description='$desc', valid_until='$valid' WHERE id=$id");
        echo json_encode(["message" => "Promo berhasil diperbarui"]);
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $conn->query("DELETE FROM promos WHERE id=$id");
        echo json_encode(["message" => "Promo dihapus"]);
        break;

    default:
        echo json_encode(["message" => "Gunakan action=list/show/create/update/delete"]);
}
?>
