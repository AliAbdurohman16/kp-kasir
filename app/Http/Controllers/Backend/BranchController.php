<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $data['branches'] = Branch::orderBy('created_at', 'asc')->get();

        return view('backend.branch.index', $data);
    }

    public function create()
    {
        return view('backend.branch.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'telephone' => 'required|max:15',
            'address' => 'required',
        ]);

        Branch::create($data);

        return redirect('branches')->with('message', 'Berhasil ditambahkan!');
    }

    public function edit(Branch $branch)
    {
        $data['branch'] = $branch;

        return view('backend.branch.edit', $data);
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'name' => 'required',
            'telephone' => 'required|max:15',
            'address' => 'required',
        ]);

        $branch->update($data);

        return redirect('branches')->with('message', 'Berhasil diperbarui!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return response()->json(['message' => 'Berhasil dihapus!']);
    }
}
