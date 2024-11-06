<?php


namespace App\Services;

use App\Models\Article;

class NewsService
{

    public function getArticles($request, $page)
    {
        $query = Article::with(['source:id,name', 'category:id,name', 'authors:id,name'])
            ->select('id', 'title', 'content', 'source_id', 'category_id', 'slug', 'published_at');

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('content', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('published_at', $request->date);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('source')) {
            $query->where('source_id', $request->source);
        }

        return $query->orderBy('published_at', 'desc')->paginate(6, ['*'], 'page', $page);
    }
}
