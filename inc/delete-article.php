<?php
include_once('database.php');

$id = $_POST['id'];

$stmt = $db->prepare("DELETE FROM articles WHERE id = :id");
$stmt->bindValue(':id', $id);
$stmt->execute();

header('Location: ../saved-articles.php');
