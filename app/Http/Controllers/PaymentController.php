<?php

namespace App\Http\Controllers;

use App\Enums\VoucherStatus;
use App\Enums\VoucherType;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Voucher;
use App\Utils\PaymentUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PaymentController extends Controller
{
    public function getPaymentDetail()
    {
        $sessionCartItems = session('cart_items');
        if (!is_array($sessionCartItems) || count($sessionCartItems) === 0) {
            return redirect()->route('cart.detail');
        }
        $cartItems = Cart::where('user_id', Auth::id())
            ->whereIn('id', $sessionCartItems)->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $addresses = Address::where('user_id', Auth::id())->get();
        $addressDefault = $addresses->first();
        $communeData = PaymentUtils::getAllCommuneData();

        foreach ($addresses as $address) {
            if (isset($communeData[$address->commune])) {
                $address->path_with_type = $communeData[$address->commune]['path_with_type'];
            } else {
                $address->path_with_type = '';
            }
        }

        $vouchers = Voucher::where([
            ['status', '=', VoucherStatus::ACTIVE],
            ['end_date', '>=', now()],
            ['start_date', '<=', now()]
        ])->orderBy('type')->orderBy('discount_amount', 'DESC')->get();
        return view('pages.payment.index', compact('cartItems', 'addresses', 'addressDefault', 'totalPrice', 'vouchers'));
    }

    public function submitPayment(Request $req)
    {
        DB::beginTransaction();

        try {
            $rules = [
                'note' => 'nullable|string|max:500',
                'products' => 'required|array|min:1',
                'shipping_fee' => 'required|numeric|min:0',
                'address_id' => 'required|integer|exists:address,id',
                'address_id' => 'required|integer|exists:address,id',
                'applied_vouchers' => 'array'
            ];

            $validator = Validator::make($req->all(), $rules);
            if ($validator->fails()) {
                return $this->responseAjax(null, 'Thông tin đơn hàng không đúng.');
            }

            $sessionCartItems = session('cart_items');
            $reqCartItems = $req->products;
            if (!$this->arrayAreEqual($sessionCartItems, $reqCartItems)) {
                return $this->responseAjax(null, 'Thông tin sản phẩm không đúng.');
            }
            $user_id = Auth::id();
            $cartItems = Cart::where('user_id', $user_id)
                ->whereIn('id', $reqCartItems)->get();
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $appliedVoucherIds = session('voucher_items', []);
            if (!$this->arrayAreEqual($appliedVoucherIds, array_map('intval', $req->applied_vouchers ?? []))) {
                return $this->responseAjax(null, 'Thông tin áp dụng khuyến mãi không đúng.');
            }

            $appliedVouchers = Voucher::whereIn('id', $appliedVoucherIds)->get();
            $appliedVouchers = $appliedVouchers->sort(function ($a, $b) {
                return $a->voucherType()->priority() <=> $b->voucherType()->priority();
            })->values();

            $totalDiscount = 0;
            foreach ($appliedVouchers as $appliedVoucher) {
                $discountValue = 0;
                if (!$appliedVoucher->isValid()) {
                    return $this->responseAjax(null, 'Voucher đã hết hạn hoặc hết lượt sử dụng.');
                }

                switch ($appliedVoucher->voucherType()) {
                    case VoucherType::ORDER:
                        if (!$appliedVoucher->isApplicableToOrder($totalPrice - $totalDiscount)) {
                            return $this->responseAjax(null, 'Không được áp dụng. Giá trị đơn hàng phải từ ' . $appliedVoucher->minimum_spend . 'đ');
                        }
                        $discountValue = $this->calculateDiscount($totalPrice - $totalDiscount, $appliedVoucher);
                        break;

                    case VoucherType::PRODUCT:
                        foreach ($cartItems as $item) {
                            if ($appliedVoucher->isApplicableToProduct($item->product_id)) {
                                $discountValue += $this->calculateDiscount($item->price, $appliedVoucher);
                            }
                        }
                        break;

                    case VoucherType::SHIPPING:
                        if (!$appliedVoucher->isApplicableToOrder($totalPrice - $totalDiscount)) {
                            return $this->responseAjax(null, 'Không được áp dụng. Giá trị đơn hàng phải từ ' . number_format($appliedVoucher->minimum_spend) . 'đ');
                        }
                        $discountValue = $this->calculateDiscount($req->shipping_fee, $appliedVoucher);
                        break;

                    default:
                        break;
                }

                if ($discountValue > 0) {
                    $totalDiscount += $discountValue;
                }
            }

            $address = Address::where('id', $req->address_id)->where('user_id', $user_id)->first();
            if (is_null($address)) {
                return $this->responseAjax(null, 'Thông tin địa chỉ không đúng.');
            }

            $order = new Order();
            $order->user_id = Auth::id();
            $order->address_detail = $address->address_detail;
            $order->commune = PaymentUtils::getCommuneNameByCode($address->commune);
            $order->district = PaymentUtils::getDistrictNameByCode($address->district);
            $order->province = PaymentUtils::getProvinceNameByCode($address->province);
            $order->note = $req->note;
            $order->shipping_fee = $req->shipping_fee;
            $order->total_price = $totalPrice;
            $order->discount = $totalDiscount;
            $order->actual_price = $totalPrice + $req->shipping_fee - $totalDiscount;
            $order->status = 'pending';
            $order->save();

            foreach ($cartItems as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'prod_item_id' => $item->prod_item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            Cart::where('user_id', $user_id)
                ->whereIn('id', $reqCartItems)->delete();

            session(['cart_quantity' => Cart::where('user_id', Auth::id())->count()]);
            session()->forget('cart_items');
            session()->forget('voucher_items');
            DB::commit();

            return $this->responseAjax([
                'order_id' => $order->id,
                'message' => 'Đơn hàng đã được tạo thành công.'
            ]);
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->responseAjax(null, 'Thanh toán lỗi.');
        }
    }
}
