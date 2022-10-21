<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the logged user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = User::query()
            ->with(['role.permissions'])
            ->findOrFail(Auth::id());

        return response()->json([
            'data' => $user
        ], JsonResponse::HTTP_OK);
    }

    public function articles()
    {
        $articles = Article::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'data' => $articles
        ], JsonResponse::HTTP_OK);
    }
}
