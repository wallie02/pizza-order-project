@extends('admin.layout.master2')

@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">

                        {{-- delete message --}}
                        @if(session('deleteSS'))
                            <div class="col-4 offset-8">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-xmark mx-2"></i> <strong>{{session('deleteSS')}}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif


                                <h4>Total - {{ $userlist->total() }} </h4>

                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id='datalist'>
                                   @foreach ( $userlist as $ul )
                                        <tr class="tr-shadow">
                                            <input type="hidden" class="roleID" value="{{ $ul->id }}">
                                            <td class="col-2" style="width:100px">
                                                @if ($ul->image == null)
                                                    @if ($ul->gender == 'male')
                                                        <img src="{{asset('image/profile.png')}}" class="img-thumbnail shadow-sm" >
                                                    @else
                                                         <img src="{{asset('image/profileFe.webp')}}" class="img-thumbnail shadow-sm"  >
                                                    @endif
                                                @else
                                                    <img src="{{asset('storage/'.$ul->image)}}" />
                                                @endif
                                            </td>
                                            <td>{{ $ul->name}}</td>
                                            <td>{{ $ul->email}}</td>
                                            <td>{{ $ul->gender}}</td>
                                            <td>{{ $ul->phone}}</td>
                                            <td>{{ $ul->address}}</td>
                                            <td>
                                                @if(Auth::user()->id == $ul->id)

                                                @else
                                                    <select name="role" class="form-control text-center chRole">
                                                        <option value="admin"  @if ($ul->role == 'admin') selected @endif>Admin</option>
                                                        <option value="user"  @if ($ul->role == 'user') selected @endif>User</option>
                                                    </select>
                                                @endif
                                            </td>

                                          <td>
                                                <a href="{{route('userlist#updatePage',$ul->id)}}">
                                                    <button class="item me-1 btn btn-lg bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit text-dark "></i>
                                                    </button>
                                                </a>

                                                <a href="{{route('userlist#delete',$ul->id)}}">
                                                    <button class="item me-1 btn btn-lg bg-light-10 shadow-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete text-dark "></i>
                                                    </button>
                                                </a>
                                          </td>
                                        </tr>

                                   @endforeach
                            </tbody>
                        </table>

                        <div class="mt-5">
                            {{ $userlist->links()}}
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
                    url: '/user/ajax/userchange/role',
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

