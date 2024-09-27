<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function validateUser(Request $request, User $user = null)
    {
        $rules = [
            'username' => 'required|unique:users,username' . ($user ? ",{$user->id}" : ''),
            'email' => 'required|unique:users,email' . ($user ? ",{$user->id}" : ''),
            'password' => $user ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required|in:admin,user',
        ];

        return $request->validate($rules);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);
        $users = User::paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'current_page' => intval($page),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'from' => $users->firstItem(),
            'to' => $users->lastItem(),
            'first_page_url' => $users->url(1),
            'last_page_url' => $users->url($users->lastPage()),
            'next_page_url' => $users->nextPageUrl(),
            'prev_page_url' => $users->previousPageUrl(),
            'path' => $users->path(),
            'data' => $users->items(),
        ], 200);
    }

    public function getAllUsers()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateUser($request);


        $post = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        // send email verification
        // $post->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if(!$user)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validateUser($request, $user);

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        if($request->filled('password'))
        {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $name = $user->username;
        $user = User::where('uuid', $uuid)->first();

        return response()->json([
           'status' => 'success',
           'data' => "User $name deleted successfully"
        ], 200);
    }
}
