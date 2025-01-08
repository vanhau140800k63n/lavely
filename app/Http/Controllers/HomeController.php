<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHomePage()
    {
        $categories = Category::all();
        $products = [];
        foreach ($categories as $category) {
            $products[$category->id] = Product::where('category_id', $category->id)->inRandomOrder()->take(24)->get();
        }
        return view('pages.home.index', compact('products', 'categories'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->select('id', 'name')
            ->limit(10)
            ->get();

        return $this->responseAjax(['products' => $products]);
    }
}
