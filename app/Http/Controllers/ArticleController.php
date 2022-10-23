<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Auth::user()->can('list-articles');

        $articles = Article::query()
            ->with(['category'])
            ->when($request->filled('search'), fn($q) => $q->where('title', 'LIKE', "%{$request->get('search')}%"))
            ->when($request->filled('category_id'), fn($q) => $q->where('category_id', $request->get('category_id')))
            ->latest()
            ->paginate($request->get('limit'));

        return response()->json([
            'data' => $articles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        Auth::user()->can('create-articles');

        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('articles', $request->file('image'));
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'image' => $path
        ]);

        return response()->json([
            'data' => 'Article created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        Auth::user()->can('show-articles');

        $article->load(['category', 'user']);

        $recommendations = Article::query()
            ->where('category_id', $article->category_id)
            ->where('user_id', '!=', Auth::id())
            ->get();

        return response()->json([
            'article' => $article,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        Auth::user()->can('update-articles');

        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('articles', $request->file('image'));
            $article->forceFill([
                'image' => $path
            ]);
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        $article->save();

        return response()->json([
            'message' => 'Article updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::user()->can('delete-articles');

        Article::query()
            ->whereIn('id', $request->input('ids'))
            ->delete();

        return response()->json([
            'message' => 'Selected articles deleted successfully'
        ]);
    }
}
