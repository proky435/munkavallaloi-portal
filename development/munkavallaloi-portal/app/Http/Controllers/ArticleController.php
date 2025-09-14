<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::where('is_published', true)->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        // Biztonsági ellenőrzés: csak publikált cikket lehet megnézni
        if (! $article->is_published) {
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}

