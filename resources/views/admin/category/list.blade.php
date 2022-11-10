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
                                <h2 class="title-1">Category List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{route('category#createPage')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                 {{-- delete alert --}}

                   @if(session('deleteSucccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark mx-2"></i> <strong>{{session('deleteSucccess')}}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- Serach category --}}
                    <div class="row">
                        <div class="col-3">
                             <h4 class="text-secondary">Search Category | <span class="text-danger"> {{request ('search') }} </span></h4>
                        </div>


                        <div class=" col-3 offset-6">
                            <form action="{{route('category#list')}}" method="GET">
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
                            <div class="col-1 offset-10 bg-white p-2 shadow-sm text-center">
                                <h3> <i class="fa-solid fa-folder-plus"></i> {{ $categoryList->total()}}</h3>
                            </div>
                        </div>

                    @if (count($categoryList) != 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoryList as $category )
                                <tr class="tr-shadow">
                                    <td>{{ $category->id}}</td>
                                    <td class="col-5">{{  $category->name}}</td>
                                    <td>{{  $category->created_at->format('j-F-Y')}}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            <button class="item me-1 bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="View">
                                                <i class="fa-solid fa-eye text-dark "></i>
                                            </button>

                                            <a href="{{route('category#edit',$category->id)}}">
                                                <button class="item me-1 bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit text-dark "></i>
                                                </button>
                                            </a>

                                            <a href="{{route('category#delete',$category->id)}}">
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
                            {{ $categoryList->links()}}
                            {{-- {{ $categoryList->appends(request()->query())->links() }} --}}

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
