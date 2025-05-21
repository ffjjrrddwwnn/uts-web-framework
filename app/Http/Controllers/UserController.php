<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse { return response()->json(User::all()); }
    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user'
        ]);
        $validated['password'] = Hash::make($validated['password']);
        return response()->json(User::create($validated), 201);
    }
    public function show($id): JsonResponse { return response()->json(User::findOrFail($id)); }
    public function update(Request $request, $id): JsonResponse {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'role' => 'required|in:admin,user'
        ]);
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $user->update($validated);
        return response()->json($user);
    }
    public function destroy($id): JsonResponse {
        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}