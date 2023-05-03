<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $this->view('products/index', ['products' => $products]);
    }

    public function create()
    {
        $this->view('products/create');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->fill($request->getAll());
        $product->insert();

        redirect('/admin/products');
    }

    public function show(Request $request)
    {
        $product = Product::find($request->id);

        $this->view('products/show', ['product' => $product]);
    }

    public function edit(Request $request)
    {
        $product = Product::find($request->id);

        $this->view('products/edit', ['product' => $product]);
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $product->fill($request->getAll());
        $product->update();

        redirect('/admin/products');
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $product->delete();

        redirect('/admin/products');
    }
}