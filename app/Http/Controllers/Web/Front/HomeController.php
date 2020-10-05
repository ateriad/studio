<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function index()
    {
       return redirect()->route('admin.dashboard');
    }
}
