<?php

namespace App\Http\Controllers;

use App\Enums\DiscountType;
use App\Enums\VoucherType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responseAjax($data = null, string $error = null)
    {
        $res = $data ?? [];
        $success = is_null($error);

        $res['result'] = $success;
        if (!$success) {
            $res['error_msg'] = $error;
        }

        return response()->json($res);
    }

    protected function arrayAreEqual($array1, $array2)
    {
        if (
            !(is_array($array1) && is_array($array2))
            || count($array1) !== count($array2)
        ) return false;

        sort($array1);
        sort($array2);

        return $array1 === $array2;
    }

    protected function calculateDiscount($amount, $voucher)
    {
        $discountValue = 0;

        if ($voucher->discountType() === DiscountType::PERCENT) {
            $discountValue = ($amount * $voucher->discount_amount) / 100;
        } else {
            $discountValue = $voucher->discount_amount;
            if ($voucher->voucherType() === VoucherType::SHIPPING) {
                $discountValue = min($voucher->discount_amount, $amount);
            }
        }

        if (!is_null($voucher->maximum_discount)) {
            $discountValue = min($discountValue, $voucher->maximum_discount);
        }

        return $discountValue;
    }
}
