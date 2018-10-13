@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
@endsection
@section('navmenu')
    @if(Gate::check('dashboard'))
    <li> <a href="{{route('dashboard')}}">Dashboard</a></li>
    @endif

    @if(Gate::check('master-data'))
    <li> <a href="{{route('data')}}">Master Data</a></li>
    @endif

    @if(Gate::check('master-data-type'))
    <li> <a href="{{route('type_cust')}}">Master Data Type</a></li>
    @endif

    @if(Gate::check('master-branch'))
    <li> <a href="{{route('branch')}}">Master Branch</a></li>
    @endif

    @if(Gate::check('master-cso'))
    <li> <a href="{{route('cso')}}">Master CSO</a></li>
    @endif

    @if(Gate::check('master-user'))
    <li class="list-selected">Master User</li>
    @endif

    @if(Gate::check('report'))
    <li> <a href="">Report</a></li>
    @endif
@endsection
@section('content')
<div class="container contact-clean" id="form-addMember">
    <!-- FORM UNTUK DATA BARU -->
    <form id="actionAdd" method="POST" action="{{ route('store_user') }}">
        {{ csrf_field() }}

        <h1 class="text-center">Add User</h1>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <span>NAME</span>
            <input id="name" type="text" name="name" class="text-uppercase form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="FULL NAME" value="{{ old('name') }}" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
            <span>USERNAME</span>
            <input id="username" type="text" name="username" class="text-uppercase form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="USERNAME" value="{{ old('username') }}" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        </div>
        <div class="frm-group-select form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <span>PASSWORD</span>
            <input id="password" type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        </div>
        <div class="frm-group-select select-right form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <span>ROLE</span>
            <select class="text-uppercase form-control {{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" value="{{ old('role') }}" required>
                <optgroup label="ROLE">
                    @foreach($roles as $id => $role)
                        <option value="{{$id}}">{{$role}}</option>
                    @endforeach
                </optgroup>
            </select>
            @if ($errors->has('role'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group frm-group-select {{ $errors->has('country') ? ' has-error' : '' }}">
            <span>COUNTRY</span>
            <select id="country" class="text-uppercase form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old('country') }}" required>
                <optgroup label="Country">
                    @include('etc.select-country')
                </optgroup>
            </select>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
        </div>
        <div class="form-group frm-group-select select-right {{ $errors->has('branch') ? ' has-error' : '' }}" style="/*float:right;*/">
            <span>BRANCH</span>
            <select id="branch" class="form-control{{ $errors->has('branch') ? ' is-invalid' : '' }}" name="branch" value="{{old('branch')}}" required>
                <optgroup label="Branch">
                    <option value="" readonly selected>SELECT COUNTRY FIRST</option>
                </optgroup>
            </select>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('branch') }}</strong>
            </span>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit" id="btn-confirmAddUser">SAVE</button>
        </div>
    </form>
