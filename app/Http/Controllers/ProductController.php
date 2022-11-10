<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    // product list
    public function productList(){
        $pizzas =Product::select('products.*','categories.name as category_name')
                    ->when(request('search'),function($query){
                    $query->where('products.name','like','%'.request('search').'%');
                })
                ->leftJoin('categories','products.category_id', 'categories.id')
                ->orderBy('products.created_at','desc')
                ->paginate(5);

        $pizzas->appends(request()->all());
        return view('admin.product.pizzalist',compact('pizzas'));
    }

    // direct create pizzz page
    public function createPizza(){
        $categories = Category::select('id','name')->get();
        return view('admin.product.createpizza',compact('categories'));
    }

    //pizzz create
    public function create(Request $request){
        $this->productValidationCheck($request,'create');
        $data = $this->requestProductData($request);

        //image
            $fileName = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;


        Product::create($data);
        return redirect()->route('product#productList');
    }

    //delete pizza
    public function deletePizza($id){
        Product::where('id',$id)->delete();
        return redirect()->route('product#productList')->with(['prodeleteSuccess'=>'Product deletation is success']);
    }

    //edit pizza
    public function editPizza($id){
        $pizza = Product::select('products.*','categories.name as category_name')
                ->leftJoin('categories','products.category_id', 'categories.id')
                ->where('products.id',$id)->first();
        return view('admin.product.editpizza',compact('pizza'));
    }

    //update pizza page
    public function updatePagePizza($id){
        $pizzaup = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.product.updatepizza',compact('pizzaup','category'));
    }

    //update pizza=================
    public function updatePizza( Request $request){
        $this->productValidationCheck($request,'updatePizza');
        $updata = $this->requestProductData($request);

        // image
        if($request->hasFile('pizzaImage')){
            $oldImageName = Product::where('id',$request->pizzaid)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            //upload new image;
            $fileName2 = uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName2);
            $updata['image'] = $fileName2;

        }

        Product::where('id',$request->pizzaid)->update($updata);
        return redirect()->route('product#productList');
    }


    //request product data
    private function requestProductData($request){
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->pizzaWaitingTime,
        ];
    }

    //product validation check
    private function productValidationCheck($request,$action){
        $validationRole = [
            'pizzaName' => 'required|min:5|unique:products,name,'.$request->pizzaid,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:10',
            'pizzaPrice' => 'required',
            'pizzaWaitingTime' => 'required',
        ];

        $validationRole['pizzaImage'] = $action == "create" ? 'required|mimes:jpg,jpeg,png,file,gif,webp,svg' : 'mimes:jpg,jpeg,png,file,gif,webp,svg';

        Validator::make($request->all(),$validationRole)->validate();
    }
}
