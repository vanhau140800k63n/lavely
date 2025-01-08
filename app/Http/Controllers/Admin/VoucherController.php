<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DiscountType;
use App\Enums\VoucherStatus;
use App\Enums\VoucherType;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class VoucherController extends Controller
{
    public function list()
    {
        $vouchers = Voucher::all();
        return view('pages.admin.voucher.list', compact('vouchers'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pages.admin.voucher.form');
        }

        try {
            $validated = $request->validate([
                'code' => 'required|unique:voucher',
                'type' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, VoucherType::cases())),
                'discount_type' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, DiscountType::cases())),
                'discount_amount' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'maximum_discount' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'status' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, VoucherStatus::cases())),
            ]);
            DB::transaction(function () use ($validated) {
                Voucher::create($validated);
            });

            return redirect()->route('admin.voucher.list')->with('success', 'Voucher created successfully!');
        } catch (Throwable $e) {
            dd($e->getMessage());
            return redirect()->route('admin.voucher.list')->with('error', 'Failed to create voucher: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Voucher $voucher)
    {
        try {
            if (!$voucher) {
                abort(404, 'Voucher not found');
            }

            if ($request->isMethod('get')) {
                return view('pages.admin.voucher.form', compact('voucher'));
            }

            $validated = $request->validate([
                'code' => 'required|unique:voucher,code,' . $voucher->id,
                'type' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, VoucherType::cases())),
                'discount_type' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, DiscountType::cases())),
                'discount_amount' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'maximum_discount' => 'nullable|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'status' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, VoucherStatus::cases())),
            ]);

            DB::transaction(function () use ($voucher, $validated) {
                $voucher->update($validated);
            });

            return redirect()->back()->with('success', 'Voucher updated successfully!');
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('error', 'Failed to update voucher: ' . $e->getMessage());
        }
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher đã được xóa thành công!');
    }
}
