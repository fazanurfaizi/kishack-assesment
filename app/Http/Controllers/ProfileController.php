<?php

namespace App\Http\Controllers;

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
            ->with(['role'])
            ->findOrFail(Auth::id());

        return response()->json([
            'data' => $user
        ], JsonResponse::HTTP_OK);
    }
}
