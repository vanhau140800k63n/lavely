<?php

namespace App\Http\Controllers;

use App\Enums\VoucherType;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class VoucherController extends Controller
{
    public function getVoucherPage()
    {
        $vouchers = Voucher::all();
        return view('pages.voucher.index', compact('vouchers'));
    }

    public function applyVoucher(Request $request)
    {
        try {
            $cartItemIdsInSession = session('cart_items');
            if (!is_array($cartItemIdsInSession) || count($cartItemIdsInSession) === 0) {
                return $this->responseAjax(null, 'Giỏ hàng trống.');
            }

            $cartItems = Cart::where('user_id', Auth::id())
                ->whereIn('id', $cartItemIdsInSession)
                ->get();

            if ($cartItems->isEmpty()) {
                return $this->responseAjax(null, 'Không tìm thấy sản phẩm trong giỏ hàng.');
            }

            $totalCartValue = $cartItems->sum(fn($item) => $item->quantity * $item->price);

            $voucher = null;
            if ($request->filled('voucher_code') && $request->filled('voucher_id')) {
                $voucher = Voucher::where(['id' => $request->voucher_id, 'code' => $request->voucher_code])->first();

                if (!$voucher || !$voucher->isValid()) {
                    return $this->responseAjax(null, 'Voucher không hợp lệ.');
                }
            }

            $appliedVoucherIds = session('voucher_items', []);
            if (!is_array($appliedVoucherIds)) {
                $appliedVoucherIds = [];
            }

            $appliedVouchers = Voucher::whereIn('id', $appliedVoucherIds)->get();

            if ($voucher) {
                $appliedVouchers = $this->mergeVoucherIntoAppliedList($appliedVouchers, $voucher);
            }

            $appliedVouchers = $appliedVouchers->sort(function ($a, $b) {
                return $a->voucherType()->priority() <=> $b->voucherType()->priority();
            })->values();

            $totalDiscount = 0;
            $updatedVoucherIds = [];
            $responseVouchers = [];

            foreach ($appliedVouchers as $appliedVoucher) {
                $discountValue = 0;

                switch ($appliedVoucher->voucherType()) {
                    case VoucherType::ORDER:
                        if (!$appliedVoucher->isApplicableToOrder($totalCartValue - $totalDiscount)) {
                            if ($voucher && $appliedVoucher->id === $voucher->id) {
                                return $this->responseAjax(null, 'Không được áp dụng. Giá trị đơn hàng phải từ ' . $voucher->minimum_spend);
                            }
                            break;
                        }
                        $discountValue = $this->calculateDiscount($totalCartValue - $totalDiscount, $appliedVoucher);
                        break;

                    case VoucherType::PRODUCT:
                        foreach ($cartItems as $item) {
                            if ($appliedVoucher->isApplicableToProduct($item->product_id)) {
                                $discountValue += $this->calculateDiscount($item->price, $appliedVoucher);
                            }
                        }
                        break;

                    case VoucherType::SHIPPING:
                        if (!$appliedVoucher->isApplicableToOrder($totalCartValue - $totalDiscount)) {
                            if ($voucher && $appliedVoucher->id === $voucher->id) {
                                return $this->responseAjax(null, 'Không được áp dụng. Giá trị đơn hàng phải từ ' . number_format($voucher->minimum_spend) . 'đ');
                            }
                            break;
                        }
                        $discountValue = $this->calculateDiscount(35000, $appliedVoucher);
                        break;

                    default:
                        break;
                }

                if ($discountValue > 0) {
                    $totalDiscount += $discountValue;
                    $responseVouchers[] = [
                        'type' => $appliedVoucher->type,
                        'discount' => $discountValue,
                        'id' => $appliedVoucher->id
                    ];

                    $updatedVoucherIds[] = $appliedVoucher->id;
                }
            }

            session(['voucher_items' => $updatedVoucherIds]);

            return $this->responseAjax([
                'appliedVouchers' => $responseVouchers,
                'totalDiscount' => $totalDiscount,
                'totalCartValue' => $totalCartValue
            ]);
        } catch (Throwable $e) {
            return $this->responseAjax(null, 'Đã xảy ra lỗi trong quá trình áp dụng voucher.');
        }
    }

    private function mergeVoucherIntoAppliedList($appliedVouchers, $newVoucher)
    {
        if ($newVoucher->voucherType() === VoucherType::PRODUCT) {
            $appliedVouchers->push($newVoucher);
            return $appliedVouchers;
        }

        $appliedVouchers = $appliedVouchers->filter(function ($voucher) use ($newVoucher) {
            return $voucher->voucherType() !== $newVoucher->voucherType();
        });

        $appliedVouchers->push($newVoucher);

        return $appliedVouchers;
    }
}
