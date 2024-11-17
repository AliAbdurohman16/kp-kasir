<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $data['products'] = Product::orderBy('created_at', 'desc')->get();

        return view('backend.product.index', $data);
    }

    public function create()
    {
        return view('backend.product.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|mimes:jpg,png,jpeg|image|max:5024',
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = basename($request->file('image')->store('products', 'public'));
        }

        $data['price'] = str_replace(['Rp ', '.', ','], ['', '', ''], $request->price);

        Product::create($data);

        return redirect('products')->with('message', 'Berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $data['product'] = $product;

        return view('backend.product.edit', $data);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'image' => 'mimes:jpg,png,jpeg|image|max:5024',
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
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
