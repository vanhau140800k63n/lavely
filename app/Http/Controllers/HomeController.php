<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Throwable;

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

    public function searchKey(Request $request)
    {
        return $this->performSearch($request, 'keyword', null);
    }

    public function searchBrand($brandId, Request $request)
    {
        return $this->performSearch($request, 'brand', $brandId);
    }

    public function searchCategory($categoryId, Request $request)
    {
        return $this->performSearch($request, 'category', $categoryId);
    }

    public function searchShop($shopId, Request $request)
    {
        return $this->performSearch($request, 'shop', $shopId);
    }

    private function performSearch(Request $request, $type = null, $id = null)
    {
        try {
            $keyword = $request->input('keyword', '');
            $soldOrder = $this->validateOrder($request->input('sold'));
            $ratedOrder = $this->validateOrder($request->input('rated'));
            $priceOrder = $this->validateOrder($request->input('price'));

            $query = Product::query();

            $info = null;
            switch ($type) {
                case 'brand':
                    $query->where('brand_id', $id);
                    $info = Brand::find($id);
                    break;
                case 'category':
                    $query->where('category_id', $id);
                    $info = Category::find($id);
                    break;
                case 'shop':
                    $query->where('shop_id', $id);
                    $info = Shop::find($id);
                    break;
                default:
                    $info = $keyword;
                    if (!empty($keyword)) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    }
                    break;
            }

            if ($type && !$info) {
                return redirect()->back()->withErrors(ucfirst($type) . ' not found.');
            }

            if ($soldOrder) {
                $query->orderBy('sold', $soldOrder);
            }
            if ($ratedOrder) {
                $query->orderBy('rate', $ratedOrder);
            }
            if ($priceOrder) {
                $query->orderBy('max_price', $priceOrder);
            }

            $appends = [
                'sold' => $soldOrder,
                'rated' => $ratedOrder,
                'price' => $priceOrder,
            ];

            if (!empty($keyword)) {
                $appends['keyword'] = $keyword;
            }

            $products = $query->paginate(24)->appends($appends);

            $searchInfo = $request->all();
            $searchInfo['type'] = $type;
            $searchInfo['info'] = $info;
            if (isset($info->name)) {
                $keyword = $info->name;
            }

            return view('pages.search.index', compact('keyword', 'products', 'searchInfo'));
        } catch (Throwable $e) {
            return redirect()->back()->withErrors('An error occurred while performing the search. Please try again.');
        }
    }

    private function validateOrder($order)
    {
        $order = strtolower($order);
        return in_array($order, ['asc', 'desc']) ? $order : null;
    }
}
