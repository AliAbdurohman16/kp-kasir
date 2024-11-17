<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $chartMonthly = Transaction::selectRaw('MONTH(created_at) as month, SUM(total) as total')
                        ->whereYear('created_at', Carbon::now()->year)
                        ->groupBy('month')
                        ->orderBy('month')
                        ->pluck('total', 'month')
                        ->toArray();

        $chartMonthly = array_replace(array_fill(1, 12, 0), $chartMonthly);

        $data = [
            'activities' => Activity::latest()->limit(10)->get(),
            'daily_income' => Transaction::whereDate('created_at', Carbon::today())->sum('total'),
            'monthly_income' => Transaction::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->sum('total'),
            'yearly_income' => Transaction::whereYear('created_at', Carbon::now()->year)->sum('total'),
            'chartMonthly' => array_values($chartMonthly),
        ];

        return view('backend.dashboard.index', $data);
    }
}
