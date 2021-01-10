<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Product::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $exploded=explode(',',$request->photo);
        $decoded=base64_decode($exploded[1]);
        if (str_contains($exploded[0],'jpeg')){
            $extension='jpg';
        }else{
            $extension='png';
        }

        $fileName=rand(0,500).'.'.$extension;
        $path=public_path().'/'.$fileName;
        file_put_contents($path, $decoded);

        $product= new Product;
        $product->create($request->except('photo')+['photo'=>$fileName]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $product->update($request->except('photo'));
//        $exploded=explode(',',$request->photo);
//        $decoded=base64_decode($exploded[1]);
//        if (str_contains($exploded[0],'jpeg')){
//            $extension='jpg';
//        }else{
//            $extension='png';
//        }
//
//        $fileName=rand(0,500).'.'.$extension;
//        $path=public_path().'/'.$fileName;
//        file_put_contents($path, $decoded);
//
//        $product= new Product;
//        $product->update($request->except('photo')+['photo'=>$fileName]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
    }
}
