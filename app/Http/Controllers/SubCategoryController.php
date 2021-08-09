<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubCategory;
use App\Http\Requests\DeleteSubCategory;
use App\Http\Requests\GetSubCategoriesRequest;
use App\Http\Requests\UpdateSubCategory;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    private $subCategory, $category;

    /**
     * SubCategoryController constructor.
     * @param SubCategory $subCategory
     * @param Category $category
     */
    public function __construct(SubCategory $subCategory, Category $category)
    {
        $this->subCategory = $subCategory;
        $this->category = $category;
    }

    public function get(GetSubCategoriesRequest $request, $categoryId)
    {
        $data = $request->validated();
        $subCategories = $this->category->where('id',$categoryId)->with('subCategory')->get();
        return response()->json(['status' => 'OK', 'data' => $subCategories], 200);
    }

    public function create(CreateSubCategory $request)
    {
        $data = $request->validated();

        $subCategory = $this->subCategory->create($data);

        if ($subCategory == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $subCategory], 220);

    }

    public function edit(UpdateSubCategory $request, $subCategoryId)
    {
        $data = $request->validated();
        unset($data['subCategory_id']);
        $subCategory = $this->subCategory->where('id', $subCategoryId)->update($data);

        if ($subCategory == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $subCategory], 230);
    }

    public function delete(DeleteSubCategory $request, $subCategoryId)
    {

        $subCategory = $this->subCategory->where('id',$subCategoryId)->with('brands')->get();
//        if ($subCategory->brands->count() != 0)
//            return
//                response()->json(['status' => 'Error', 'Data' => 'Not Authorized'], 440);

        $subCategory->delete();

        return response()->json(['status' => 'OK', 'data' => 'Deleted Successfully'], 240);
    }

}
