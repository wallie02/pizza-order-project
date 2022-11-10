@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2" > User Account Profile </h3>
                            </div>

                            <hr>
                           {{--edit profile --}}
                           <form action="{{route('userlist#updateAcc',$userup ->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-3 offset-2">
                                        <input type="hidden" name="userid" value="{{$userup->id}}">

                                        @if ($userup ->image == null)
                                               @if ($userup ->gender == 'male')
                                                    <img src="{{asset('image/profile.png')}}" class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{asset('image/profileFe.webp')}}" class="img-thumbnail shadow-sm">
                                                @endif
                                        @else
                                            <img src="{{asset('storage/'.$userup ->image)}}" class="img-thumbnail shadow-sm"/>
                                        @endif

                                        <div class="">
                                            <input type="file" name="image" class="form-control mt-2 @error('image') is-invalid @enderror">
                                            @error('image')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-dark text-light col-12" type="submit"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Update</button>
                                        </div>
                                    </div>

                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Name </label>
                                            <input id="cc-pament" name="name" type="text" value="{{old('name',$userup ->name)}}" class="form-control  @error('name') is-invalid @enderror" aria-invalid="false" placeholder="Eneter Admin Name...">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Email </label>
                                            <input id="cc-pament" name="email" type="email" value="{{old('email',$userup ->email)}}"  class="form-control @error('email') is-invalid @enderror" aria-invalid="false" placeholder="Eneter Admin Email...">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1"> Phone </label>
                                            <input id="cc-pament" name="phone" type="number" value="{{old('phone',$userup ->phone)}}"  class="form-control  @error('phone') is-invalid @enderror " aria-invalid="false" placeholder="Eneter Admin Phone...">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Gender </label>
                                            <select name="gender" class="form-control  @error('gender') is-invalid @enderror">
                                                <option value="">Choose your gender</option>
                                                <option value="male" @if($userup ->gender == 'male') selected @endif>  Male</option>
                                                <option value="female"  @if($userup ->gender == 'female') selected @endif> Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Address </label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Admin Address..">{{old('address',$userup ->address)}}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Role </label>
                                            <input id="cc-pament" name="role" type="text" value="{{old('role',$userup ->role)}}" class="form-control" aria-invalid="false" disabled>
                                        </div>

                                    </div>

                                </div>



                           </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

</div>
@endsection
