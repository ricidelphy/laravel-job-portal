<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;


class CategoryController extends Controller
{
    //

    public function store(CreateCategoryRequest $request)
    {
        try {

            $category = Category::create([
                'category_name'     => $request->category_name,
            ]);

            return response()->json(['success' => true, 'message' => 'Category Created Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }


    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json(['success' => true, 'data' => $category, 'message' => 'Retrieve Category Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
