<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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

    public function downloadPdf(Article $article): Response
    {
        // Biztonsági ellenőrzés: csak publikált cikket lehet letölteni
        if (! $article->is_published) {
            abort(404);
        }

        // Ellenőrizzük, hogy van-e PDF melléklet
        if (! $article->pdf_attachment) {
            abort(404, 'PDF melléklet nem található.');
        }

        // Ellenőrizzük, hogy a fájl létezik-e
        if (! Storage::disk('public')->exists($article->pdf_attachment)) {
            abort(404, 'PDF fájl nem található a szerveren.');
        }

        // Letöltés
        return Storage::disk('public')->download(
            $article->pdf_attachment,
            $article->pdf_original_name ?: 'document.pdf'
        );
    }
}

