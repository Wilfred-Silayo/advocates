<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Display a listing of the articles
    public function index()
    {
        $articles = Article::paginate(15);
        return view('articles.index', compact('articles'));
    }

    // Show the form for creating a new article
    public function create()
    {
        return view('articles.create');
    }

    // Store a newly created article in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Article::create($request->all());
        return redirect()->route('articles.index')
            ->with('success', 'Article created successfully.');
    }

    // Display the specified article
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    // Show the form for editing the specified article
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    // Update the specified article in storage
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $article->update($request->all());
        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully.');
    }

    // Remove the specified article from storage
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}
