<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProdctController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('id', 'DESC')->paginate(3);
        if(!empty($data)){
            return response()->json([
                'message' => 'Data loaded successfully.',
                'data' => $data,
                'status_code' => 201
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }
    }

    public function allCategory()
    {
        $data = Category::orderBy('id', 'DESC')->get();
        if(!empty($data)){
            return response()->json([
                'message' => 'Data loaded successfully.',
                'data' => $data,
                'status_code' => 201
            ], 201);
        }
        else{
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoryId' => 'required',
            'name' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $product = new Product();
        $product->categoryId = $request->categoryId;
        $product->name = $request->name;
        $product->status = $request->status;

        $path = $request->file('image')->store('productImages');
        $product->image = $path;

        if ($product->save()) {
            return response()->json([
                'message' => 'Data inserted successfully.',
                'data' => $product,
                'status_code' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'categoryId' => 'required',
            'name' => 'required'
        ]);

        $product->categoryId = $request->categoryId;
        $product->name = $request->name;
        $product->status = $request->status;
        $oldImagePath = $product->image;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);
        
            $path = $request->file('image')->store('productImages');
            $product->image = $path;
            Storage::delete($oldImagePath);

        }

        if ($product->save()) {
            return response()->json([
                'message' => 'Product updated successfully!',
                'status_code' => 201
            ], 201);
        } else {
            Storage::delete($path);
            return response()->json([
                'message' => 'Some error occurred, Please try agian!',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            Storage::delete($product->image);

            return response()->json([
                'message' => 'Product deleted successfully!',
                'status_code' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try again',
                'status_code' => 500
            ], 500);
        }
    }
}
