<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Helpers\SanitizationHelper;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource (GET /api/students)
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return response()->json($articles, 200);
    }

    /**
     * Store a newly created resource in storage (POST /api/students)
     */
    public function store(StoreArticleRequest $request)
    {
        try {
            $article = Article::create([
                'Title' => SanitizationHelper::sanitizeInput($request->Title),
                'Content' => SanitizationHelper::sanitizeHtml($request->Content ?? '')
            ]);

            return response()->json([
                'message' => 'Article created',
                'data' => $article
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating article',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified resource (GET /api/students/{id})
     */
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        return response()->json($article, 200);
    }

    /**
     * Update the specified resource in storage (PUT /api/students/{id})
     */
    public function update(StoreArticleRequest $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        try {
            $article->update([
                'Title' => SanitizationHelper::sanitizeInput($request->Title),
                'Content' => SanitizationHelper::sanitizeHtml($request->Content ?? '')
            ]);

            return response()->json([
                'message' => 'Article updated',
                'data' => $article
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating article',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage (DELETE /api/students/{id})
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        try {
            $article->delete();
            return response()->json([
                'message' => 'Article deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting article',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
