<?php

namespace App\Services\Scraping;

use App\Services\Scraping\Base\ScraperService;

class NewsApiService extends ScraperService
{

    protected function getPage(): int
    {
        return 1;
    }

    protected function getWaitTime(): int
    {
        return 5;
    }

    protected function getData(int $page): array
    {
        $response = $this->client->request('GET', 'https://newsapi.org/v2/everything', [
            'query' => [
                'q' => 'bitcoin',  
                'apiKey' => $this->apiKey,
                'page' => $page,
                'sortBy' => 'publishedAt',
            ],
        ]);

        return json_decode($response->getBody())->articles;
    }

    protected function getPublishedDate($doc): string
    {
        return $doc->publishedAt;
    }

    protected function getSourceName($doc): string
    {
        return $doc->source->name;
    }

    protected function getTitle($doc): string
    {
        return $doc->title;
    }

    protected function getCategoryName($doc): string
    {
        return $doc->category ?? "Technology";
    }

    protected function getContent($doc): string
    {
        return $doc->description;
    }

    protected function getAuthorNames($doc): array
    {
        return [$doc->author];
    }
  
}
