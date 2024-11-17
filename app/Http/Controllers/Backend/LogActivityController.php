<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function index()
    {
        $data['activities'] = Activity::orderBy('created_at', 'desc')->get();

        return view('backend.log-activity.index', $data);
    }
}
