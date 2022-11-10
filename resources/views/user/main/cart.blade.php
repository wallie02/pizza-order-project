@extends('user.layouts.master3')

@section('content')

    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartlist as $cl)
                        <tr id='trRow'>
                            {{-- for price add to total if we click ( + and - ) --}}
                            {{-- <input type="hidden" value="{{ $cl->pizza_price}}"  id="pizzaPrice"> --}}

                            <td><img src="{{asset('storage/'.$cl->produce_img)}}" alt="" style="width: 100px;" class="img-thumbnail"> </td>
                            <td class="align-middle">{{ $cl->pizza_name }}
                                <input type="hidden" class="orderid" value="{{ $cl->id}}">
                                <input type="hidden" class="userid" value="{{ $cl->user_id}}">
                                <input type="hidden" class="productid" value="{{ $cl->product_id}}">
                            </td>
                            <td class="align-middle" id="pprice">{{ $cl->pizza_price}} kyats</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus text-white"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm border-0 text-center" value="{{ $cl->qty }}" id="qtyy">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle" id="total">{{ $cl->pizza_price * $cl->qty }} kyats</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove" ><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subtotalprice">{{ $totalprice}} kyats </h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Fees</h6>
                            <h6 class="font-weight-medium">2500 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalprice + 2500 }} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3 orderBtn">
                                <span class="text-white font-weight-bold ">Proceed To Checkout</span>
                        </button>

                        <button class="btn btn-block btn-danger my-3 py-3 clearBtn" >
                            <span class="text-white font-weight-bold ">Clear Cart</span>
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('jscript')
<script>
     $(document).ready(function(){

        $('.btn-plus').click(function(){
            $parentNode = $(this).parents('tr')
            $price =   Number( $parentNode.find('#pprice').text().replace('kyats',''));
            $qty =  Number($parentNode.find('#qtyy').val());
            $total = $price*$qty ;
            $parentNode.find('#total').html(`${$total} kyats`);
            summaryTotal();
        })

        $('.btn-minus').click(function(){
            $parentNode = $(this).parents('tr')
            $price = $parentNode.find('#pprice').text().replace('kyats','');
            $qty =  Number($parentNode.find('#qtyy').val());
            $total = $price*$qty ;
            $parentNode.find('#total').html(`${$total} kyats`)
            summaryTotal();
        })

        // Toatl summary caculation for order
        function summaryTotal(){
            $allTotalprice = 0;
            $('#dataTable #trRow').each(function(index,row){
                $allTotalprice += Number($(row).find('#total').text().replace('kyats',''));
            })

            $('#subtotalprice').html(`${$allTotalprice} kyats`)
            $('#finalPrice').html(`${$allTotalprice+2500} kyats`)
        }

    })
</script>

{{-- //order --}}
<script>

        $('.orderBtn').click(function(){

            $orderlist =[];
            $radomNumber =Math.floor(Math.random() * 1000000001);

            $('#dataTable #trRow').each(function(index,row){
                $orderlist.push({
                    'user_id': $(row).find('.userid').val(),
                    'product_id' : $(row).find('.productid').val(),
                    'qty' : $(row).find('#qtyy').val(),
                    'total' : $(row).find('#total').text().replace('kyats','')*1,
                    'order_code' : 'POS'+$radomNumber
                });
            })

            $.ajax({
                    type: 'get' ,
                    url: '/user/ajax/order',
                    data: Object.assign({}, $orderlist),
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 'true'){
                            window.location.href = "/user/homePage";
                        }
                    }
                })

        })

        //when clear btn click,
        $('.clearBtn').click(function(){

         $.ajax({
                    type: 'get' ,
                    url: '/user/ajax/clear/cart',
                    dataType: 'json',
                })

         $('#dataTable #trRow').remove();
         $('#subtotalprice').html('0 kyats');
         $('#finalPrice').html('2500 kyats');

        })

        //removal each row when cross btn click
        $('.btnRemove').click(function(){
            $parentNode =$(this).parents('tr');
            $productId = $parentNode.find('.productid').val();
            $orderId = $parentNode.find('.orderid').val();



            $.ajax({
                    type: 'get' ,
                    url: '/user/ajax/clear/eachRow',
                    data: {
                        'productid' : $productId,
                        'orderid' : $orderId
                    },
                    dataType: 'json',
            })

            $parentNode.remove();
            $allTotalprice = 0;
            $('#dataTable #trRow').each(function(index,row){
                $allTotalprice += Number($(row).find('#total').text().replace('kyats',''));
            })

            $('#subtotalprice').html(`${$allTotalprice} kyats`)
            $('#finalPrice').html(`${$allTotalprice+2500} kyats`)
        })
</script>
@endsection
