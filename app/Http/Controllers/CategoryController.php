<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category list page
    public function lists(){
        $categoryList = Category::when(request('search'), function($query){
                            $query->where('name','like','%'.request('search').'%');
                         })
                        ->orderBy('id','desc')
                        ->paginate(4);
        $categoryList->appends(request()->all());
        return view('admin.category.list',compact('categoryList'));
    }

    //Category create Page
    public function createPage(){
        return view('admin.category.create');
    }

    //Create Category
    public function create(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }

    //Category delete
    public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['deleteSucccess'=>'Category Deleted']);
    }


    //Category edit
    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }


    //Category edit->update
    public function update(Request $request){
        //  $id = $request->categoryId;
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id',$request->categoryId)->update($data);
        return redirect()->route('category#list');
    }

    //Category Validation
    private function categoryValidationCheck($request){
        Validator::make($request->all(),[
            'categoryName' => 'required|unique:categories,name,'.$request->categoryId
        ])->validate();
    }

    //request category data
    private function requestCategoryData($request){
        return  [
            'name' => $request->categoryName
        ];
    }
}
