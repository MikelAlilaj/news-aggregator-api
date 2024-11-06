<?php


namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class PersonalizedNewsService
{
    public function getPersonalizedArticles($page)
    {
        $user = Auth::user()->load(['sources', 'categories', 'authors']); 
        
        $userSources = $user->sources->pluck('source_id')->toArray();  
        $userCategories = $user->categories->pluck('category_id')->toArray();  
        $userAuthors = $user->authors->pluck('author_id')->toArray();  

        return Article::with(['source:id,name', 'category:id,name', 'authors:id,name'])
            ->select('id', 'title', 'content', 'source_id', 'category_id', 'slug', 'published_at')
            ->where(function ($query) use ($userSources, $userCategories, $userAuthors) {
                $query->whereIn('source_id', $userSources)
                    ->orWhereIn('category_id', $userCategories)
                    ->orWhereHas('authors', function ($authorQuery) use ($userAuthors) {
                        $authorQuery->whereIn('author_id', $userAuthors);
                    });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(6, null, 'page', $page);
    }
}
