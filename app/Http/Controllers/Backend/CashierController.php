<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\CartDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('owner')) {
            $products = Product::orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::where('branch_id', Auth::user()->branch_id)->orderBy('created_at', 'desc')->get();
        }

        $data = [
            'products' => $products,
            'cart' => Cart::where('status', 'pending')->orderBy('created_at', 'desc')->first(),
            'discounts' => Discount::where('status', 'Aktif')->orderBy('created_at', 'asc')->get(),
        ];

        return view('backend.cashier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function select($id)
    {
        $product = Product::find($id);

        if ($product->id != $id) {
            return response()->json(['message' => 'Produk tidak ada!']);
        } else if ($product->stock == 0) {
            return response()->json(['message' => 'Stok produk kosong!']);
        }

        $cartData = Cart::firstOrCreate(['status' => 'pending'], ['status' => 'pending']);

        $cartDetail = CartDetail::where('cart_id', $cartData->id)
            ->where('product_id', $id)
            ->first();

        if ($cartDetail) {
            $cartDetail->qty += 1;
            $cartDetail->amount += $product->price;
            $cartDetail->save();
        } else {
            CartDetail::create([
                'cart_id' => $cartData->id,
                'product_id' => $product->id,
                'qty' => 1,
                'amount' => $product->price,
            ]);
        }

        $product->stock -= 1;
        $product->save();

        $cart = Cart::with(['cartDetails.product'])->where('status', 'pending')->orderBy('created_at', 'desc')->first();

        return response()->json(['cart' => $cart]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart_id = $request->cart_id;
        $subtotal = $request->subtotal;
        $total = $request->total;
        $money = $request->money;
        
        if (!$subtotal) {
            return response()->json(['error' => 'subtotal masih Rp 0!']);
        }

        if (!$total) {
            return response()->json(['error' => 'Total masih Rp 0!']);
        }
        
        if (!$money) {
            return response()->json(['error' => 'Bayar belum terisi!']);
        }

        $transaction = Transaction::create([
            'cashier_id' => Auth::user()->id,
            'cart_id' => $cart_id,
            'branch_id' => Auth::user()->branch_id,
            'discount_id' => $request->discount_id,
            'subtotal' => $subtotal,
            'total' => $total,
            'money' => $money,
            'change_money' => $request->change_money,
        ]);

        $cart = Cart::find($cart_id);
        $cart->update(['status' => 'Terbayar']);

        return response()->json(['transaction_id' => $transaction->id, 'message' => 'Berhasil dibayar!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartDetail = CartDetail::find($id);

        $product = Product::find($cartDetail->product_id);

        if ($product) {
            $product->stock += $cartDetail->qty;
            $product->save();
        }

        $cartDetail->delete();

        $cart = Cart::with(['cartDetails.product'])->where('status', 'pending')->orderBy('created_at', 'desc')->first();

        return response()->json(['cart' => $cart]);
    }
}
