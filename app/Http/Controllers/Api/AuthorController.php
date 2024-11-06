<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::select('id', 'name')->orderBy('name', 'asc')->get();
        return response()->json($authors, 200);
    }
}
