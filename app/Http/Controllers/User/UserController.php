<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userhomepage(){
        $pizzauser = Product::orderBy('created_at','desc')->get();
        $categoryuser = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();     //total orders from user
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzauser','categoryuser','cart','history'));
    }

    //change Password page
    public  function changePasswordPage(){
        return view('user.password.userPasschange');
    }

    //change Password
    public function changeUserPassword(Request $request){

        $this->passwordValidationCheck($request);

        $userdata = User::select('password')->where('id',Auth::user()->id)->first();
        $hashPassword = $userdata->password;  //hashvalue

        if(Hash::check($request->oldpassword, $hashPassword)){
            $data = [
                'password' => Hash::make($request->newpassword)
            ];
                User::where('id', Auth::user()->id)->update($data);

                return back()->with(['changeSuccess' => 'Password changed..']);
            }

             return back()->with(['notMatching' => 'The old Password did not match. Try agin']);
    }

    //user account update
    public function userAccountPage(){
        return view('user.profile.account');
    }

    //user account update
    public function userAccountChange($id, Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        // for image uploading
        if($request->hasFile('image')){
            //old image name -> check-> if it has in db, delete or not
            //storage new images
            $oldImage = User::where('id',$id)->first();
            $oldImage = $oldImage->image;

            //delete old image in db
            if($oldImage != null){
                Storage::delete('public/'.$oldImage);
            }

            // upload new image
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;

        }

        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess' => 'User Account Updated']);
    }

    //filter
    public function userFilter($categoryID){
        $pizzauser = Product::where('category_id',$categoryID)->orderBy('created_at','desc')->get();
        $categoryuser = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();     //total orders from user
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizzauser','categoryuser','cart','history'));
    }

    //Pizza Detials
    public function pizzaDetials($id){
        $pizzadetails = Product::where('id',$id)->first();
        $pizzalist = Product::get();
        return view('user.main.userPizzadetail',compact('pizzadetails','pizzalist'));
    }

    //cart list
    public function cartList(){
        $cartlist = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as produce_img')
                    ->leftJoin('products','products.id','carts.product_id')
                    ->where('carts.user_id',Auth::user()->id)
                    ->get();

        $totalprice = 0;
        foreach($cartlist as $c){
            $totalprice += $c->pizza_price * $c->qty;
        }

        return view('user.main.cart',compact('cartlist','totalprice'));
    }


    // order history
    public function userHistory(){
        $orderHistory = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(5);
        return view('user.main.history',compact('orderHistory'));
    }

    //password validation
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldpassword' => 'required|min:6',
            'newpassword' => 'required|min:6',
            'confirmedpassword' => 'required|min:6|same:newpassword',
        ])->validate();
    }

    // request update data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'updated_at'=> Carbon::now(),
        ];
   }

    //account validation
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' =>'mimes:png,jpg,jpeg,svg,webp,gif',

        ])->validate();
    }
}
