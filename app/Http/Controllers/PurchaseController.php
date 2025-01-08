<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function getPurchasePage(Request $req)
    {
        $filter = $req->filter;
        $query = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc');

        if (!is_null($filter) && $filter !== 'all') {
            $query->where('status', $filter);
        }

        $purchaseList = $query->get();
        return view('pages.purchase.index', compact('purchaseList'));
    }
}
