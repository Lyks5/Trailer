<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\models\Poster;
use App\models\Genre;
use App\Models\User;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Analytic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.data', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('comments');
        return response()->json($user);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json(['message' => 'User updated successfully']);
    }
}