</div>
@can('browse-user')
<div class="container" id="list-member" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List User</h1>

    <!-- KHUSUS BWAT UI SEARCH -->
    <form class="search-form" action="{{ url()->current() }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <input class="form-control" type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search...">
            <div class="input-group-append">
                <button class="btn btn-light border" type="submit">Search</button>
            </div>
        </div>
    </form>
    <!-- KHUSUS BWAT UI SEARCH -->

    <!-- untuk table data -->
    <div class="table-responsive table table-striped table-indesktop">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>USERNAME</th>
                    <th>ROLE</th>
                    <th>COUNTRY</th>
                    <th>BRANCH</th>
                    @if(Gate::check('edit-user') || Gate::check('delete-user'))
                    <th colspan="2">EDIT/DELETE</th>
                    <th class="d-none">PERMISSIONS</th>
                    @endif
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($users as $user)
                <tr>
                    <td>{{$user->code}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->roles[0]['name']}}</td>
                    <td>{{$user->branch['country']}}</td>
                    <td>{{$user->branch['name']}}</td>
                    <td class="d-none">{{$user->permissions}}</td>
                    @if(Gate::check('edit-user'))
                    <td style="text-align:center;">
                        <button class="btn btn-primary btn-editUser" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$user->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-user'))
                    <td style="text-align:center;">
                        <button class="btn btn-primary btn-deleteUser" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$user->id}}">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                    @endif
                </tr>
                @php
                $i++
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- untuk card data -->
    @php
    $i = 0
    @endphp
    @foreach($users as $user)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$user->code}} - {{$user->name}}<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">{{$user->branch['country']}} - {{$user->branch['name']}}<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:8px;">Username :&nbsp;{{$user->username}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:10px;">Role : {{$user->roles[0]['name']}}<br></p>
                @if(Gate::check('edit-user'))
                <button class="btn btn-primary btn-edithapus-card btn-editUser" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$user->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-user'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteUser" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$user->id}}">
                    <i class="material-icons">delete</i>
                </button>
                @endif
            </div>
        </div>
    </div>
    @php
    $i++
    @endphp
    @endforeach

    <!-- untuk pagination -->
    <div class="pagination-wrapper" style="float:right;">
        {{ $users->links() }}
    </div>
    
</div>
@endcan
@endsection

@section('modal')
<!-- modal hapus data -->
<div class="modal fade" role="dialog" tabindex="-1" id="modal-DeleteConfirm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete&nbsp;</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="txt-delete-user"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <form id="actionDelete" action="{{route('delete_user', ['id' => ''])}}" method="post">
                    {{csrf_field()}}
                    <button class="btn btn-danger" type="submit" id="btn-confirmDeleteUser" value="-">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal update data -->
<div class="modal fade" role="dialog" tabindex="-1" id="modal-UpdateForm">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-center">Edit User</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- FORM UNTUK UPDATE DATA -->
            <form id="actionEdit" method="post" action="{{ route('update_user') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <span>CODE</span>
                        <input class="text-uppercase form-control" type="text" name="code" readonly="" id="txtkode-user">
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input class="text-uppercase form-control" type="text" name="name" required="" placeholder="Name" autofocus="" id="txtnama-user">
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>USERNAME</span>
                        <input class="text-uppercase form-control" type="text" name="username" placeholder="User Name" id="txtusername-user">
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select class="text-uppercase form-control" value="-" id="txtcountry-user" name="country">
                            <optgroup label="Country">
                                @include('etc.select-country')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right" style="/*float:right;*/">
                        <span>BRANCH</span>
                        <select class="text-uppercase form-control" id="txtbranch-user" name="branch">
                            <optgroup label="Branch">
                                <option value="" disabled="disabled" selected="selected">Select COUNTRY first1</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('branch') }}</strong>
                        </span>
                    </div>
                    <h4 style="margin-top:10px;border-bottom:solid 1px grey;">PERMISSIONS</h4>
                    <div class="form-group" id="group-mpc">
                        <span style="display:block;">MPC</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-mpc">
                                <label class="form-check-label" for="add-mpc">Add MPC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-mpc">
                                <label class="form-check-label" for="browse-mpc">Browse MPC</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditMPC">
                                <input class="form-check-input" type="checkbox" id="edit-mpc">
                                <label class="form-check-label" for="edit-mpc">Edit MPC</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteMPC">
                                <input class="form-check-input" type="checkbox" id="delete-mpc">
                                <label class="form-check-label" for="delete-mpc">Delete MPC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="find-mpc">
                                <label class="form-check-label" for="find-mpc">Find MPC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-branch-mpc">
                                <label class="form-check-label" for="all-branch-mpc">All Branch MPC</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-AllCountryMPC">
                                <input class="form-check-input" type="checkbox" id="all-country-mpc">
                                <label class="form-check-label" for="all-country-mpc">All Country MPC</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-data-undangan">
                        <span style="display:block;">DATA UNDANGAN</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-data-undangan">
                                <label class="form-check-label" for="add-data-undangan">Add Data Undangan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-data-undangan">
                                <label class="form-check-label" for="browse-data-undangan">Browse Data Undangan</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditDataUndangan">
                                <input class="form-check-input" type="checkbox" id="edit-data-undangan">
                                <label class="form-check-label" for="edit-data-undangan">Edit Data Undangan</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteDataUndangan">
                                <input class="form-check-input" type="checkbox" id="delete-data-undangan">
                                <label class="form-check-label" for="delete-data-undangan">Delete Data Undangan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="find-data-undangan">
                                <label class="form-check-label" for="find-data-undangan">Find Data Undangan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-branch-data-undangan">
                                <label class="form-check-label" for="all-branch-data-undangan">All Branch Data Undangan</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-AllCountryDataUndangan">
                                <input class="form-check-input" type="checkbox" id="all-country-data-undangan">
                                <label class="form-check-label" for="all-country-data-undangan">All Country Data Undangan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-data-outsite">
                        <span style="display:block;">DATA OUTSITE</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-data-outsite">
                                <label class="form-check-label" for="add-data-outsite">Add Data Outsite</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-data-outsite">
                                <label class="form-check-label" for="browse-data-outsite">Browse Data Outsite</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditDataOutsite">
                                <input class="form-check-input" type="checkbox" id="edit-data-outsite">
                                <label class="form-check-label" for="edit-data-outsite">Edit Data Outsite</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteDataOutsite">
                                <input class="form-check-input" type="checkbox" id="delete-data-outsite">
                                <label class="form-check-label" for="delete-data-outsite">Delete Data Outsite</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="find-data-outsite">
                                <label class="form-check-label" for="find-data-outsite">Find Data Outsite</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-branch-data-outsite">
                                <label class="form-check-label" for="all-branch-data-outsite">All Branch Data Outsite</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-AllCountryDataOutsite">
                                <input class="form-check-input" type="checkbox" id="all-country-data-outsite">
                                <label class="form-check-label" for="all-country-data-outsite">All Country Data Outsite</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-data-therapy">
                        <span style="display:block;">DATA THERAPY</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-data-therapy">
                                <label class="form-check-label" for="add-data-therapy">Add Data Therapy</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-data-therapy">
                                <label class="form-check-label" for="browse-data-therapy">Browse Data Therapy</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditDataTherapy">
                                <input class="form-check-input" type="checkbox" id="edit-data-therapy">
                                <label class="form-check-label" for="edit-data-therapy">Edit Data Therapy</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteDataTherapy">
                                <input class="form-check-input" type="checkbox" id="delete-data-therapy">
                                <label class="form-check-label" for="delete-data-therapy">Delete Data Therapy</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="find-data-therapy">
                                <label class="form-check-label" for="find-data-therapy">Find Data Therapy</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-branch-data-therapy">
                                <label class="form-check-label" for="all-branch-data-therapy">All Branch Data Therapy</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-AllCountryDataTherapy">
                                <input class="form-check-input" type="checkbox" id="all-country-data-therapy">
                                <label class="form-check-label" for="all-country-data-therapy">All Country Data Therapy</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-type-cust">
                        <span style="display:block;">TYPE CUST</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-type-cust">
                                <label class="form-check-label" for="add-type-cust">Add Type Cust</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-type-cust">
                                <label class="form-check-label" for="browse-type-cust">Browse Type Cust</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditTypeCust">
                                <input class="form-check-input" type="checkbox" id="edit-type-cust">
                                <label class="form-check-label" for="edit-type-cust">Edit Type Cust</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteTypeCust">
                                <input class="form-check-input" type="checkbox" id="delete-type-cust">
                                <label class="form-check-label" for="delete-type-cust">Delete Type Cust</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-cso">
                        <span style="display:block;">CSO</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-cso">
                                <label class="form-check-label" for="add-cso">Add CSO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-cso">
                                <label class="form-check-label" for="browse-cso">Browse CSO</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditCSO">
                                <input class="form-check-input" type="checkbox" id="edit-cso">
                                <label class="form-check-label" for="edit-cso">Edit CSO</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteCSO">
                                <input class="form-check-input" type="checkbox" id="delete-cso">
                                <label class="form-check-label" for="delete-cso">Delete CSO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-branch-cso">
                                <label class="form-check-label" for="all-branch-cso">All Branch CSO</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-AllCountryCSO">
                                <input class="form-check-input" type="checkbox" id="all-country-cso">
                                <label class="form-check-label" for="all-country-cso">All Country CSO</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-branch">
                        <span style="display:block;">BRANCH</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-branch">
                                <label class="form-check-label" for="add-branch">Add Branch</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-branch">
                                <label class="form-check-label" for="browse-branch">Browse Branch</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditBranch">
                                <input class="form-check-input" type="checkbox" id="edit-branch">
                                <label class="form-check-label" for="edit-branch">Edit Branch</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteBranch">
                                <input class="form-check-input" type="checkbox" id="delete-branch">
                                <label class="form-check-label" for="delete-branch">Delete Branch</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-country-branch">
                                <label class="form-check-label" for="all-country-branch">All Country Branch</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="group-user">
                        <span style="display:block;">USER</span>
                        <div class="div-CheckboxGroup">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="add-user">
                                <label class="form-check-label" for="add-user">Add User</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="browse-user">
                                <label class="form-check-label" for="browse-user">Browse User</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-EditUser">
                                <input class="form-check-input" type="checkbox" id="edit-user">
                                <label class="form-check-label" for="edit-user">Edit User</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-DeleteUser">
                                <input class="form-check-input" type="checkbox" id="delete-user">
                                <label class="form-check-label" for="delete-user">Delete User</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="all-branch-user">
                                <label class="form-check-label" for="all-branch-user">All Branch User</label>
                            </div>
                            <div class="form-check form-check-inline d-none" id="check-AllCountryUser">
                                <input class="form-check-input" type="checkbox" id="all-country-user">
                                <label class="form-check-label" for="all-country-user">All Country User</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-confirmUpdateUser" value="-">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function _(el){
        return document.getElementById(el);
    }

    $(document).ready(function () {
        //untuk refresh halaman ketika modal [SUCCESS Update] ditutup 
        $('#modal-NotificationUpdate').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        //untuk refresh halaman ketika modal [SUCCESS Add] ditutup 
        $('#modal-Notification').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        //-- Add User --//
            var formAdd;

            $('#btn-confirmAddUser').click(function(e){
                e.preventDefault();

                formAdd = _("actionAdd");
                formAdd = new FormData(formAdd);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerAdd, false);
                ajax.addEventListener("load", completeHandlerAdd, false);
                ajax.addEventListener("error", errorHandlerAdd, false);
                ajax.addEventListener("abort", abortHandlerAdd, false);
                ajax.open("POST", "{{ route('store_user') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formAdd);
            });
            function progressHandlerAdd(event){
                document.getElementById("btn-confirmAddUser").innerHTML = "Uploading...";
            }
            function completeHandlerAdd(event){
                var hasil = JSON.parse(event.target.responseText);
                var formDOM = _("actionAdd");

                for (var key of formAdd.keys()) {
                    $("#actionAdd").find("input[name="+key+"]").removeClass("is-invalid");
                    $("#actionAdd").find("select[name="+key+"]").removeClass("is-invalid");

                    $("#actionAdd").find("input[name="+key+"]").next().find("strong").text("");
                    $("#actionAdd").find("select[name="+key+"]").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of formAdd.keys()) {
                        console.log(key);
                        if(typeof hasil['errors'][key] === 'undefined') {
                        }
                        else
                        {
                            $("#actionAdd").find("input[name="+key+"]").addClass("is-invalid");
                            $("#actionAdd").find("select[name="+key+"]").addClass("is-invalid");

                            $("#actionAdd").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                            $("#actionAdd").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                }
                else{
                    $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">Data has been ADDED successfully</div>");
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmAddUser").innerHTML = "SAVE";
            }
            function errorHandlerAdd(event){
                document.getElementById("btn-confirmAddUser").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerAdd(event){
            }

        //-- Edit User --//
            var formEdit;

            $('#btn-confirmUpdateUser').click(function(e){
                e.preventDefault();

                formEdit = _("actionEdit");
                formEdit = new FormData(formEdit);
                formEdit.append("id", this.value);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerEdit, false);
                ajax.addEventListener("load", completeHandlerEdit, false);
                ajax.addEventListener("error", errorHandlerEdit, false);
                ajax.addEventListener("abort", abortHandlerEdit, false);
                ajax.open("POST", "{{ route('update_user') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formEdit);
            });
            function progressHandlerEdit(event){
                document.getElementById("btn-confirmUpdateUser").innerHTML = "Uploading...";
            }
            function completeHandlerEdit(event){
                var hasil = JSON.parse(event.target.responseText);
                var formDOM = _("actionEdit");

                for (var key of formEdit.keys()) {
                    $("#actionEdit").find("input[name^='"+key+"']").removeClass("is-invalid");
                    $("#actionEdit").find("select[name^='"+key+"']").removeClass("is-invalid");

                    $("#actionEdit").find("input[name^='"+key+"']").next().find("strong").text("");
                    $("#actionEdit").find("select[name^='"+key+"']").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of formEdit.keys()) {
                        if(typeof hasil['errors'][key] === 'undefined') {

                        }
                        else
                        {
                            $("#actionEdit").find("input[name^='"+key+"']").addClass("is-invalid");
                            $("#actionEdit").find("select[name^='"+key+"']").addClass("is-invalid");

                            $("#actionEdit").find("input[name^='"+key+"']").next().find("strong").text(hasil['errors'][key]);
                            $("#actionEdit").find("select[name^='"+key+"']").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                    var elmnt = document.getElementsByClassName("is-invalid");
                    elmnt[0].scrollIntoView();
                }
                else{
                    // console.log(event);
                    $('#modal-UpdateForm').modal('hide')
                    $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">Data has been CHANGED successfully</div>");
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmUpdateUser").innerHTML = "SAVE";
            }
            function errorHandlerEdit(event){
                document.getElementById("btn-confirmUpdateUser").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerEdit(event){
            }

        //-- Reset Form Update --//
        $("#modal-UpdateForm").on("hidden.bs.modal", function() {
            var formUpdate = _("actionEdit");
            formUpdate = new FormData(formUpdate);
            formUpdate.append("id", this.value);

            for (var key of formUpdate.keys()) {
                $("#actionEdit").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionEdit").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionEdit").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionEdit").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionEdit").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionEdit").find("textarea[name="+key+"]").next().find("strong").text("");
            }
        })
    });

    //The Branch changed when Country is selected
    $("#country").change(function () {
        var countryName = $(this).val().toUpperCase();
        var branches = "";

        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: "{{route('select-country')}}",
            data: {
                'country': countryName
            },
            success: function(data){
                if(data.length > 0)
                {
                    data.forEach(function(key, value){
                        branches += '<option value="'+data[value].id+'">'+data[value].code + " - " + data[value].name+'</option>';
                    });
                    $("#branch").html("");
                    $("#branch").append(branches);
                }
                else
                {
                    $("#branch").html("");
                    $("#branch").append("<option value=\"\" readonly selected>BRANCH NOT FOUND</option>");
                }
            },
        });
    });

    //The Branch (in Edit Form) changed when Country is selected
    $("#txtcountry-user").change(function () {
        var countryName = $(this).val().toUpperCase();
        var branches = "";

        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: "{{route('select-country')}}",
            data: {
                'country': countryName
            },
            success: function(data){
                console.log("masuk change country");
                if(data.length > 0)
                {
                    data.forEach(function(key, value){
                        branches += '<option value="'+data[value].id+'">'+data[value].code + " - " + data[value].name+'</option>';
                    });
                    $("#txtbranch-user").html("");
                    $("#txtbranch-user").append(branches);
                }
                else
                {
                    $("#txtbranch-user").html("");
                    $("#txtbranch-user").append("<option value=\"\" readonly selected>BRANCH NOT FOUND</option>");
                }
            },
        });
    });

    //The Branch field is selected based on what user has, when Edit Button clicked
    $(".btn-editUser").click(function(e) {
        var dataUser = GetListUserData(this.name);
        var countryName = dataUser.country;
        var branches = "";

        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            type: 'post',
            url: "{{route('select-country')}}",
            data: {
                'country': countryName
            },
            success: function(data){
                data.forEach(function(key, value){
                    branches += '<option value="'+data[value].id+'">'+data[value].code + " - " + data[value].name+'</option>';
                });
                $("#txtbranch-user").children("optgroup").eq(0).html("");
                $("#txtbranch-user").children("optgroup").eq(0).append(branches);
                $("#txtbranch-user").children("optgroup").eq(0).children("option:contains('"+dataUser.branch+"')").attr("selected", "selected");
                console.log("masuk change country");
            },
        });
    });

    // Scrollbar fix 
    // If you have a modal on your page that exceeds the browser height, 
    // then you can't scroll in it when closing an second modal. 
    // Ketika tutup modal pertama, trus scroll, yang ter-scroll malah page nya -> Salah 
    $(document).on('hidden.bs.modal', '.modal', function () { 
        $('.modal:visible').length && $(document.body).addClass('modal-open'); 
    });
</script>
@endsection