@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div>

                 {{-- delete alert --}}

                   @if(session('prodeleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark mx-2"></i> <strong>{{session('prodeleteSuccess')}}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- Serach category --}}
                    <div class="row">
                        <div class="col-3">
                             <h4 class="text-secondary">Search Key | <span class="text-danger"> {{request ('search') }} </span></h4>
                        </div>

                        <div class=" col-3 offset-6">
                            <form action="{{route('order#orderListPage')}}" method="GET">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{request('search')}}">
                                    <button class="btn bg-success text-white" type="sumbit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                        {{-- Total --}}
                        <div class="row my-2">
                            <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center">
                                <h3> <i class="fa-solid fa-folder-plus me-2"></i>{{ count($order) }} </h3>
                            </div>
                        </div>

                        {{-- order status --}}
                        <form action="{{ route('order#orderchangeStatus')}}" method="get" class="col-5">
                            @csrf
                            <div class="d-flex">
                                <div class="input-group mb-3">
                                    <button class="btn btn-sm me-1 btn-secondary input-group-text"><i class="fa-solid fa-folder-plus me-2"></i>{{ count($order) }}</button>
                                        <select name="orderStatus" class="form-select" id="inputGroupSelect02">
                                            <option value="">All</option>
                                            <option value="0" @if(request('orderStatus') == '0' ) selected @endif >Pending</option>
                                            <option value="1" @if(request('orderStatus') == '1' ) selected @endif >Accept</option>
                                            <option value="2" @if(request('orderStatus') == '2' ) selected  @endif >Reject</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-dark input-group-text me-1"><i class="fa-solid fa-magnifying-glass "></i> Search</button>
                                </div>
                            </div>
                        </form>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id='datalist'>
                                @foreach ($order as $oo )
                                <tr class="tr-shadow">
                                    <input type="hidden" class="orderID" value="{{ $oo->id }}">
                                    <td >{{ $oo->user_id }}</td>
                                    <td >{{ $oo->user_name }}</td>
                                    <td >{{ $oo->created_at->format('j-F-Y') }}</td>
                                    <td>
                                        <a href="{{route('order#listInfo',$oo->order_code)}}" class="text-decoration-none">{{ $oo->order_code }}</a>
                                    </td>
                                    <td >{{ $oo->totalprice }} kyats</td>
                                    <td >
                                        <select name="status" class="form-control text-center changeStatus">
                                            <option value="0"  @if ($oo->status == 0) selected @endif>Pending</option>
                                            <option value="1"  @if ($oo->status == 1) selected @endif>Accept</option>
                                            <option value="2" @if ($oo->status == 2) selected @endif>Reject</option>
                                        </select>
                                    </td>
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

@section('jscriptsection')
<script>
    $(document).ready(function(){
        // $('#orderStatus').change(function(){
        //     $status = $('#orderStatus').val();

        //     $.ajax({
        //             type: 'get' ,
        //             url: 'http://127.0.0.1:8000/order/ajax/status',
        //             data: { 'status' : $status},
        //             dataType: 'json',
        //             success: function(response){

        //                 //append
        //                 $list = '';
        //                 for($i=0; $i<response.length; $i++){

        //                     //for month name
        //                     $month =['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',  'December'];
        //                     $dbdate = new Date(response[$i].created_at);
        //                     $actualDate = $month[$dbdate.getMonth()]+"-"+$dbdate.getDate()+"-"+$dbdate.getFullYear();

        //                     if(response[$i].status == 0){
        //                         $statusMessage = `
        //                                 <select name="status" class="form-control text-center changeStatus">
        //                                     <option value="0" selected>Pending</option>
        //                                     <option value="1" >Accept</option>
        //                                     <option value="2" >Reject</option>
        //                                 </select>`

        //                     }else if(response[$i].status == 1){
        //                         $statusMessage = `
        //                                 <select name="status" class="form-control text-center changeStatus">
        //                                     <option value="0" >Pending</option>
        //                                     <option value="1" selected>Accept</option>
        //                                     <option value="2" >Reject</option>
        //                                 </select>`

        //                     }else if(response[$i].status == 2){
        //                         $statusMessage = `
        //                                 <select name="status" class="form-control text-center changeStatus">
        //                                     <option value="0" >Pending</option>
        //                                     <option value="1" >Accept</option>
        //                                     <option value="2" selected>Reject</option>
        //                                 </select>`
        //                     }

        //                     // $list += `
        //                     //     <tr class="tr-shadow">
        //                     //         <input type="hidden" class="orderID" value="${response[$i].id}">
        //                     //         <td > ${response[$i].user_id} </td>
        //                     //         <td >${response[$i].user_name} </td>
        //                     //         <td >${response[$i].$actualDate} </td>
        //                     //         <td > ${response[$i].order_code} </td>
        //                     //         <td >${response[$i].totalprice}  kyats</td>
        //                     //         <td >${$statusMessage}</td>
        //                     //     </tr>`;

        //                     $list +=`
        //                     <tr class="tr-shadow">
        //                             <input type="hidden" class="orderID" value="${response[$i].id}">
        //                             <td>${response[$i].user_id} </td>
        //                             <td>${response[$i].user_name}</td>
        //                             <td>${response[$i].$actualDate}</td>
        //                             <td> ${response[$i].order_code}</td>
        //                             <td>${response[$i].totalprice} kyats</td>
        //                             <td>${$statusMessage}</td>
        //                         </tr>`;

        //                     }

        //                     $('#datalist').html($list);
        //             }
        //     })
        // })

        //change status
        $('.changeStatus').change(function(){

            $currentStatus =$(this).val();
            $parentNode =$(this).parents('tr');
            $orderid = $parentNode.find('.orderID').val()

            $data = {
                        'orderId' : $orderid,
                        'status' : $currentStatus
                    };


            $.ajax({
                    type: 'get' ,
                    url: '/order/ajax/change/status',
                    data: $data ,
                    dataType: 'json',
            })

        })

    })
</script>
@endsection
