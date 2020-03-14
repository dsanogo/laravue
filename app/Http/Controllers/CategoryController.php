<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('manage', Category::class);
        $categories = Category::orderBy('display_order')->get();
        return view('admin.categories.index')->withCategories($categories);
    }

    public function upsert(Request $request)
    {
        $this->authorize('manage', Category::class);

        $categories = $request->categories;
        if ($categories) {
            foreach ($categories as $category) {
                if ($category['id']) {
                    Category::where('id', $category['id'])->update($category);
                } else {
                    Category::create($category);
                }
            }
        }

        return response()->json(['success' => true, 'categories' => Category::all()]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        if ($category) {
            $category->delete();
            return response()->json(['success' => true, 'categories' => Category::all()]);
        } else {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }
    }
}