<?php
class NewsAPI
{
    private $api_key = 'ebee93852f584bafb3c9635641050cf4';
    private $base_url = 'https://newsapi.org/v2/';

    public function getNews($query = '')
    {
        if ($query === '') {
            return (object) [
                'status' => 'error',
                'message' => 'Please enter a search term.'
            ];
        }
        $url = $this->base_url . 'everything?q=' . urlencode($query) . '&apiKey=' . $this->api_key;
        $ch = curl_init();

        curl_setopt(handle: $ch, option: CURLOPT_URL, value: $url);
        curl_setopt(handle: $ch, option: CURLOPT_RETURNTRANSFER, value: 1);
        curl_setopt(handle: $ch, option: CURLOPT_USERAGENT, value: 'PhPNews');

        $response = curl_exec($ch);
        curl_close($ch);
        curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);
        $news = json_decode($response);

        if (isset($news->articles)) {
            $news->articles = $this->filterArticles($news->articles);
        }

        return $news;
    }

    public function getTopHeadLines()
    {
        $url = $this->base_url . 'top-headlines?country=us&apiKey=' . $this->api_key;
        $ch = curl_init();

        curl_setopt(handle: $ch, option: CURLOPT_URL, value: $url);
        curl_setopt(handle: $ch, option: CURLOPT_RETURNTRANSFER, value: 1);
        curl_setopt(handle: $ch, option: CURLOPT_USERAGENT, value: 'PhPNews');

        $response = curl_exec($ch);
        curl_close($ch);
        curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        $news = json_decode($response);

        if (isset($news->articles)) {
            $news->articles = $this->filterArticles($news->articles);
        }

        return $news;
    }
    private function filterArticles($articles)
    {
        return array_values(array_filter($articles, function ($article) {
            return strpos($article->title, '[Removed]') === false && strpos($article->description, '[Removed]') === false;
        }));
    }
}
