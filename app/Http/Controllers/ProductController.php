<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\ProdAttr;
use App\Models\Product;
use App\Models\Shop;
use App\Utils\SeoUtils;

class ProductController extends Controller
{
    public function getProductDetail($id)
    {
        $product = Product::with(['shop', 'category', 'brand'])->find($id);
        $productImages = Image::where('product_id', $id)->get();
        $prodAttr = ProdAttr::where('product_id', $id)->get();
        $metaDescription = SeoUtils::generateDescription($product);
        $metaKeywords = SeoUtils::generateKeywords($product);

        return view('pages.product.index', compact('product', 'productImages', 'prodAttr', 'metaDescription', 'metaKeywords'));
    }
}
