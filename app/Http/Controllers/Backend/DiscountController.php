<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        $data['discounts'] = Discount::orderBy('created_at', 'asc')->get();

        return view('backend.discount.index', $data);
    }

    public function create()
    {
        return view('backend.discount.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'percentage' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        Discount::create($data);

        return redirect('discounts')->with('message', 'Berhasil ditambahkan!');
    }

    public function edit(Discount $discount)
    {
        $data['discount'] = $discount;

        return view('backend.discount.edit', $data);
    }

    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'name' => 'required',
            'percentage' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
        ]);

        $discount->update($data);

        return redirect('discounts')->with('message', 'Berhasil diperbarui!');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response()->json(['message' => 'Berhasil dihapus!']);
    }
}
