<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get all products/users list
    public function productapi(){
        $products = Product::get();
        $user = User::get();

        $data = [
            'products' => $products,
            'users' => $user
        ];
        return response()->json($data, 200);
    }

    //get all category list
    public function categoryapi(){
        $category = Category::orderBy('id','desc')->get();
         return response()->json($category, 200);
    }

    //category create
    public function createCategory(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $response = Category::create($data);
        return response()->json($response, 200);
    }

    //contacts create
    public function createContact(Request $request){
        $data = [
            'name' => $request->name,
            'email'=> $request->email,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $response = Contact::create($data)->get();
        return response()->json($response, 200);
    }

    //category delete
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' => 'true', 'messsage' => 'success'], 200);
        }

        return response()->json(['status' => 'false', 'messsage' => 'there is no category..'], 500);
    }


    //category edit & update
    public function deatilsCategory($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            return response()->json(['status' => 'true', 'categories' => $data ], 200);
        }

        return response()->json(['status' => 'false', 'categories' => 'there is no category..'], 500);
    }

    //update
    public function updateCategory(Request $request){

        $categoryID = $request->category_id;
        $dbsource = Category::where('id',$categoryID)->first();

        if(isset($dbsource)){

            $data = [
                'name' => $request->category_name,
                'updated_at' => Carbon::now()
            ];

            Category::where('id',$categoryID)->update($data);
            $response = Category::where('id',$categoryID)->first();
            return response()->json(['status' => 'true', 'message' => 'category update success', 'categories' => $response ], 200);
        }

            return response()->json(['status' => 'false', 'message' => 'category update failed..,' ], 500);


    }

}
