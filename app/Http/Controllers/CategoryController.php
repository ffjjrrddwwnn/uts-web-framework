<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse { return response()->json(Category::all()); }
    public function store(Request $request): JsonResponse {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        return response()->json(Category::create($validated), 201);
    }
    public function show($id): JsonResponse { return response()->json(Category::findOrFail($id)); }
    public function update(Request $request, $id): JsonResponse {
        $category = Category::findOrFail($id);
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $category->update($validated);
        return response()->json($category);
    }
    public function destroy($id): JsonResponse {
        Category::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}