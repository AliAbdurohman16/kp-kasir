<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ExportReport;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['branches'] = Branch::orderBy('created_at', 'asc')->get();
        
        return view('backend.report.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'branch' => Auth::user()->hasRole('owner') ? 'required' : '',
        ]);

        if (Auth::user()->hasRole('owner')) {
            $branch = $request->branch;
        } else {
            $branch = Auth::user()->branch_id;
        }
        
        return Excel::download(new ExportReport($request->start_date, $request->end_date, $branch), 'laporan-penjualan.xlsx');
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
        //
    }
}
