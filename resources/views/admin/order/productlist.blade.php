@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="ms-3">
                        <a href="{{route('order#orderListPage')}}" class="text-decoration-none text-dark">
                            <i class="fa-solid fa-arrow-left text-dark me-1" onclick="history.back()"></i> Back
                        </a>
                     </div>

                     <div class="row col-5">
                        <div class="card mt-4">
                            <div class="card-header mt-2">
                                <h3><i class="fa-solid fa-clipboard-list me-2"></i>Order Info <sub class="ms-2 text-muted" style="font-size: 13px">(including delivery fees)</sub></h3>
                            </div>

                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-regular fa-circle-user me-2"></i>Customer</div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name)}}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order Code</div>
                                    <div class="col">{{ $orderList[0]->order_code}}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-regular fa-calendar-days me-2"></i>Order Date</div>
                                    <div class="col">{{ $orderList[0]->created_at->format('j-F-Y')}}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-money-check-dollar me-2"></i>Total Price</div>
                                    <div class="col">{{ $ordert->totalprice }} kyats</div>
                                </div>
                            </div>
                         </div>
                     </div>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Quatity</th>
                                    <th>Amount</th>

                                </tr>
                            </thead>
                            <tbody id='datalist'>
                                @foreach ($orderList as $ol )
                                <tr class="tr-shadow">
                                    <td></td>
                                    <td >{{ $ol->id }}</td>
                                    <td class="col-2"><img src="{{ asset('storage/'.$ol->product_img)}}" class="img-thumbnail" ></td>
                                    <td>{{ $ol->product_name}}</td>
                                    <td >{{ $ol ->created_at->format('j-F-Y') }}</td>
                                    <td >{{ $ol->qty }}</td>
                                    <td >{{ $ol->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

</div>
@endsection
