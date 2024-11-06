<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);  
        $articles = $this->newsService->getArticles($request, $page);

        return response()->json([
            'success' => true,
            'data' => $articles->items(),
            'current_page' => $articles->currentPage(),
            'total_pages' => $articles->lastPage(),
        ], 200);
    }
}
