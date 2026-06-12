<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application landing page via Inertia.
     * Data produk dikirim sebagai props ke Home.jsx.
     */
    public function index()
    {
        $products = Product::where('is_active', true)->get()->map(fn ($p) => [
            'id'             => $p->id,
            'name'           => $p->name,
            'slug'           => $p->slug,
            'category'       => $p->category,
            'original_price' => $p->original_price,
            'aksespro_price' => $p->aksespro_price,
            'duration_days'  => $p->duration_days,
            'description'    => $p->description,
            'logo_path'      => $p->logo_path,
            'is_active'      => $p->is_active,
        ])->values()->toArray();

        return Inertia::render('Home', [
            'products' => $products,
        ]);
    }
}
