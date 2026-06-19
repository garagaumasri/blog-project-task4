<?php
$conn = new mysqli("localhost", "root", "", "blog", 3307);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>