<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('id', 'DESC')->paginate(3);
        // $data = Category::orderBy('id', 'DESC')->select('id', 'name', 'image')->paginate(1);
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
            'name' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);
        $category = new Category();
        $category->name = $request->name;

        $path = $request->file('image')->store('categoryImages');
        $category->image = $path;

        if ($category->save()) {
            return response()->json([
                'message' => 'Data inserted successfully.',
                'data' => $category,
                'status_code' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Some error occurred, please try agian',
                'status_code' => 500
            ], 500);
        }

        dd($request->all());
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
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        

        $category->name = $request->name;
        $oldImagePath = $category->image;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg',
            ]);

            $path = $request->file('image')->store('categoryImages');
            $category->image = $path;

            Storage::delete($oldImagePath);
        }

        if ($category->save()) {
            return response()->json([
                'message' => 'Category updated successfully!',
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
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            Storage::delete($category->image);

            return response()->json([
                'message' => 'Category deleted successfully!',
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
