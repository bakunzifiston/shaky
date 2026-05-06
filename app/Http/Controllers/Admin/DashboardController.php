<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, AdminDashboardService $dashboard): View
    {
        $data = $dashboard->build(
            (string) $request->query('period', 'all_time'),
            $request->query('start_date'),
            $request->query('end_date'),
        );

        return view('admin.dashboard', $data);
    }
}
