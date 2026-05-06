<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FulfillmentController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.ecommerce.fulfillment');
    }
}
