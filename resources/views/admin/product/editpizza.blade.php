@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">

        {{-- update success --}}
        <div class="row">
            <div class="col-3 offset-7 mb-2 ">
                @if(session('updateSuccess'))
                <div class="">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-xmark mx-2"></i> <strong>{{session('updateSuccess')}}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            </div>
        </div>

        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">

                            {{--  return back to my searched list --}}
                            <div class="ms-3">
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                            </div>

                            <div class="card-title">
                                <h3 class="text-center title-2" > Pizza Details </h3>
                            </div>

                            <hr>
                           {{-- profile --}}
                           <div class="row">
                                <div class="col-3 offset-2 mt-4">
                                        <img src="{{asset('storage/'.$pizza->image)}}" class="img-thumbnail shadow-sm" />
                                </div>

                                <div class="col-7">
                                    <h3 class="my-3 text-dark"><i class="fa-solid fa-dice-d6 me-2 "></i> {{$pizza->name}}</h3>

                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fa-money-check-dollar me-2 text-white"></i></i> {{$pizza->price}}</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fa-clock-rotate-left me-2 text-white"></i></i> {{$pizza->waiting_time}}min</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-regular fa-eye me-2 text-white"></i>{{$pizza->view_count}}</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fa-bars-staggered me-2 text-white"></i>{{$pizza->category_name}}</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fa-calendar-check me-3 text-white"></i>{{$pizza->created_at->format('j-F-Y')}}</span>
                                    <div class="my-3 text-muted"><i class="fa-solid fa-file me-2 text-dark"></i> Details:</div>
                                    <div> {{$pizza->description}}</div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

</div>
@endsection
