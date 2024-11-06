<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        $sources = Source::select('id', 'name')->orderBy('name', 'asc')->get();
        return response()->json($sources, 200);
    }
}
