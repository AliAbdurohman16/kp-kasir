<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Hotel;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('owner')) {
            $data['products'] = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data['products'] = Product::where('branch_id', Auth::user()->branch_id)->orderBy('created_at', 'desc')->get();
        }

        return view('backend.product.index', $data);
    }

    public function safeStock()
    {
        if (Auth::user()->hasRole('owner')) {
            $data['products'] = Product::whereNot('stock', 0)->orderBy('created_at', 'desc')->get();
        } else {
            $data['products'] = Product::where('branch_id', Auth::user()->branch_id)->whereNot('stock', 0)->orderBy('created_at', 'desc')->get();
        }

        return view('backend.product.index', $data);
    }

    public function outOfStock()
    {
        if (Auth::user()->hasRole('owner')) {
            $data['products'] = Product::where('stock', 0)->orderBy('created_at', 'desc')->get();
        } else {
            $data['products'] = Product::where('branch_id', Auth::user()->branch_id)->where('stock', 0)->orderBy('created_at', 'desc')->get();
        }

        return view('backend.product.index', $data);
    }

    public function create()
    {
        $data['branches'] = Branch::orderBy('created_at', 'asc')->get();

        return view('backend.product.create', $data);
    }

    public function store(Request $request)
    {
        $branchValidate = Auth::user()->hasRole('owner') ? 'required' : '';

        $data = $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg|image|max:5024',
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'branch_id' => $branchValidate,
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = basename($request->file('image')->store('products', 'public'));
        }

        $data['price'] = str_replace(['Rp ', '.', ','], ['', '', ''], $request->price);

        Product::create($data);

        return redirect('products')->with('message', 'Berhasil ditambahkan!');
    }

    public function print(Product $product)
    {
        $data['product'] = $product;

        return view('backend.product.print-qr', $data);
    }

    public function edit(Product $product)
    {
        $data = [
            'product' => $product,
            'branches' => Branch::orderBy('created_at', 'asc')->get()
        ];

        return view('backend.product.edit', $data);
    }

    public function update(Request $request, Product $product)
    {
        $branchValidate = Auth::user()->hasRole('owner') ? 'required' : '';

        $data = $request->validate([
            'image' => 'mimes:jpg,png,jpeg|image|max:5024',
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'branch_id' => $branchValidate,
        ]);

        $data['image'] = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            $data['image'] = basename($request->file('image')->store('products', 'public'));
        }

        $data['price'] = str_replace(['Rp ', '.', ','], ['', '', ''], $request->price);

        $product->update($data);

        return redirect('products')->with('message', 'Berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);

            $product->delete();

            return response()->json(['message' => 'Berhasil dihapus!']);
        }
    }
}
