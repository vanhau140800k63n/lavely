<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\ProdAttr;
use App\Models\ProdAttrVal;
use App\Models\ProdItem;
use App\Models\Product;
use App\Models\ProductStatus;
use App\Models\Shop;
use App\Utils\CurlUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    public function getProductPage()
    {
        return view('pages.admin.product.index');
    }

    public function getProductSelly(Request $req)
    {
        return view('pages.admin.product.index');
    }

    public function getProductSellyAjax(Request $req)
    {
        $page = $req->page;
        $nextPageToken = $req->nextPageToken;

        if ($page !== null) {
            $data = array("page" => intval($page));
            $jsonString = json_encode($data);
            $base64String = base64_encode($jsonString);

            $curl = curl_init();
            curl_setopt_array(
                $curl,
                CurlUtils::setOptArray('https://app-api.selly.vn/products?limit=20&page=' . $page .
                    '&sort=top_sale&city=&category=5fd9b79bbabb26c76c11a2e0&subCategory=&pageToken=' . $base64String . '&nextPageToken=' . $nextPageToken)
            );

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response, true);

            foreach ($response['data']['products'] as $key => $value) {
                ProductStatus::firstOrCreate([
                    'product_code' => $value['_id'],
                    'status' => false,
                ]);
            }

            return response()->json($response);
        } else {
            return response()->json(false);
        }
    }

    public function getProductInfoSellyAjax()
    {
        $productStatus = ProductStatus::where('status', false)->first();
        if ($productStatus) {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                CurlUtils::setOptArray('https://app-api.selly.vn/products/' . $productStatus->product_code . '?inventory=')
            );

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response, true)['data']['product'];

            DB::beginTransaction();
            try {
                $firstCategory = null;
                foreach ($response['categories'] as $category_item) {
                    $category = Category::firstOrCreate(
                        ['selly_category_id' => $category_item['_id']],
                        [
                            'name' => $category_item['name'],
                            'selly_category_id' => $category_item['_id'],
                        ]
                    );

                    $firstCategory = $firstCategory ?? $category;
                }

                $shop = Shop::firstOrCreate(
                    ['selly_shop_id' => $response['supplier']['_id']],
                    [
                        'name' => $response['supplier']['name'],
                        'selly_shop_id' => $response['supplier']['_id'],
                        'image' => $response['supplier']['logo']['dimensions']['sm']['url'],
                        'description' => '',
                        'product_count' => 0,
                        'sold_count' => 0,
                        'location' => '',
                    ]
                );


                $brand = null;
                if (array_key_exists('brand', $response)) {
                    $brand = Brand::firstOrCreate(
                        ['selly_brand_id' => $response['brand']['_id']],
                        [
                            'name' => $response['brand']['name'],
                            'selly_brand_id' => $response['brand']['_id'],
                            'image' => $response['brand']['logo']['dimensions']['sm']['url'],
                            'description' => $response['brand']['desc'],
                        ]
                    );
                }

                $product = Product::firstOrCreate(
                    ['selly_product_id' => $productStatus->product_code],
                    [
                        'name' => $response['name'],
                        'original_price' => $response['price']['minimum'],
                        'max_price' => $response['price']['maximum'],
                        'selling_price' => $response['price']['maximum'],
                        'sold' => $response['statistic']['totalSell'],
                        'rate' => $response['reviewStatistic']['scoreAverage'],
                        'brand_id' => $brand !== null ? $brand->id : 0,
                        'category_id' => $firstCategory->id,
                        'description' => $response['desc'],
                        'shop_id' => $shop->id,
                    ]
                );

                foreach ($response['photos'] as $photo) {
                    Image::firstOrCreate(
                        ['url' => $photo['dimensions']['sm']['url']],
                        [
                            'url' => $photo['dimensions']['sm']['url'],
                            'selly_url' => $photo['dimensions']['md']['url'],
                            'product_id' => $product->id
                        ]
                    );
                }

                foreach ($response['items'] as $item) {
                    $attr = '';
                    foreach ($item['properties'] as $propertie) {
                        $prodAttr = ProdAttr::firstOrCreate(
                            ['selly_attr_prod_id' => $propertie['_id'], 'product_id' => $product->id],
                            [
                                'name' => $propertie['name'],
                                'product_id' => $product->id,
                                'selly_attr_prod_id' => $propertie['_id']
                            ]
                        );

                        $prodAttrVal = ProdAttrVal::firstOrCreate(
                            [
                                'selly_prod_attr_val_id' => $propertie['value']['_id'],
                                'prod_attr_id' => $prodAttr->id,
                            ],
                            [
                                'prod_attr_id' => $prodAttr->id,
                                'value' => $propertie['value']['name'],
                                'selly_prod_attr_val_id' => $propertie['value']['_id']
                            ]
                        );

                        $attr .= $attr == '' ? ($prodAttrVal->id) : ('-' . $prodAttrVal->id);
                    }

                    ProdItem::firstOrCreate(
                        ['attr' => $attr, 'product_id' => $product->id],
                        [
                            'attr' => $attr,
                            'image' => $item['picture'],
                            'product_id' => $product->id,
                            'is_out_of_stock' => $item['isOutOfStock']
                        ]
                    );
                }

                $productStatus->status = true;
                $productStatus->save();

                DB::commit();
            } catch (Throwable $ex) {
                return response()->json($ex->getMessage() . $ex->getLine());
                DB::rollBack();
            }

            return response()->json(true);
        }
        return response()->json(false);
    }
}
