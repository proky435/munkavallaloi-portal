<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.articles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'sometimes|boolean',
            'pdf_attachment' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        // Handle PDF upload
        if ($request->hasFile('pdf_attachment')) {
            $file = $request->file('pdf_attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('articles/pdfs', $filename, 'public');
            
            $validated['pdf_attachment'] = $path;
            $validated['pdf_original_name'] = $file->getClientOriginalName();
            $validated['pdf_size'] = $file->getSize();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Cikk sikeresen létrehozva.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'sometimes|boolean',
            'pdf_attachment' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');

        // Handle PDF upload
        if ($request->hasFile('pdf_attachment')) {
            // Delete old PDF if exists
            if ($article->pdf_attachment && \Storage::disk('public')->exists($article->pdf_attachment)) {
                \Storage::disk('public')->delete($article->pdf_attachment);
            }
            
            $file = $request->file('pdf_attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('articles/pdfs', $filename, 'public');
            
            $validated['pdf_attachment'] = $path;
            $validated['pdf_original_name'] = $file->getClientOriginalName();
            $validated['pdf_size'] = $file->getSize();
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Cikk sikeresen frissítve.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Cikk sikeresen törölve.');
    }
}