
@extends('user.layouts.master3')

@section('content')
        <div class="row">
            <div class="col-6 offset-3 ">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center title-2"> Change Password </h3>
                                        </div>

                                        {{-- alert password changed --}}
                                        @if(session('changeSuccess'))
                                        <div class="col-12">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-circle-xmark mx-2"></i> <strong>{{session('changeSuccess')}}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                        @endif

                                        {{-- old password check same or not --}}
                                        @if(session('notMatching'))
                                        <div class="col-12">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-circle-exclamation me-2"></i> <strong>{{session('notMatching')}}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                        @endif

                                        <hr>
                                        <form action="{{route('user#changeUserPassword')}}" method="POST" novalidate="novalidate">
                                            @csrf
                                            <div class="form-group">
                                                <label  class="control-label mb-1">Old Password</label>
                                                <input id="cc-pament" name="oldpassword" type="password"  class="form-control  @error('oldpassword') is-invalid @enderror " aria-required="true" aria-invalid="false" placeholder="Eneter old password...">
                                                @error('oldpassword')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label mb-1">New Password</label>
                                                <input id="cc-pament" name="newpassword" type="password"  class="form-control @error('newpassword') is-invalid @enderror " aria-required="true" aria-invalid="false" placeholder="Enter new pasword...">
                                                @error('newpassword')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label mb-1">Confirmed Password</label>
                                                <input id="cc-pament" name="confirmedpassword" type="password"  class="form-control @error('confirmedpassword') is-invalid @enderror " aria-required="true" aria-invalid="false" placeholder="Enter your password confirmed ...">
                                                @error('confirmedpassword')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg btn-dark text-white btn-block">
                                                    <i class="fa-solid fa-key me-2"></i>
                                                    <span id="payment-button-amount">Change Password</span>
                                                    {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
