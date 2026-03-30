<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Helpers\SanitizationHelper;

class CrudController extends Controller
{

    /**
     * Display CRUD index page with search
     */
    public function index(Request $request)
    {
        $title = $request->query('title', '');
        
        $articles = Article::orderBy('created_at', 'desc');
        
        // Filter by title if search provided
        if ($title) {
            $articles = $articles->where('Title', 'like', '%' . $title . '%');
        }
        
        return view('crud.index', [
            'articles' => $articles->get()->toArray(),
            'searchTitle' => $title
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('crud.create');
    }

    /**
     * Store article directly
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Title' => 'required|string|max:255',
            'Content' => 'nullable|string',
        ]);

        try {
            Article::create([
                'Title' => SanitizationHelper::sanitizeInput($validated['Title']),
                'Content' => SanitizationHelper::sanitizeHtml($validated['Content'] ?? '')
            ]);

            return redirect('/crud')->with('success', 'Article created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show single article (read)
     */
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect('/crud')->with('error', 'Article not found');
        }

        return view('crud.show', ['article' => $article->toArray()]);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect('/crud')->with('error', 'Article not found');
        }

        return view('crud.edit', ['article' => $article->toArray()]);
    }

    /**
     * Update article directly
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect('/crud')->with('error', 'Article not found');
        }

        $validated = $request->validate([
            'Title' => 'required|string|max:255',
            'Content' => 'nullable|string',
        ]);

        try {
            $article->update([
                'Title' => SanitizationHelper::sanitizeInput($validated['Title']),
                'Content' => SanitizationHelper::sanitizeHtml($validated['Content'] ?? '')
            ]);

            return redirect('/crud')->with('success', 'Article updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show delete confirmation
     */
    public function delete($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect('/crud')->with('error', 'Article not found');
        }

        return view('crud.delete', ['article' => $article->toArray()]);
    }

    /**
     * Destroy article directly
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect('/crud')->with('error', 'Article not found');
        }

        try {
            $article->delete();
            return redirect('/crud')->with('success', 'Article deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/crud')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
