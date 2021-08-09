<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\DeleteCategory;
use App\Http\Requests\EditCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    /**
     * CategoryController constructor.
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function get(Request $request)
    {
        $categories = $this->category->with('subCategory')->get();
        return response()->json(['status' => 'OK', 'data' => $categories], 200);
    }


    public function create(CategoryRequest $request)
    {
        $data = $request->validated();

        $category = $this->category->create($data);
        if ($category == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $category], 220);

    }

    public function edit(EditCategoryRequest $request, $categoryId)
    {
        $data = $request->validated();
        unset($data['category_id']);

        $updated = $this->category->where('id', $categoryId)->update($data);

        if ($updated == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $updated], 230);
    }

    public function delete(DeleteCategory $request, $categoryId)
    {
        $data = $request->validated();

        $category = $this->category->where('id', $categoryId)->with('subCategories')->get();
//        if ($category->subCategory->count() != 0) {
//            return
//                response()->json(['status' => 'Error', 'Data' => 'Not Authorized'], 440);
//        }
        $category->delete();

        return response()->json(['status' => 'OK', 'data' => 'Deleted Successfully'], 240);

    }
}
