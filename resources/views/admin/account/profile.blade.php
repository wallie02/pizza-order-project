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
                            <div class="card-title">
                                <h3 class="text-center title-2" > Account Info </h3>
                            </div>

                            <hr>
                           {{-- profile --}}
                           <div class="row">
                                <div class="col-3 offset-2">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{asset('image/profile.png')}}" class="img-thumbnail shadow-sm">
                                        @else
                                            <img src="{{asset('image/profileFe.webp')}}" class="img-thumbnail shadow-sm">
                                        @endif
                                    @else
                                        <img src="{{asset('storage/'.Auth::user()->image)}}" />
                                    @endif
                                </div>

                                <div class="col-5 offset-1">
                                    <h4 class="my-3"><i class="fa-solid fa-user-check me-2"></i> {{Auth::user()->name}}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-envelope me-2"></i> {{Auth::user()->email}}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-phone me-2"></i> {{Auth::user()->phone}}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-address-card me-3"></i>{{Auth::user()->address}}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-venus-mars me-2"></i>{{Auth::user()->gender}}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-calendar-check me-3"></i>{{Auth::user()->created_at->format('j-F-Y')}}</h4>
                                </div>
                           </div>

                           <div class="row">
                            <div class="col-4 offset-2 mt-3 ">
                                <a href="{{route('admin#profileEdit')}}">
                                    <button class="btn bg-dark text-light">
                                        <i class="fa-regular fa-pen-to-square me-2"></i> Edit Profile
                                    </button>
                                </a>
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
