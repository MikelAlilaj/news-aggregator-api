<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PersonalizedNewsService;
use Illuminate\Http\Request;

class PersonalizedNewsController extends Controller
{
    protected $personalizedNewsService;

    public function __construct(PersonalizedNewsService $personalizedNewsService)
    {
        $this->personalizedNewsService = $personalizedNewsService;
    }

    public function index(Request $request)
    {
        $currentPage = $request->input('page', 1);  
        $articles = $this->personalizedNewsService->getPersonalizedArticles($currentPage);
    
        return response()->json([
            'success' => true,
            'data' => $articles->items(),
            'current_page' => $articles->currentPage(),
            'total_pages' => $articles->lastPage(),
        ], 200);
    }
    
}
