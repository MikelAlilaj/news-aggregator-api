<?php

namespace App\Services\Scraping\Base;

use App\Helpers\StringHelper;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\DataSource;
use App\Models\Source;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

abstract class ScraperService
{
    protected  $client;
    protected  $apiKey;
    protected  $isScraping = true;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function scrape(DataSource $dataSource): bool
    {
        $this->apiKey = config("services.data_sources.{$dataSource->service_key}.api_key");

        $latestPublishedAt = Carbon::parse($dataSource->latestArticle->published_at);
        $page = $this->getPage();   
        $waitTime = $this->getWaitTime();  

        while ($this->isScraping) {
            try {
              
                $data = $this->getData($page);
                $this->saveData($dataSource, $data, $latestPublishedAt);

                $page++;
                sleep($waitTime);

            } catch (Exception $e) {
                if ($e->getCode() == 429) {  
                    sleep($waitTime); //429 Too Many Requests: Retrying in x seconds
                } else {
                    Log::channel('scraping')->error('An error occurred during scraping: ' . $dataSource->service_key . $e->getMessage());
                    return false;
                }
            }
        }

        return true;
    }


    abstract protected function getPage(): int;

    abstract protected function getWaitTime(): int;

    abstract protected function getData(int $page): array;


    protected function saveData(DataSource $dataSource, array $docs, Carbon $latestPublishedAt): void
    {
        foreach ($docs as $doc) {
           
            $docPublishedAt = Carbon::parse($this->getPublishedDate($doc));
            if ($latestPublishedAt->gt($docPublishedAt)) {
                $this->isScraping = false;
                return;
            }

            $sourceName = $this->getSourceName($doc);
            $docPublishedAtFormat = $docPublishedAt->format('Y-m-d H:i:s');
            $slug = Str::slug($this->getTitle($doc) . '-' . $sourceName . '-' . $docPublishedAtFormat);

            $source = Source::firstOrCreate(['name' => $sourceName]);
            $categoryName = $this->getCategoryName($doc);
            $category = Category::firstOrCreate(['name' => $categoryName]);

            $article = Article::firstOrCreate([
                    'slug' => $slug,
                ],
                [
                    'title' => $this->getTitle($doc),
                    'source_id' => $source->id,
                    'published_at' => $docPublishedAtFormat,
                    'content' => $this->getContent($doc),
                    'category_id' => $category->id,
                    'data_source_id' => $dataSource->id,
                ]
            );

            $authorNames = $this->getAuthorNames($doc);
         
            foreach ($authorNames as $authorName) {
                if (StringHelper::isValidName($authorName)) {
                    $author = Author::firstOrCreate(['name' => $authorName]);
                    $article->authors()->syncWithoutDetaching([$author->id]);
                }
            }
        }
    }

    abstract protected function getPublishedDate($doc): string;

    abstract protected function getSourceName($doc): string;

    abstract protected function getTitle($doc): string;

    abstract protected function getCategoryName($doc): string;

    abstract protected function getContent($doc): string;

    abstract protected function getAuthorNames($doc): array;
}
