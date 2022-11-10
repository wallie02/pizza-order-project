@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->


                    {{-- Serach category --}}
                    <div class="row">
                        <div class="col-3">
                             <h4 class="text-secondary">Search Admin | <span class="text-danger"> {{request ('search') }} </span></h4>
                        </div>


                        <div class=" col-3 offset-6">
                            <form action="{{route('admin#adminList')}}" method="GET">
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
                                <h3> <i class="fa-solid fa-folder-plus"></i> {{ $adminlist->total() }} </h3>
                            </div>
                        </div>

                    {{-- @if (count($categoryList) != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role Change</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($adminlist as $a )
                                <tr class="tr-shadow">
                                    <input type="hidden" class="roleID" value="{{ $a->id }}">
                                    <td class='col-2'>
                                        @if ($a->image === null)
                                            @if ($a->gender == 'male')
                                                <img src="{{asset('image/profile.png')}}" class="img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{asset('image/profileFe.webp')}}" class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{asset('storage/' .$a->image )}}" class="img-thumbnail shadow-sm">
                                        @endif
                                    </td>
                                    <td>{{  $a->email}}</td>
                                    <td>{{  $a->gender}}</td>
                                    <td>{{  $a->name}}</td>
                                    <td>{{  $a->phone}}</td>
                                    <td>{{  $a->address}}</td>
                                    <td>
                                        @if(Auth::user()->id == $a->id)

                                        @else
                                            <select name="role" class="form-control text-center chRole">
                                                <option value="admin"  @if ($a->role == 'admin') selected @endif>Admin</option>
                                                <option value="user"  @if ($a->role == 'user') selected @endif>User</option>
                                            </select>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="table-data-feature">
                                               @if (Auth::user()->id == $a->id)

                                               @else
                                                <a href="{{route('admin#changeRole', $a->id)}}">
                                                    <button class="item bg-light-10 shadow-sm " data-toggle="tooltip" data-placement="top" title="Change Role">
                                                        <i class="fa-solid fa-circle-dot text-dark"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('admin#adminListDelete', $a->id)}}">
                                                    <button class="item bg-light-10 shadow-sm ms-3" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete text-dark "></i>
                                                    </button>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- paginate --}}
                        <div class="mt-3">
                            {{ $adminlist->links()}}
                        </div>

                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

</div>
@endsection

@section('jscriptsection')
    <script>
        $(document).ready(function(){
            $('.chRole').change(function(){
                $currentRole =$(this).val();
                $parentNode = $(this).parents('tr');
                $roleid = $parentNode.find('.roleID').val()

                $.ajax({
                    type: 'get' ,
                    url: 'http://127.0.0.1:8000/admin/ajax/change/role',
                    data: {
                        'roleId' : $roleid,
                        'currentrole' : $currentRole
                    },
                    dataType: 'json',
                })
                location.reload();
            })

        })

    </script>
@endsection
