<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index', ['products' => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $products = $request->validate([                //validate data
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $product = Product::create($products);          //create and store data in the db

        $product_image = $request->image;
        $product_image_new_name = time(). $product_image->getClientOriginalName();
        $product_image->move('uploads/products',$product_image_new_name);       //image to store in the particular directory

        $product->image = 'uploads/products/'. $product_image_new_name;

        $product->save();

        Session::flash('success', 'New Product Saved');

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('products.edit',['product' => Product::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'required',
            'price'=>'required',
            'description'=>'required',
        ]);

        $product = Product::find($id);

        if ($request->hasFile('image'))
        {
            $product_image = $request->image;
            $product_image_new_name = time(). $product_image->getClientOriginalName();
            $product_image->move('uploads/products',$product_image_new_name);

            $product->image = 'uploads/products/'. $product_image_new_name;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        $product->save();

        Session::flash('success', 'Product Updated');

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (file_exists($product->image))
        {
            unlink($product->image);
        }

        $product->delete();

        Session::flash('success', 'Product deleted');

        return redirect()->back();
    }
}
