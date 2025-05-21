<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse { return response()->json(Product::all()); }
    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'expired_at' => 'nullable|date',
            'modified_by' => 'required|string|max:255'
        ]);
        return response()->json(Product::create($validated), 201);
    }
    public function show($id): JsonResponse { return response()->json(Product::findOrFail($id)); }
    public function update(Request $request, $id): JsonResponse {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'image' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'expired_at' => 'nullable|date',
            'modified_by' => 'required|string|max:255'
        ]);
        $product->update($validated);
        return response()->json($product);
    }
    public function destroy($id): JsonResponse {
        Product::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}