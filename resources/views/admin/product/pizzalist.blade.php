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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{route('product#createPizza')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
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
                            <form action="{{route('product#productList')}}" method="GET">
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
                                <h3> <i class="fa-solid fa-folder-plus"></i> {{ $pizzas->total() }}</h3>
                            </div>
                        </div>

                    @if (count($pizzas) != 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>View Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pizzas as $p )
                                <tr class="tr-shadow">
                                    <td class='col-2'><img src="{{asset('storage/' .$p->image )}}" class="img-thumbnail shadow-sm" style="width: 70px"></td>
                                    <td class='col-2'>{{ $p->name }}</td>
                                    <td class='col-2'>{{ $p->price }}</td>
                                    <td class='col-2'>{{ $p->category_name}}</td>
                                    <td class='col-2'><i class="fa-regular fa-eye me-2"></i>{{ $p->view_count}}</td>
                                    <td class='col-2'>
                                        <div class="table-data-feature">
                                            <a href="{{route('product#editPizza',$p->id)}}">
                                                <button class="item me-1 bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="View">
                                                    <i class="fa-solid fa-eye text-dark "></i>
                                                </button>
                                            </a>

                                            <a href="{{route('product#updatePagePizza',$p->id)}}">
                                                <button class="item me-1 bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit text-dark "></i>
                                                </button>
                                            </a>

                                            <a href="{{route('product#deletePizza',$p->id)}}">
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

                        {{-- paginate --}}
                        <div class="mt-3">
                            {{ $pizzas->links() }}
                        </div>

                    </div>
                    @else
                        <h1 class='text-secondary text-center mt-5'>Nothing Here</h1>
                    @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

</div>
@endsection
