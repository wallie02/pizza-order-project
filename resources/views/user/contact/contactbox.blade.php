@extends('user.layouts.master3')

@section('content')

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5 mt-5">
        <div class="row px-xl-5 justify-content-center ">
            <div class="col-lg-7 mb-30">
                <div class="card bg-primary bg-opacity-75 border border-dark">
                    <div class="card-body">

                        <div class="ms-3">
                            <a href="{{route('user#home')}}" class="text-decoration-none text-white">
                                <i class="fa-solid fa-arrow-left text-white me-1" onclick="history.back()"></i> Back
                            </a>
                         </div>

                        <div class="card-title">
                            <h2 class="text-center title-2 text-white" > Contact Us </h2>
                        </div>

                        <hr>

                        <form class="row g-3" action="{{ route('user#sendContact')}}" method="POST">
                            @csrf

                            <div class="col-md-6">
                              <label for="inputName" class="form-label fs-5 fw-bold text-white">Name</label>
                              <input type="text" name="contactName" class="form-control @error ('contactName') is-invalid @enderror" value="{{old('contactName')}}" id="inputName" placeholder="Please enter your name...">
                               @error('contactName')
                                    <div class="invalid-feedback fs-5">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                              <label for="inputEmail4" class="form-label  fs-5 fw-bold text-white">Email</label>
                              <input type="email" name="contactEmail" class="form-control @error ('contactEmail') is-invalid @enderror" value="{{old('contactEmail')}}" id="inputEmail4" placeholder="Please enter your email...">
                               @error('contactEmail')
                                    <div class="invalid-feedback fs-5">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                              <label for="inputMessage" class="form-label  fs-5 fw-bold text-white">Message</label>
                            <textarea name="message" name="contactMessage" class="form-control @error ('contactMessage') is-invalid @enderror" id="inputMessage" cols="30" rows="10" placeholder="Please left the comments...">{{old('contactMessage')}}</textarea>
                               @error('contactMessage')
                                    <div class="invalid-feedback fs-5">
                                        {{ $message }}
                                    </div>
                               @enderror
                            </div>

                            <div class="col-4 offset-9">
                              <button type="submit" class="btn bg-dark bg-opacity-75 text-white fw-bold py-3">Send Message <i class="fa-solid fa-paper-plane ms-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    <!-- Shop Detail End -->

@endsection
