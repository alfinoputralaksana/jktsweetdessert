<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        // Get best seller products (top 8 by sold_count)
        $bestSellers = Product::with('category')
            ->where('is_active', true)
            ->where('sold_count', '>', 0)
            ->orderBy('sold_count', 'desc')
            ->limit(8)
            ->get();
        
        // Get products grouped by category
        $productsByCategory = Category::where('is_active', true)
            ->with(['products' => function($query) {
                $query->where('is_active', true)->limit(6);
            }])
            ->whereHas('products', function($query) {
                $query->where('is_active', true);
            })
            ->get();

        // Get top products from forecasting
        $topProducts = \App\Http\Controllers\ForecastingController::getTopProducts(6);

        return view('products.index', compact('products', 'categories', 'bestSellers', 'productsByCategory', 'topProducts'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
