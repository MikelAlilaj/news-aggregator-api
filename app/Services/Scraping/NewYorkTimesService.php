<?php

namespace App\Services\Scraping;

use App\Services\Scraping\Base\ScraperService;

class NewYorkTimesService extends ScraperService
{

    protected function getPage(): int
    {
        return 0;
    }

    protected function getWaitTime(): int
    {
        return 7;
    }

    protected function getData(int $page): array
    {
        $response = $this->client->request('GET', 'https://api.nytimes.com/svc/search/v2/articlesearch.json', [
            'query' => [
                'api-key' => $this->apiKey,
                'page' => $page,
            ],
        ]);

        return json_decode($response->getBody())->response->docs;
    }

    protected function getPublishedDate($doc): string
    {
        return $doc->pub_date;
    }

    protected function getSourceName($doc): string
    {
        return $doc->source ?? 'The New York Times';
    }

    protected function getTitle($doc): string
    {
        return $doc->headline->main;
    }

    protected function getCategoryName($doc): string
    {
        return $doc->section_name ?? $doc->document_type;
    }

    protected function getContent($doc): string
    {
        return $doc->lead_paragraph;
    }

    protected function getAuthorNames($doc): array
    {
        $authorNames = [];
        foreach($doc->byline->person ?? [] as $person){
            $nameParts = array_filter([
                $person->firstname ?? null,
                $person->middlename ?? null,
                $person->lastname ?? null
            ]);
            $authorNames[] = trim(implode(' ', $nameParts));
        }
        return $authorNames;
    }
  
}
