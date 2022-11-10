<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //direct order list page
    public function orderListPage(){
        $order = Order::select('orders.*','users.name as user_name')
                ->when(request('search'),function($query){
                    $query->where('users.name','like','%'.request('search').'%');
                })
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('orders.created_at','desc')
                ->get();

       return view('admin.order.orderlist',compact('order'));
    }

    //sorting with ajax
    public function orderchangeStatus(Request $request){


        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('orders.created_at','desc');

                // query branches
                if ($request->orderStatus == null) {
                    $order = $order->get();
                }else{
                    $order = $order->where('orders.status',$request->orderStatus)->get();
                }


       return view('admin.order.orderlist',compact('order'));

    }

    //change status in form
    public function ajaxChangeStatus(Request $request){
        Order::where('id',$request->orderId)->update([
            'status'=>$request->status
        ]);

        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('orders.created_at','desc')
                ->get();

            return response()->json($order, 200);

    }

    //order list orderCode info
    public function listInfo($orderCode){
        $ordert = Order::where('order_code',$orderCode)->first();
        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.image as product_img','products.name as product_name')
                    ->leftJoin('users','users.id','order_lists.user_id')
                    ->leftJoin('products','products.id','order_lists.product_id')
                    ->where('order_code',$orderCode)
                    ->get();

         return view('admin.order.productlist',compact('orderList','ordert'));
    }

}
