<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Article::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'Title' => 'required',
            'Content' => 'required',
        ]);

        $article = Article::create([
            'Title' => request('Title'),
            'Content' => request('Content')
        ]);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        // validate input
        request()->validate([
            'Title' => 'required',
            'Content' => 'required',
        ]);

        $isSuccess = $article->update([
            'Title' => request('Title'),
            'Content' => request('Content'),
        ]);

        return response()->json([
            'success' => $isSuccess,
            'data' => $article
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        $isSuccess = $article->delete();

        return response()->json([
            'success' => $isSuccess
        ]);

    }
}
