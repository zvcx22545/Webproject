<?php
require_once 'autoload.php';
require_once 'config/db.php';

$category = $_GET['category'];
$query = $conn->prepare("SELECT tagname FROM subtag WHERE category = :category");
$query->bindParam(':category', $category);
$query->execute();
$tags = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tags);