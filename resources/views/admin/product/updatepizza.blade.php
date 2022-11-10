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

                             {{--  return back to my searched list --}}
                             <div class="ms-3">
                                <a href="{{route('product#productList')}}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-arrow-left text-dark me-1" onclick="history.back()"></i> Back
                                </a>
                             </div>

                            <div class="card-title">
                                <h3 class="text-center title-2" > Update Pizza </h3>
                            </div>

                            <hr>
                           {{--edit profile --}}
                           <form action="{{route('product#updatePizza')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-3 offset-2">
                                            <input type="hidden" name="pizzaid" value="{{$pizzaup->id}}">
                                            <img src="{{asset('storage/' .$pizzaup->image)}}" class="img-thumbnail shadow-sm" />


                                        <div class="mt-3">
                                            <input type="file" name="pizzaImage" class="form-control mt-2 @error('pizzaImage') is-invalid @enderror">
                                            @error('pizzaImage')
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
                                            <input id="cc-pament" name="pizzaName" type="text" value="{{old('pizzaName',$pizzaup->name)}}" class="form-control  @error('pizzaName') is-invalid @enderror" aria-invalid="false" placeholder="Eneter Pizza Name...">
                                            @error('pizzaName')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Price </label>
                                            <input id="cc-pament" name="pizzaPrice" type="number" value="{{old('pizzaPrice',$pizzaup->price)}}"  class="form-control @error('pizzaPrice') is-invalid @enderror" aria-invalid="false" placeholder="Eneter Price...">
                                            @error('pizzaPrice')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Category </label>
                                            <select name="pizzaCategory" class="form-control  @error('pizzaCategory') is-invalid @enderror">
                                                <option value="">Choose Pizza Category</option>
                                                @foreach ( $category as $c )
                                                    <option value="{{ $c->id }}" @if ($pizzaup->category_id == $c->id ) selected @endif>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('pizzaCategory')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Waiting Time </label>
                                            <input id="cc-pament" name="pizzaWaitingTime" type="number" value="{{old('pizzaWaitingTime',$pizzaup->waiting_time)}}" class="form-control  @error('pizzaWaitingTime') is-invalid @enderror" aria-invalid="false" >
                                            @error('pizzaWaitingTime')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Description </label>
                                            <textarea name="pizzaDescription" class="form-control @error('pizzaDescription') is-invalid @enderror" cols="30" rows="10" placeholder="Enter description..">{{old('pizzaDescription',$pizzaup->description)}}</textarea>
                                            @error('pizzaDescription')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> View Count </label>
                                            <input id="cc-pament" name="viewcount" type="number" value="{{old('viewcount',$pizzaup->view_count)}}" class="form-control" aria-invalid="false" disabled>
                                        </div>


                                        <div class="form-group">
                                            <label  class="control-label mb-1 "> Created Date </label>
                                            <input id="cc-pament" name="createdat" type="text" value="{{$pizzaup->created_at->format('j-F-Y')}}" class="form-control " aria-invalid="false" disabled>
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
