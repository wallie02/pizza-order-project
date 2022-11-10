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

                            <a href="{{ route('admin#adminList') }}">
                                <div class="ms-3">
                                    <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                                </div>
                            </a>

                            <div class="card-title">
                                <h3 class="text-center title-2" > Change Role </h3>
                            </div>

                            <hr>
                           {{--edit profile --}}
                           <form action="{{route('admin#changeRoleUp',$account->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-3 offset-2">
                                        @if ($account->image == null)
                                               @if ($account->gender == 'male')
                                                <img src="{{asset('image/profile.png')}}" class="img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{asset('image/profileFe.webp')}}" class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/'.$account->image)}}" />
                                        @endif

                                        <div class="">
                                            <input disabled type="file" name="image" class="form-control mt-2 @error('image') is-invalid @enderror">
                                            @error('image')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-dark text-light col-12" type="submit"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Change</button>
                                        </div>
                                    </div>

                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Name </label>
                                            <input id="cc-pament" name="name" disabled type="text" value="{{old('name',$account->name)}}" class="form-control  @error('name') is-invalid @enderror" aria-invalid="false" placeholder="Eneter Admin Name...">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Role </label>
                                            <select name="role" class="form-control">
                                                <option value="admin" @if ($account->role == 'admin') selected @endif>Admin</option>
                                                <option value="user" @if ($account->role == 'user') selected @endif>User</option>
                                            </select>
                                            {{-- <input id="cc-pament" name="role" type="text" value="{{old('role',$account->role)}}" class="form-control" aria-invalid="false" > --}}
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Email </label>
                                            <input id="cc-pament" name="email" disabled type="email" value="{{old('email',$account->email)}}"  class="form-control @error('email') is-invalid @enderror" aria-invalid="false" placeholder="Eneter Admin Email...">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1"> Phone </label>
                                            <input id="cc-pament" name="phone" disabled type="number" value="{{old('phone',$account->phone)}}"  class="form-control  @error('phone') is-invalid @enderror " aria-invalid="false" placeholder="Eneter Admin Phone...">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Gender </label>
                                            <select name="gender" disabled class="form-control  @error('gender') is-invalid @enderror">
                                                <option value="">Choose your gender</option>
                                                <option value="male" @if($account->gender == 'male') selected @endif>  Male</option>
                                                <option value="female"  @if($account->gender == 'female') selected @endif> Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Address </label>
                                            <textarea name="address" disabled class="form-control @error('address') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Admin Address..">{{old('address',$account->address)}}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
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
