@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">

                        @if(session('deleSuccess'))
                            <div class="col-4 offset-8">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-xmark mx-2"></i> <strong>{{session('deleSuccess')}}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif

                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="col-4">Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id='datalist'>
                               @foreach ($contactlist as $c )
                                    <tr class="tr-shadow">
                                        <input type="hidden" value="{{$c->id}}">
                                            <td>{{$c->name}}</td>
                                            <td>{{$c->email}}</td>
                                            <td>{{$c->message}}</td>
                                            <td>{{$c->created_at->format('j-F-Y')}}</td>
                                            <td>
                                                <div class="table-data-featutre">
                                                    <a href="{{route('contact#deleteContact',$c->id)}}">
                                                        <button class="item me-1 bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete text-dark "></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                    </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $contactlist->links()}}
                        </div>


                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

</div>
@endsection


