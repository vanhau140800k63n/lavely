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
            $products[$category->id] = Product::where('category_id', $category->id)->orderBy('sold', 'desc')->take(12)->get();
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

    public function searchKey(Request $req)
    {
        $products = [];
        $keyWord = $req->keyword;

        $products = Product::where('name', 'like', '%' . $keyWord . '%')
            ->limit(10)
            ->get();
        return view('pages.search.index', compact('keyWord', 'products'));
    }

    public function searchBrand($id, Request $req) {
        $products = Product::where('name', 'like', '%' . $id . '%')
            ->limit(10)
            ->get();
    }

    public function searchCategory($id, Request $req) {}

    public function searchShop($id, Request $req) {}
}
