<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products = Product::Paginate(6);

        return view('product_list', compact('products'));
    }

    public function show()
    {
        return view('product_register');
    }
}
