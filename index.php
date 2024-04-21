<?php
include_once('inc/database.php');
include 'inc/newsapi.php';
$newsAPI = new NewsAPI();
if (isset($_GET['searchTerm'])) {
  $news = $newsAPI->getNews($_GET['searchTerm']);
} else {
  $news = $newsAPI->getTopHeadlines();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
  <title>News</title>
</head>

<body>
  <h1>What news would you like today?</h1>
  <form class="search__wrapper" method="get" action="index.php">
    <div class="search__header">
      <input type="text" name="searchTerm" placeholder="Search.." class="search__input" />
      <button type="submit" class="button button__search">Search</button>
    </div>
    <div class="search__footer">
      <button type="submit" name="searchTerm" value="top-news" class="button button__top">Top News</button>
      <a href="saved-articles.php" class="button button_saved-articles">Saved Articles</a>
    </div>
  </form>

  <div class="articles__wrapper">
    <?php
    if ($news === false) {
      echo '<p>Error: API request failed.</p>';
    } elseif (isset($news->status) && $news->status === 'error') {
      echo '<p>Error: ' . $news->message . '</p>';
    } elseif (isset($news->articles)) {
      foreach ($news->articles as $article) {
        echo '<div class="article__item">';
        echo '<h2 class="article__title">' . $article->title . '</h2>';
        $imageUrl = isset($article->urlToImage) ? $article->urlToImage : './img/default-image.png';
        echo '<img class="article__img" src="' . $imageUrl . '" alt="Article image">';
        $description = isset($article->description) ? $article->description : 'No description available.';
        echo '<p class="article__desc">' . $description . '</p>';
        echo '<div class="article__footer">';
        echo '<a class="button button__more" class="article__link" href="' . $article->url . '">Read more</a>';
        echo '<form method="post" action="/inc/save-article.php">';
        echo '<input type="hidden" name="title" value="' . $article->title . '">';
        echo '<input type="hidden" name="description" value="' . $description . '">';
        echo '<input type="hidden" name="url" value="' . $article->url . '">';
        echo '<input type="hidden" name="urlToImage" value="' . $imageUrl . '">';
        echo '<button type="submit" class="button button_save">Save Article</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
      }
    } else {
      echo '<p>No news articles found.</p>';
      echo '<pre>';
      print_r($news);
      echo '</pre>';
    }
    ?>
  </div>

</body>

</html>