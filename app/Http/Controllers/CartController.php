<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProdItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartController extends Controller
{
    public function getCartDetail()
    {
        $cart = Cart::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('pages.cart.index', compact('cart'));
    }

    public function addToCart(Request $req)
    {
        DB::beginTransaction();

        try {
            $prodAttrVal = $req->prodAttrVal;
            $quantity = $req->quantity;
            $productId = $req->productId;

            $product = Product::find($productId);
            if (!$product || !$quantity) {
                return $this->responseAjax(null, 'Thông tin sản phẩm không đúng');
            }

            $prodAttrStatus = false;
            $prodItemId = null;

            $prodItems = ProdItem::where('product_id', $productId)->get();

            if ($prodItems->isNotEmpty()) {
                foreach ($prodItems as $prodItem) {
                    $prodItemAttr = explode('-', $prodItem->attr);
                    if ($this->arrayAreEqual($prodAttrVal, $prodItemAttr)) {
                        $prodItemId  = $prodItem->id;
                        $prodAttrStatus = true;
                        break;
                    }
                }
            } elseif (empty($prodAttrVal)) {
                $prodAttrStatus = true;
            }

            if (!$prodAttrStatus) {
                return $this->responseAjax(null, 'Không tìm thấy phân loại sản phẩm');
            }

            $productCart = Cart::create(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'prod_item_id' => $prodItemId,
                    'quantity' => $quantity,
                    'price' => $product->max_price,
                ]
            );

            session(['cart_quantity' => Cart::where('user_id', Auth::id())->count()]);
            DB::commit();
            return $this->responseAjax($productCart);
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->responseAjax(null, $ex->getMessage() . $ex->getLine());
        }
    }

    function updateProductCart(Request $req)
    {
        DB::beginTransaction();
        try {
            $cartItem = Cart::find($req->cartItemId);

            if (is_null($cartItem)) {
                return $this->responseAjax(null, 'Không thể cập nhật giỏ hàng');
            }

            switch ($req->action) {
                case 1:
                    if ($cartItem->quantity > 1) {
                        $cartItem->quantity -= 1;
                    }
                    break;
                case 2:
                    $cartItem->quantity += 1;
                    break;
                case 3:
                    $cartItem->delete();
                    DB::commit();
                    return $this->responseAjax(null, 'Sản phẩm đã được xóa khỏi giỏ hàng');
            }

            if ($req->action !== 3) {
                $cartItem->save();
            }

            DB::commit();
            return $this->responseAjax($cartItem->cartProductInfo());
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->responseAjax(null, 'Có lỗi xảy ra');
        }
    }

    public function deleteProductCart($id)
    {
        DB::beginTransaction();
        try {
            $cartItem = Cart::find($id);

            if (is_null($cartItem)) {
                return $this->responseAjax(null, 'Không thể xóa sản phẩm');
            }

            $cartItem->delete();
            DB::commit();
            return $this->responseAjax();
        } catch (Throwable) {
            DB::rollBack();
            return $this->responseAjax(null, 'Có lỗi xảy ra');
        }
    }

    public function checkout(Request $request)
    {
        $cartItems = $request->input('cartItems', []);

        if (empty($cartItems)) {
            return $this->responseAjax(null, 'Giỏ hàng của bạn đang trống.');
        }

        $dbCartItems = Cart::where('user_id', Auth::id())
            ->whereIn('id', $cartItems)
            ->pluck('id')
            ->toArray();

        if (count($dbCartItems) !== count($cartItems)) {
            return $this->responseAjax(null, 'Có lỗi xảy ra. Một số mục không hợp lệ.');
        }

        session(['cart_items' => $cartItems]);
        session()->forget('voucher_items');
        return $this->responseAjax();
    }
}
