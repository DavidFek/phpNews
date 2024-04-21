<?php
include_once('inc/database.php');

$result = $db->query("SELECT * FROM articles");

$articles = array();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $articles[] = (object) $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Saved Articles</title>
</head>

<body>
    <h1>Saved Articles</h1>
    <a href="index.php" class="button button__back">Back to News</a>
    <div class="articles__wrapper">
        <?php
        if (empty($articles)) {
            echo '<p>No saved articles.</p>';
        } else {
            foreach ($articles as $article) {
                echo '<div class="article__item">';
                echo '<h2 class="article__title">' . htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8') . '</h2>';
                echo '<img class="article__img" src="' . htmlspecialchars($article->urlToImage, ENT_QUOTES, 'UTF-8') . '" alt="Article image">';
                echo '<p class="article__desc">' . htmlspecialchars($article->description, ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<div class="article__footer">';
                echo '<a class="button button__more" class="article__link" href="' . htmlspecialchars($article->url, ENT_QUOTES, 'UTF-8') . '">Read more</a>';
                echo '<form method="post" action="inc/delete-article.php">';
                echo '<input type="hidden" name="id" value="' . $article->id . '">';
                echo '<button class="button button_save" type="submit">Delete Article</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>

</html>