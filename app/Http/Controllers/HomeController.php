<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        return view('home', compact('products'));
    }
}
