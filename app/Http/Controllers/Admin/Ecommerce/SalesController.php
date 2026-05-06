<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SalesController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.ecommerce.sales');
    }
}
