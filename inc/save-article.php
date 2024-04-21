<?php
include_once('database.php');

$title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
$description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
$urlToImage = filter_var($_POST['urlToImage'], FILTER_SANITIZE_URL);

if (empty($description)) {
    $description = 'No description available.';
}


if (empty($urlToImage)) {
    $urlToImage = '../img/default-image.png';
}



$stmt = $db->prepare("INSERT OR IGNORE INTO articles (title, description, url, urlToImage) VALUES (:title, :description, :url, :urlToImage)");
$stmt->bindValue(':title', $title);
$stmt->bindValue(':description', $description);
$stmt->bindValue(':url', $url);
$stmt->bindValue(':urlToImage', $urlToImage);
$stmt->execute();

header('Location: ../index.php');
