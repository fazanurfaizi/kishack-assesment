<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), fn($q) => $q->where('name', 'LIKE', "%{$request->get('search')}%"))
            ->latest()
            ->paginate($request->get('limit'));

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('users', $request->file('image'));
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $path,
            'role_id' => $request->role_id
        ]);

        return response()->json([
            'data' => 'User created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('users', $request->file('image'));
            $user->forceFill([
                'image' => $path
            ]);
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id
        ]);

        if($request->filled('password')) {
            $user->forceFill([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::query()
            ->whereIn('id', $request->post('ids'))
            ->delete();

        return response()->json([
            'message' => 'Selected users deleted successfully'
        ]);
    }
}
