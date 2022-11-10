<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // return pizza ajax list
    public function pizzaAjaxlist(Request $request){
        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();
        }else {
            $data = Product::orderBy('created_at','asc')->get();
        }

        return response()->json($data,200);
    }

    //return pizza cart
    public function addtoCart(Request $request){
        $data = $this->getOrderData($request);
        Cart::create($data);
        $repsonse = [
            'message' => 'Add to cart complete',
            'status' => 'success'
        ];
        return response()->json($repsonse, 200);
    }

    //order
    public function orderAjax(Request $request){
        $totalp = 0;

        foreach ($request->all() as $items ) {
        $data =  OrderList::create([
                'user_id' => $items['user_id'],
                'product_id' => $items['product_id'],
                'qty' => $items['qty'],
                'total' => $items['total'],
                'order_code' => $items['order_code'],
            ]);

            $totalp += $data->total;
        }

        Cart::where('user_id',Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'totalprice' => $totalp + 2500,
        ]);

        $repsonse = [
            'status' => 'true',
            'message' => 'Order Completed',
        ];
        return response()->json($repsonse, 200);
    }

    //clear cart all
    public function cartClear(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    // clear product each row
    public function clearProductRow(Request $request){
        Cart::where('user_id',Auth::user()->id)
            ->where('product_id',$request->productid)
            ->where('id',$request->orderid)
            ->delete();

    }

    // increase view count
    public function increaseViewCount(Request $request){
        $pizzaview = Product::where('id',$request->productId)->first();

        Product::where('id',$request->productId)->update([
            'view_count'=> $pizzaview->view_count + 1
        ]);
    }


    //get order cart data
    private function getOrderData($request){
        return [
            'user_id' => $request->userID,
            'product_id' => $request->pizzaID,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
