<?php

namespace App\Services\Scraping;

use App\Services\Scraping\Base\ScraperService;

class GuardianService extends ScraperService
{

    protected function getPage(): int
    {
        return 1;
    }

    protected function getWaitTime(): int
    {
        return 6;
    }

    protected function getData(int $page): array
    {
        $response = $this->client->request('GET', 'https://content.guardianapis.com/search', [
            'query' => [
                'api-key' => $this->apiKey,
                'page' => $page,
            ],
        ]);

        return json_decode($response->getBody())->response->results;
    }

    protected function getPublishedDate($doc): string
    {
        return $doc->webPublicationDate;
    }

    protected function getSourceName($doc): string
    {
        return 'The Guardian';
    }

    protected function getTitle($doc): string
    {
        return $doc->webTitle;
    }

    protected function getCategoryName($doc): string
    {
        return $doc->pillarName ?? 'News';
    }

    protected function getContent($doc): string
    {
        return $doc->webTitle;
    }

    protected function getAuthorNames($doc): array
    {
        return [];
    }
  
}
