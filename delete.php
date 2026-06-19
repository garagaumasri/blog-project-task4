<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Only Admin Can Delete
if($_SESSION['role'] != 'admin') {

    die("❌ Access Denied! Only Admin can delete posts.");

}

include "db.php";

// Get Post ID
$id = $_GET['id'];

// Prepared Statement
$stmt = $conn->prepare(
    "DELETE FROM posts WHERE id=?"
);

$stmt->bind_param("i", $id);

if($stmt->execute()) {

    header("Location: index.php");
    exit();

} else {

    echo "Error deleting post";

}

$stmt->close();
$conn->close();
?>