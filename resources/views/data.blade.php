@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
@endsection
@section('navmenu')
    @if(Gate::check('dashboard'))
    <li> <a href="{{route('dashboard')}}">Dashboard</a></li>
    @endif

    @if(Gate::check('master-data'))
    <li class="list-selected">Master Data</li>
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
    <li> <a href="{{route('user')}}">Master User</a></li>
    @endif

    @if(Gate::check('report'))
    <li> <a href="">Report</a></li>
    @endif
@endsection
@section('content')
<div class="container contact-clean" id="form-addMember">
    <div class="tab-content">
        <ul class="nav nav-tabs">
            @if(Gate::check('find-data-undangan'))
            <li class="nav-item">
                <a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1" aria-selected="true" onclick="ShowList('1')">Data Undangan</a>
            </li>
            @endif
            @if(Gate::check('find-data-outsite'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-2" aria-selected="true" onclick="ShowList('2')">Data Outsite</a>
            </li>
            @endif
            @if(Gate::check('find-data-therapy'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-3" aria-selected="true"onclick="ShowList('3')">Data Therapy</a>
            </li>
            @endif
            @if(Gate::check('find-mpc'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-4" aria-selected="true"onclick="ShowList('4')">MPC</a>
            </li>
            @endif
        </ul>
        <div class="tab-pane active" role="tabpanel" id="tab-1">
            @if(Gate::check('find-data-undangan'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find Data Undangan</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keywordDataUndangan" value="{{ app('request')->input('keyword') }}" placeholder="Search by Phone Number..." style="height: 46.8px;" id="txt-keywordDataUndangan">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" id="btnFind-data-undangan" onclick="function(){$('#modal-DataUndangan').modal('show')};">Search</button>
                    </div>
                    <span class="invalid-feedback">
                        <strong style="margin-left: 40px; font-size: 12pt;"></strong>
                    </span>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store data undangan -->
            @if(Gate::check('add-data-undangan'))
            <form id="actionAddDataUndangan" name="frmAddDataUndangan" method="POST" action="{{ route('store_dataundangan') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Undangan</h1>
                <br>
                <div class="form-group">
                    <span>TIPE UNDANGAN</span>
                    <select id="txttype-cust-dataundangan" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TIPE UNDANGAN"> 
                            <option value="" disabled selected>SELECT TIPE UNDANGAN</option>
                            @foreach ($type_custs as $type_cust)
                                @if($type_cust->type_input == "UNDANGAN")
                                    <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div id="input-DataUndangan" class="d-none">
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input type="date" name="registration_date" class="text-uppercase form-control" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                     <div class="form-group">
                        <span>BIRTH DATE</span>
                        <input type="date" name="birth_date" class="text-uppercase form-control"required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>ADDRESS</span>
                        <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div id="Undangan-Bank" class="form-group">
                        
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select id="txtcountry-dataundangan" class="text-uppercase form-control" name="country" required>
                            <optgroup label="Country">
                                @include('etc.select-country')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>BRANCH</span>
                        <select id="txtbranch-dataundangan" class="text-uppercase form-control" name="branch" required>
                            <optgroup label="Branch">
                                @can('all-branch-data-undangan')
                                    @can('all-country-data-undangan')
                                        <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                    @endcan
                                    @cannot('all-country-data-undangan')
                                        <option value="" selected disabled>SELECT YOUR OPTION</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                        @endforeach
                                    @endcan
                                @endcan
                                @cannot('all-branch-data-undangan')
                                    <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>


                    <!-- CSO -->
                    <div class="form-group">
                        <span>CSO</span>
                        <select id="txtcso-dataundangan" class="text-uppercase form-control" name="cso" required>
                            <optgroup label="Cso">
                                @can('all-branch-data-undangan')
                                    <option value="" disabled selected>SELECT BRANCH FIRST</option>
                                @endcan
                                @cannot('all-branch-data-undangan')
                                <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($csos as $cso)
                                        @if($cso->branch_id == Auth::user()->branch_id)
                                            <option value="{{$cso->id}}">{{$cso->name}}</option>
                                        @endif
                                    @endforeach
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <!-- Khusus untuk Indo untuk sementara -->
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select id="txtprovince-dataundangan" class="text-uppercase form-control" name="province" required>
                            <optgroup label="Province">
                                @include('etc.select-province')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>DISTRICT</span>
                        <select id="txtdistrict-dataundangan" class="form-control text-uppercase" name="district"required>
                            <optgroup label="District">
                                <option disabled selected>SELECT PROVINCE FIRST</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>PHONE</span>
                        <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <button id="btn-actionAddDataUndangan" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                    </div>
                </div>
            </form>
            @endif

        </div>
        <div class="tab-pane" role="tabpanel" id="tab-2">
            @if(Gate::check('find-data-outsite'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find Data Outsite</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search by Phone Number..." style="height: 46.8px;">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" disabled>Search</button>
                    </div>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store data Outsite -->
            @if(Gate::check('add-data-outsite'))
            <form id="actionAddDataOutsite" name="frmAddDataOutsite" method="POST" action="{{ route('store_dataoutsite') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Out-Site</h1>
                <br>
                <div class="form-group">
                    <span>TIPE OUT-SITE</span>
                    <select id="txttype-cust-dataoutsite" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TIPE OUT-SITE"> 
                            <option value="" disabled selected>SELECT TIPE OUT-SITE</option>
                            @foreach ($type_custs as $type_cust)
                                @if($type_cust->type_input == "OUT-SITE")
                                    <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div id="input-DataOutsite" class="d-none">
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input type="date" name="registration_date" class="text-uppercase form-control" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div id="Outsite-Location" class="form-group">
                        
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select id="txtcountry-dataoutsite" class="text-uppercase form-control" name="country" required>
                            <optgroup label="Country">
                                @include('etc.select-country')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>BRANCH</span>
                        <select id="txtbranch-dataoutsite" class="text-uppercase form-control" name="branch" required>
                            <optgroup label="Branch">
                                @can('all-branch-data-outsite')
                                    @can('all-country-data-outsite')
                                        <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                    @endcan
                                    @cannot('all-country-data-outsite')
                                        <option value="" selected disabled>SELECT YOUR OPTION</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                        @endforeach
                                    @endcan
                                @endcan
                                @cannot('all-branch-data-outsite')
                                    <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>


                    <!-- CSO -->
                    <div class="form-group">
                        <span>CSO</span>
                        <select id="txtcso-dataoutsite" class="text-uppercase form-control" name="cso" required>
                            <optgroup label="Cso">
                                @can('all-branch-data-outsite')
                                    <option value="" disabled selected>SELECT BRANCH FIRST</option>
                                @endcan
                                @cannot('all-branch-data-outsite')
                                <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($csos as $cso)
                                        @if($cso->branch_id == Auth::user()->branch_id)
                                            <option value="{{$cso->id}}">{{$cso->name}}</option>
                                        @endif
                                    @endforeach
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <!-- Khusus untuk Indo untuk sementara -->
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select id="txtprovince-dataoutsite" class="text-uppercase form-control" name="province" required>
                            <optgroup label="Province">
                                @include('etc.select-province')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>DISTRICT</span>
                        <select id="txtdistrict-dataoutsite" class="form-control text-uppercase" name="district"required>
                            <optgroup label="District">
                                <option disabled selected>SELECT PROVINCE FIRST</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>PHONE</span>
                        <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <button id="btn-actionAddDataOutsite" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                    </div>
                </div>
            </form>
            @endif            

        </div>
        <div class="tab-pane" role="tabpanel" id="tab-3">
            @if(Gate::check('find-data-therapy'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find Data Therapy</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keyword" value="{{ app('request')->input('keyword') }}" placeholder="Search by Phone Number..." style="height: 46.8px;">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" disabled>Search</button>
                    </div>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store data Therapy -->
            @if(Gate::check('add-data-therapy'))
            <form id="actionAddDataTherapy" name="frmAddDataTherapy" method="POST" action="{{ route('store_datatherapy') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Therapy</h1>
                <br>
                <div class="form-group">
                    <span>TIPE THERAPY</span>
                    <select id="txttype-cust-datatherapy" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TIPE THERAPY"> 
                            <option value="" disabled selected>SELECT TIPE THERAPY</option>
                            @foreach ($type_custs as $type_cust)
                                @if($type_cust->type_input == "THERAPY")
                                    <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <span>REGISTRATION DATE</span>
                    <input type="date" name="registration_date" class="text-uppercase form-control" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>NAME</span>
                    <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>ADDRESS</span>
                    <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>COUNTRY</span>
                    <select id="txtcountry-datatherapy" class="text-uppercase form-control" name="country" required>
                        <optgroup label="Country">
                            @include('etc.select-country')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>BRANCH</span>
                    <select id="txtbranch-datatherapy" class="text-uppercase form-control" name="branch" required>
                        <optgroup label="Branch">
                            @can('all-branch-data-therapy')
                                @can('all-country-data-therapy')
                                    <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                @endcan
                                @cannot('all-country-data-therapy')
                                    <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                    @endforeach
                                @endcan
                            @endcan
                            @cannot('all-branch-data-therapy')
                                <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>


                <!-- CSO -->
                <div class="form-group">
                    <span>CSO</span>
                    <select id="txtcso-datatherapy" class="text-uppercase form-control" name="cso" required>
                        <optgroup label="Cso">
                            @can('all-branch-data-therapy')
                                <option value="" disabled selected>SELECT BRANCH FIRST</option>
                            @endcan
                            @cannot('all-branch-data-therapy')
                            <option value="" selected disabled>SELECT YOUR OPTION</option>
                                @foreach ($csos as $cso)
                                    @if($cso->branch_id == Auth::user()->branch_id)
                                        <option value="{{$cso->id}}">{{$cso->name}}</option>
                                    @endif
                                @endforeach
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <!-- Khusus untuk Indo untuk sementara -->
                <div class="form-group frm-group-select">
                    <span>PROVINCE</span>
                    <select id="txtprovince-datatherapy" class="text-uppercase form-control" name="province" required>
                        <optgroup label="Province">
                            @include('etc.select-province')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>DISTRICT</span>
                    <select id="txtdistrict-datatherapy" class="form-control text-uppercase" name="district"required>
                        <optgroup label="District">
                            <option disabled selected>SELECT PROVINCE FIRST</option>
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <div class="form-group">
                    <span>PHONE</span>
                    <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <button id="btn-actionAddDataTherapy" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                </div>
            </form>
            @endif

        </div>
        <div class="tab-pane" role="tabpanel" id="tab-4">
            @if(Gate::check('find-mpc'))
            <form action="{{ url()->current() }}" style="display: block;float: inherit;">
                <h1 style="text-align: center;color: rgb(80, 94, 108);">Find MPC</h1>
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <input class="form-control" type="text" name="keywordMpc" value="{{ app('request')->input('keywordMpc') }}" placeholder="Search by Phone Number..." style="height: 46.8px;">
                    <div class="input-group-append">
                        <button class="btn btn-light border" type="submit" disabled>Search</button>
                    </div>
                </div>
            </form>
            @endif

            <!-- FORM untuk add/store MPC -->
            @if(Gate::check('add-mpc'))
            <form id="actionAddMpc" name="frmAddMpc" method="POST" action="{{ route('store_mpc') }}">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add MPC</h1>
                <br>
                <div class="form-group">
                    <span>REGISTRATION DATE</span>
                    <input type="date" name="registration_date" class="text-uppercase form-control" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>MPC CODE</span>
                    <input type="text" id="txtcode-mpc" class="text-uppercase form-control" name="code" placeholder="MPC CODE" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>KTP</span>
                    <input type="number" id="txtktp-mpc" class="form-control text-uppercase" name="ktp"  placeholder="KTP" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>NAME</span>
                    <input type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>BIRTH DATE</span>
                    <input type="date" name="birth_date" class="text-uppercase form-control"required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>GENDER</span>
                    <select class="text-uppercase form-control" name="gender" required>
                        <optgroup label="Gender">
                            <option value="" disabled selected>SELECT GENDER</option>
                            <option value="PRIA">PRIA</option>
                            <option value="WANITA">WANITA</option>
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <span>ADDRESS</span>
                    <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select">
                    <span>COUNTRY</span>
                    <select id="txtcountry-mpc" class="text-uppercase form-control" name="country" required>
                        <optgroup label="Country">
                            @include('etc.select-country')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>BRANCH</span>
                    <select id="txtbranch-mpc" class="text-uppercase form-control" name="branch" required>
                        <optgroup label="Branch">
                            @can('all-branch-mpc')
                                @can('all-country-mpc')
                                    <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                @endcan
                                @cannot('all-country-mpc')
                                    <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                    @endforeach
                                @endcan
                            @endcan
                            @cannot('all-branch-mpc')
                                <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>


                <!-- CSO -->
                <div class="form-group">
                    <span>CSO</span>
                    <select id="txtcso-mpc" class="text-uppercase form-control" name="cso" required>
                        <optgroup label="Cso">
                            @can('all-branch-mpc')
                                <option value="" disabled selected>SELECT BRANCH FIRST</option>
                            @endcan
                            @cannot('all-branch-mpc')
                            <option value="" selected disabled>SELECT YOUR OPTION</option>
                                @foreach ($csos as $cso)
                                    @if($cso->branch_id == Auth::user()->branch_id)
                                        <option value="{{$cso->id}}">{{$cso->name}}</option>
                                    @endif
                                @endforeach
                            @endcan
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <!-- Khusus untuk Indo untuk sementara -->
                <div class="form-group frm-group-select">
                    <span>PROVINCE</span>
                    <select id="txtprovince-mpc" class="text-uppercase form-control" name="province" required>
                        <optgroup label="Province">
                            @include('etc.select-province')
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group frm-group-select select-right">
                    <span>DISTRICT</span>
                    <select id="txtdistrict-mpc" class="form-control text-uppercase" name="district"required>
                        <optgroup label="District">
                            <option disabled selected>SELECT PROVINCE FIRST</option>
                        </optgroup>
                    </select>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>

                <div class="form-group">
                    <span>PHONE</span>
                    <input type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                    <span class="invalid-feedback">
                        <strong></strong>
                    </span>
                </div>
                <div class="form-group">
                    <button id="btn-actionAddMpc" class="btn btn-primary" type="submit" name="submit">SAVE</button>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

<!---------------- KHUSUS UNTUK LIST DATA ---------------->
@if(Gate::check('browse-data-outsite'))
<div class="container d-none" id="ListTab-2" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List Data Out-Site</h1>

    <!-- KHUSUS BWAT UI SEARCH -->
    <form class="search-form" action="{{ url()->current() }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <input class="form-control" type="text" name="keywordDataOutsite" value="{{ app('request')->input('keywordDataOutsite') }}" placeholder="Search...">
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
                    <th>REG DATE</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>LOCATION</th>
                    <th>PHONE</th>
                    <th>TYPE CUST</th>
                    <th style="display: none;">PROVINCE</th>
                    <th style="display: none;">DISTRICT</th>
                    <th style="display: none;">COUNTRY</th>
                    <th style="display: none;">BRANCH</th>
                    <th style="display: none;">CSO</th>
                    <th style="text-align: center;" colspan="2">@if(Gate::check('edit-data-outsite'))EDIT @endif @if(Gate::check('delete-data-outsite'))/ DELETE @endif</th>
                </tr>
            </thead>
            <tbody name="ListDataOutsite">
                @php
                $i = 0
                @endphp
                @foreach($dataOutsites as $dataOutsite)
                <tr>
                    <td>{{$dataOutsite->registration_date}}</td>
                    <td>{{$dataOutsite->code}}</td>
                    <td>{{$dataOutsite->name}}</td>
                    <td>{{$dataOutsite->location['name']}} @if($dataOutsite->location == null)- @endif</td>
                    <td>0{{$dataOutsite->phone / 23}}</td>
                    <td>{{$dataOutsite->type_cust['name']}}</td>
                    <td style="display: none;">{{$dataOutsite->province}}</td>
                    <td style="display: none;">{{$dataOutsite->district}}</td>
                    <td style="display: none;">{{$dataOutsite->branch['country']}}</td>
                    <td style="display: none;">{{$dataOutsite->branch['id']}}</td>
                    <td style="display: none;">{{$dataOutsite->cso['id']}}</td>
                    <td style="display: none;">{{$dataOutsite->type_cust['id']}}</td>
                    @if(Gate::check('edit-data-outsite'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-editDataOutsite" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataOutsite->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-data-outsite'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-deleteDataOutsite" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataOutsite->id}}">
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
    @foreach($dataOutsites as $dataOutsite)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$dataOutsite->code}} - {{$dataOutsite->name}}<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">{{$dataOutsite->branch['country']}} - {{$dataOutsite->branch['code']}}<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Registration Date :</b> {{$dataOutsite->registration_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Location :</b> {{$dataOutsite->location['name']}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Phone :</b> 0{{$dataOutsite->phone / 23}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:10px;"><b>CSO :</b> {{$dataOutsite->cso['name']}}<br></p>
                @if(Gate::check('edit-data-outsite'))
                <button class="btn btn-primary btn-edithapus-card btn-editDataOutsite" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataOutsite->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-data-outsite'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteDataOutsite" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$dataOutsite->id}}">
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
        {{ $dataOutsites->links() }}
    </div>
</div>
@endif

@if(Gate::check('browse-data-therapy'))
<div class="container d-none" id="ListTab-3" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List Data Therapy</h1>

    <!-- KHUSUS BWAT UI SEARCH -->
    <form class="search-form" action="{{ url()->current() }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <input class="form-control" type="text" name="keywordDataTherapy" value="{{ app('request')->input('keywordDataTherapy') }}" placeholder="Search...">
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
                    <th>REG DATE</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>PHONE</th>
                    <th>BRANCH</th>
                    <th>TYPE CUST</th>
                    <th style="display: none;">ADDRESS</th>
                    <th style="display: none;">PROVINCE</th>
                    <th style="display: none;">DISTRICT</th>
                    <th style="display: none;">COUNTRY</th>
                    <th style="display: none;">CSO</th>
                    <th style="text-align: center;" colspan="2">@if(Gate::check('edit-data-therapy'))EDIT @endif @if(Gate::check('delete-data-therapy'))/ DELETE @endif</th>
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($dataTherapies as $dataTherapy)
                <tr>
                    <td>{{$dataTherapy->registration_date}}</td>
                    <td>{{$dataTherapy->code}}</td>
                    <td>{{$dataTherapy->name}}</td>
                    <td>0{{$dataTherapy->phone / 23}}</td>
                    <td>{{$dataTherapy->branch['code']}}</td>
                    <td>{{$dataTherapy->type_cust['name']}}</td>
                    <td style="display: none;">{{$dataTherapy->address}}</td>
                    <td style="display: none;">{{$dataTherapy->province}}</td>
                    <td style="display: none;">{{$dataTherapy->district}}</td>
                    <td style="display: none;">{{$dataTherapy->branch['country']}}</td>
                    <td style="display: none;">{{$dataTherapy->cso['id']}}</td>
                    @if(Gate::check('edit-data-therapy'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-editDataTherapy" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataTherapy->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-data-therapy'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-deleteDataTherapy" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataTherapy->id}}">
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
    @foreach($dataTherapies as $dataTherapy)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$dataTherapy->code}} - {{$dataTherapy->name}}<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">{{$dataTherapy->branch['country']}} - {{$dataTherapy->branch['code']}}<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Registration Date :</b> {{$dataTherapy->registration_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Address :</b> {{$dataTherapy->address}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Phone :</b> 0{{$dataTherapy->phone / 23}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:10px;"><b>CSO :</b> {{$dataTherapy->cso['name']}}<br></p>
                @if(Gate::check('edit-data-therapy'))
                <button class="btn btn-primary btn-edithapus-card btn-editDataTherapy" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataTherapy->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-data-therapy'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteDataTherapy" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$dataTherapy->id}}">
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
        {{ $dataTherapies->links() }}
    </div>
</div>
@endif

@if(Gate::check('browse-mpc'))
<div class="container d-none" id="ListTab-4" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List MPC</h1>

    <!-- KHUSUS BWAT UI SEARCH -->
    <form class="search-form" action="{{ url()->current() }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <input class="form-control" type="text" name="keywordMpc" value="{{ app('request')->input('keywordMpc') }}" placeholder="Search...">
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
                    <th>REG DATE</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>PHONE</th>
                    <th>BRANCH</th>
                    <th>CSO</th>
                    <th style="display: none;">ADDRESS</th>
                    <th style="display: none;">PROVINCE</th>
                    <th style="display: none;">DISTRICT</th>
                    <th style="display: none;">COUNTRY</th>
                    <th style="display: none;">BIRTH DATE</th>
                    <th style="display: none;">KTP</th>
                    <th style="display: none;">GENDER</th>
                    <th style="display: none;">USER NAME</th>
                    <th style="text-align: center;" colspan="2">@if(Gate::check('edit-mpc'))EDIT @endif @if(Gate::check('delete-mpc'))/ DELETE @endif</th>
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($dataMpcs as $mpc)
                <tr>
                    <td>{{$mpc->registration_date}}</td>
                    <td>{{$mpc->code}}</td>
                    <td>{{$mpc->name}}</td>
                    <td>0{{$mpc->phone / 23}}</td>
                    <td>{{$mpc->branch['code']}}</td>
                    <td>{{$mpc->cso['name']}}</td>
                    <td style="display: none;">{{$mpc->address}}</td>
                    <td style="display: none;">{{$mpc->province}}</td>
                    <td style="display: none;">{{$mpc->district}}</td>
                    <td style="display: none;">{{$mpc->branch['country']}}</td>
                    <td style="display: none;">{{$mpc->birth_date}}</td>
                    <td style="display: none;">{{$mpc->ktp}}</td>
                    <td style="display: none;">{{$mpc->gender}}</td>
                    <td style="display: none;">{{$mpc->user['name']}}</td>
                    @if(Gate::check('edit-mpc'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-editMpc" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$mpc->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-mpc'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-deleteMpc" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$mpc->id}}">
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
    @foreach($dataMpcs as $mpc)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$mpc->code}} - {{$mpc->name}}<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">{{$mpc->branch['country']}} - {{$mpc->branch['code']}}<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Registration Date :</b> {{$mpc->registration_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>No. KTP :</b> {{$mpc->ktp}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Birth Date :</b> {{$mpc->birth_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Gender :</b> {{$mpc->gender}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Address :</b> {{$mpc->address}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Phone :</b> 0{{$mpc->phone / 23}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>CSO :</b> {{$mpc->cso['name']}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:10px;"><b>User Keyin :</b> {{$mpc->user['name']}}<br></p>
                @if(Gate::check('edit-mpc'))
                <button class="btn btn-primary btn-edithapus-card btn-editMpc" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$mpc->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-mpc'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteMpc" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$mpc->id}}">
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
        {{ $dataMpcs->links() }}
    </div>
</div>
@endif

@if(Gate::check('browse-data-undangan'))
<div class="container" id="ListTab-1" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List Data Undangan</h1>

    <!-- KHUSUS BWAT UI SEARCH -->
    <form class="search-form" action="{{ url()->current() }}">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <input class="form-control" type="text" name="keywordDataUndangan" value="{{ app('request')->input('keywordDataUndangan') }}" placeholder="Search...">
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
                    <th>REG DATE</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>PHONE</th>
                    <th style="display: none;">ADDRESS</th>
                    <th style="display: none;">BIRTH DATE</th>
                    <th style="text-align: center;" colspan="2">@if(Gate::check('edit-data-undangan'))EDIT @endif @if(Gate::check('delete-data-undangan'))/ DELETE @endif</th>
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($dataUndangans as $dataUndangan)
                <tr>
                    <td>{{$dataUndangan->registration_date}}</td>
                    <td>{{$dataUndangan->code}}</td>
                    <td>{{$dataUndangan->name}}</td>
                    <td>0{{$dataUndangan->phone / 23}}</td>
                    <td style="display: none;">{{$dataUndangan->address}}</td>
                    <td style="display: none;">{{$dataUndangan->birth_date}}</td>
                    @if(Gate::check('edit-data-undangan'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-editDataUndangan" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataUndangan->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-data-undangan'))
                    <td style="text-align: center;">
                        <button class="btn btn-primary btn-deleteDataUndangan" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataUndangan->id}}">
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
    @foreach($dataUndangans as $dataUndangan)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$dataUndangan->code}} - {{$dataUndangan->name}}<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Registration Date :</b> {{$dataUndangan->registration_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Birth Date :</b> {{$dataUndangan->birth_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Address :</b> {{$dataUndangan->address}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Phone :</b> 0{{$dataUndangan->phone / 23}}<br></p>
                @if(Gate::check('edit-data-undangan'))
                <button class="btn btn-primary btn-edithapus-card btn-editDataUndangan" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$dataUndangan->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-data-undangan'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteDataUndangan" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$dataUndangan->id}}">
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
        {{ $dataUndangans->links() }}
    </div>
</div>
@endif

<!--===========================================================-->


<!---------------- KHUSUS UNTUK EDIT DATA ---------------->

@if(Gate::check('edit-data-outsite'))
<div class="modal fade" role="dialog" tabindex="-1" id="modal-EditDataOutsite">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-center">Edit Data Out-Site</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- FORM UNTUK UPDATE DATA -->
            <form id="actionEditDataOutsite" name="frmEditDataOutsite" method="POST" action="{{ route('update_dataoutsite') }}">
                {{ csrf_field() }}

                <div class="modal-body">
                    <div class="form-group">
                        <span>CODE</span>
                        <input id="edit-txtcode-dataoutsite" type="text" name="code" class="text-uppercase form-control" readonly>
                    </div>
                    <div class="form-group">
                        <span>TIPE OUT-SITE</span>
                        <select id="edit-txttype-cust-dataoutsite" class="text-uppercase form-control" name="type_cust" value="" required>
                            <optgroup label="TIPE OUT-SITE"> 
                                <option value="" disabled selected>SELECT TIPE OUT-SITE</option>
                                @foreach ($type_custs as $type_cust)
                                    @if($type_cust->type_input == "OUT-SITE")
                                        <option value="{{$type_cust->id}}">{{$type_cust->name}}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input id="edit-txtreg-date-dataoutsite" type="date" name="registration_date" class="text-uppercase form-control" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input id="edit-txtname-dataoutsite" type="text" name="name" class="text-uppercase form-control" placeholder="NAME" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div id="edit-Outsite-Location" class="form-group">
                        
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select id="edit-txtcountry-dataoutsite" class="text-uppercase form-control" name="country" required>
                            <optgroup label="Country">
                                @include('etc.select-country')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>BRANCH</span>
                        <select id="edit-txtbranch-dataoutsite" class="text-uppercase form-control" name="branch" required>
                            <optgroup label="Branch">
                                @can('all-branch-data-outsite')
                                    @can('all-country-data-outsite')
                                        <option value="" disabled selected>SELECT COUNTRY FIRST</option>
                                    @endcan
                                    @cannot('all-country-data-outsite')
                                        <option value="" selected disabled>SELECT YOUR OPTION</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{$branch->id}}" {{($branch->id == Auth::user()->branch_id ? "selected" : "")}}>{{$branch->code}} - {{$branch->name}}</option>
                                        @endforeach
                                    @endcan
                                @endcan
                                @cannot('all-branch-data-outsite')
                                    <option value="{{Auth::user()->branch_id}}">{{Auth::user()->branch['name']}}</option>
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>


                    <!-- CSO -->
                    <div class="form-group">
                        <span>CSO</span>
                        <select id="edit-txtcso-dataoutsite" class="text-uppercase form-control" name="cso" required>
                            <optgroup label="Cso">
                                @can('all-branch-data-outsite')
                                    <option value="" disabled selected>SELECT BRANCH FIRST</option>
                                @endcan
                                @cannot('all-branch-data-outsite')
                                <option value="" selected disabled>SELECT YOUR OPTION</option>
                                    @foreach ($csos as $cso)
                                        @if($cso->branch_id == Auth::user()->branch_id)
                                            <option value="{{$cso->id}}">{{$cso->name}}</option>
                                        @endif
                                    @endforeach
                                @endcan
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <!-- Khusus untuk Indo untuk sementara -->
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select id="edit-txtprovince-dataoutsite" class="text-uppercase form-control" name="province" required>
                            <optgroup label="Province">
                                @include('etc.select-province')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>DISTRICT</span>
                        <select id="edit-txtdistrict-dataoutsite" class="form-control text-uppercase" name="district"required>
                            <optgroup label="District">
                                <option disabled selected>SELECT PROVINCE FIRST</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <span>PHONE</span>
                        <input id="edit-txtphone-dataoutsite" type="number" name="phone" class="form-control" placeholder="0XXXXXXXXXXX" required>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-confirmUpdateDataOutsite" value="-">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(Gate::check('edit-data-undangan'))
<div class="modal fade" role="dialog" tabindex="-1" id="modal-EditDataUndangan">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-center">Edit Data Undangan</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- FORM UNTUK UPDATE DATA -->
            <form id="actionEditDataUndangan" name="frmEditDataUndangan" method="POST" action="{{ route('update_dataundangan') }}">
                {{ csrf_field() }}

                
            </form>
        </div>
    </div>
</div>
@endif

<!--=======================================================================-->

<!----------------------- KHUSUS UNTUK DELETE DATA -------------------------->

@if(Gate::check('delete-data-outsite'))
<!-- <div class="modal fade" role="dialog" tabindex="-1" id="modal-DeleteConfirm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="txt-delete-dataoutsite"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <form id="actionDelete" action="{{route('delete_dataoutsite', ['id' => ''])}}" method="post">
                    {{csrf_field()}}
                    <button class="btn btn-danger" type="submit" id="btn-confirmDeleteDataOutsite" value="-">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div> -->
@endif

<!--=======================================================================-->

<!-- modal Find Data Undangan -->
<div class="modal fade" role="dialog" tabindex="-1" id="modal-DataUndangan">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Data Undangan Found</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Name</b> : Budi Santoso</p>
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Address</b> : Jl. Kelapa Muda 12</p>
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Phone</b> : 081544468999</p>
                <p class="card-text" style="font-weight: normal;font-size: 18px;margin-bottom: 3px;"><b>Birth Date</b> : 6-June-1966</p>

                <!-- untuk table data -->
                <div class="table-responsive table table-striped">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Exchange Date</th>
                                <th>Branch</th>
                            </tr>
                        </thead>
                        <tbody name="collection">
                            <tr>
                                <td>16-July-2018</td>
                                <td>(F02) Tim Basori</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- SCRIPT SECTION -->
@section('script')

@cannot('all-country-data-undangan')
<script type="text/javascript">
    $("#txtcountry-dataundangan > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

@cannot('all-country-data-outsite')
<script type="text/javascript">
    $("#txtcountry-dataoutsite > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

@cannot('all-country-data-therapy')
<script type="text/javascript">
    $("#txtcountry-datatherapy > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

@cannot('all-country-mpc')
<script type="text/javascript">
    $("#txtcountry-mpc > optgroup > option").each(function() {
        var $thisOption = $(this);
        if(this.value != "{{ Auth::user()->branch['country'] }}"){
            $thisOption.attr("disabled","disabled");
        }
        else{
            $thisOption.attr("selected","selected");
            
            var countryVal = "{{ Auth::user()->branch['country'] }}";
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }
    });
</script>
@endcan

<script type="text/javascript">
    //////////// KHUSUS UNTUK SCRIPT ONCLICK TAB//////
    function ShowList(id) {
        $("#ListTab-1").addClass("d-none");
        $("#ListTab-2").addClass("d-none");
        $("#ListTab-3").addClass("d-none");
        $("#ListTab-4").addClass("d-none");
        $("#ListTab-"+id).removeClass("d-none");
    }
    ///////////////////////////////////////////////////

    $(document).ready(function () {
        $('#modal-DataUndangan').modal('show');
        /*METHOD - METHOD UMUM ATAU KESELURUHAN
        * Khusus method" PENOPANG PADA HALAMAN INI
        */
        function _(el){
            return document.getElementById(el);
        };

        function addToDistrict(id, data, callback) {
            id.append(data);
            callback();
        };

        function RetriveSelectedBranch(var_country, var_branch, id_branch){
            id_branch = $(id_branch).children("optgroup").eq(0);
            branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': var_country
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            if(data[value].id == var_branch){
                                branches += '<option value="'+data[value].id+'" selected>'+data[value].code+' - '+data[value].name+'</option>';
                            }
                            else{
                                branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                            }
                        });
                        id_branch.html("");
                        id_branch.append(branches);
                    }
                    else
                    {
                        id_branch.html("");
                        id_branch.append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        }

        function RetriveSelectedCso(var_branch, var_cso, id_cso){
            id_cso = $(id_cso).children("optgroup").eq(0);
            csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': var_branch
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            if(data[value].id == var_cso){
                                csos += '<option value="'+data[value].id+'" selected>'+data[value].code+' - '+data[value].name+'</option>';
                            }
                            else{
                                csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                            }
                        });
                        id_cso.html("");
                        id_cso.append(csos);
                    }
                    else
                    {
                        id_cso.html("");
                        id_cso.append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        }

        //untuk refresh halaman ketika modal [SUCCESS Add] ditutup 
        $('#modal-Notification').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        // COUNTRY METHOD
        $('#txtcountry-dataundangan').change(function (e){
            var countryVal = $('#txtcountry-dataundangan').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataundangan").html("");
                        $("#txtbranch-dataundangan").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtcountry-dataoutsite').change(function (e){
            var countryVal = $('#txtcountry-dataoutsite').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-dataoutsite").html("");
                        $("#txtbranch-dataoutsite").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtcountry-datatherapy').change(function (e){
            var countryVal = $('#txtcountry-datatherapy').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-datatherapy").html("");
                        $("#txtbranch-datatherapy").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtcountry-mpc').change(function (e){
            var countryVal = $('#txtcountry-mpc').val();
            var branches = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-country')}}",
                data: {
                    'country': countryVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append(branches);
                    }
                    else
                    {
                        $("#txtbranch-mpc").html("");
                        $("#txtbranch-mpc").append("<option value=\"\" selected>BRANCH NOT FOUND</option>");
                    }
                },
            });
        });

        // BRANCH METHOD
        $('#txtbranch-dataundangan').change(function (e){
            var branchVal = $('#txtbranch-dataundangan').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-dataundangan").html("");
                        $("#txtcso-dataundangan").append(csos);
                    }
                    else
                    {
                        $("#txtcso-dataundangan").html("");
                        $("#txtcso-dataundangan").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtbranch-dataoutsite').change(function (e){
            var branchVal = $('#txtbranch-dataoutsite').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-dataoutsite").html("");
                        $("#txtcso-dataoutsite").append(csos);
                    }
                    else
                    {
                        $("#txtcso-dataoutsite").html("");
                        $("#txtcso-dataoutsite").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtbranch-datatherapy').change(function (e){
            var branchVal = $('#txtbranch-datatherapy').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-datatherapy").html("");
                        $("#txtcso-datatherapy").append(csos);
                    }
                    else
                    {
                        $("#txtcso-datatherapy").html("");
                        $("#txtcso-datatherapy").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });
        $('#txtbranch-mpc').change(function (e){
            var branchVal = $('#txtbranch-mpc').val();
            var csos = "<option value=\"\" selected disabled>SELECT YOUR OPTION</option>";

            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                type: 'post',
                url: "{{route('select-branch')}}",
                data: {
                    'branch_id': branchVal
                },
                success: function(data){
                    if(data.length > 0)
                    {
                        data.forEach(function(key, value){
                            csos += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                        });
                        $("#txtcso-mpc").html("");
                        $("#txtcso-mpc").append(csos);
                    }
                    else
                    {
                        $("#txtcso-mpc").html("");
                        $("#txtcso-mpc").append("<option value=\"\" selected>CSO NOT FOUND</option>");
                    }
                },
            });
        });

        // PROVINCE METHOD
        $('#txtprovince-dataundangan').change(function (e) {
            $("#txtdistrict-dataundangan > optgroup").html("");
            var provinceVal = $('#txtprovince-dataundangan').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-dataundangan > optgroup").append(data);
            });
        });
        $('#txtprovince-dataoutsite').change(function (e) {
            $("#txtdistrict-dataoutsite > optgroup").html("");
            var provinceVal = $('#txtprovince-dataoutsite').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-dataoutsite > optgroup").append(data);
            });
        });
        $('#txtprovince-datatherapy').change(function (e) {
            $("#txtdistrict-datatherapy > optgroup").html("");
            var provinceVal = $('#txtprovince-datatherapy').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-datatherapy > optgroup").append(data);
            });
        });
        $('#txtprovince-mpc').change(function (e) {
            $("#txtdistrict-mpc > optgroup").html("");
            var provinceVal = $('#txtprovince-mpc').val();
            $.get( "etc/select-"+unescape(provinceVal)+".php", function( data ) {
                $("#txtdistrict-mpc > optgroup").append(data);
            });
        });
        /*===================================================*/


        /*METHOD - METHOD DATA UNDANGAN
        * Khusus method" undangan dari awal sampai akhir
        */
        var frmAddUndangan;

        $('#btnFind-data-undangan').click(function(e){
            e.preventDefault();
        });

        $("#txttype-cust-dataundangan").change(function (e) {
            $("#input-DataUndangan").removeClass("d-none");
            if($('#txttype-cust-dataundangan option:selected').val() == 13){//undangan id 13
                $("#Undangan-Bank").html(
                    "<span>BANK NAME</span><input list=\"bank_list\" name=\"bank_name\" class=\"text-uppercase form-control\" placeholder=\"example. BCA, CIMB, etc.\" required=\"\"><datalist id=\"bank_list\"><span class=\"invalid-feedback\"><strong></strong></span>@foreach ($banks as $bank)<option value=\"{{$bank->name}}\">@endforeach</datalist>"
                );
            }
            else{
                $("#Undangan-Bank").html("");
            }
        });

        $(".btn-editDataUndangan").click(function(e) {
            

            $("#modal-EditDataUndangan").modal("show");
        });

        $("#actionAddDataUndangan").on("submit", function (e) {
            e.preventDefault();
            frmAddUndangan = _("actionAddDataUndangan");
            frmAddUndangan = new FormData(frmAddUndangan);
            var URLNya = $("#actionAddDataUndangan").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerUndangan, false);
            ajax.addEventListener("load", completeHandlerUndangan, false);
            ajax.addEventListener("error", errorHandlerUndangan, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddUndangan);
        });
        function progressHandlerUndangan(event){
            document.getElementById("btn-actionAddDataUndangan").innerHTML = "UPLOADING...";
        }
        function completeHandlerUndangan(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddUndangan.keys()) {
                $("#actionAddDataUndangan").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataUndangan").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataUndangan").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddDataUndangan").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataUndangan").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataUndangan").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddUndangan.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddDataUndangan").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataUndangan").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataUndangan").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddDataUndangan").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataUndangan").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataUndangan").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
                $('#modal-UpdateForm').modal('hide')
                $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">New Data Undangan has been ADDED successfully</div>");
                $("#modal-Notification").modal("show");
            }

            document.getElementById("btn-actionAddDataUndangan").innerHTML = "SAVE";
        }
        function errorHandlerUndangan(event){
            document.getElementById("btn-actionAddDataUndangan").innerHTML = "SAVE";
            $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-error\">"+event.target.responseText+"</div>");
            $("#modal-Notification").modal("show");
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
        }
        /*===================================================*/


        /*METHOD - METHOD DATA OUTSITE
        * Khusus method" outsite dari awal sampai akhir
        */
        var actionDeleteDataOutsite = $("#actionEditDataOutsite").prop('action');
        var actionEditDataOutsite = $("#actionEditDataOutsite").prop('action');
        var frmAddOutsite;
        var frmEditOutsite;
        var isAddDataOutsite = true;
        var tempLocation = "";

        $('#btnFind-data-outsite').click(function(e){
            e.preventDefault();
        });

        $("#txttype-cust-dataoutsite, #edit-txttype-cust-dataoutsite").change(function (e) {
            var LocationDOM = "edit-Outsite-Location";
            var LocationNya = tempLocation;
            if(this.id == "txttype-cust-dataoutsite"){
                $("#input-DataOutsite").removeClass("d-none");
                LocationDOM = "Outsite-Location";
                LocationNya = "";
            }
            if($('#'+this.id+' option:selected').val() == 2 || $('#'+this.id+' option:selected').val() == 4){//Ms. Rumah id 2 dan CFD id 4
                $("#"+LocationDOM).html(
                    "<span>LOCATION NAME</span><input list=\"location_list\" name=\"location_name\" class=\"text-uppercase form-control\" placeholder=\"example. CITRALAND, PAKUWON, etc.\" required=\"\"><datalist id=\"location_list\"><span class=\"invalid-feedback\"><strong></strong></span>@foreach ($locations as $location)<option value=\"{{$location->name}}\">@endforeach</datalist>"
                );
                $("#"+LocationDOM+" > input").val(LocationNya);
            }
            else{
                $("#"+LocationDOM).html("");
            }
        });

        //untuk menampilkan modal edit data OUTSITE dan menampilkan data mana yg mau di edit
        $(".btn-editDataOutsite").click(function(e) {
            var dataOutsite = GetListDataOutsite(this.name);
            document.getElementById("edit-txtreg-date-dataoutsite").value = dataOutsite.reg_date;
            document.getElementById("edit-txtcode-dataoutsite").value = dataOutsite.kode;
            document.getElementById("edit-txtname-dataoutsite").value = dataOutsite.nama;
            document.getElementById("edit-txtcountry-dataoutsite").value = dataOutsite.country;
            document.getElementById("edit-txtprovince-dataoutsite").value = dataOutsite.province;
            document.getElementById("edit-txtphone-dataoutsite").value = dataOutsite.phone;
            document.getElementById("edit-txttype-cust-dataoutsite").value = dataOutsite.typecust;
            document.getElementById("btn-confirmUpdateDataOutsite").value = this.value;
            tempLocation = dataOutsite.location;

            var pilihanProvinsi = dataOutsite.province;
            var pilihanCso = dataOutsite.cso;
            var pilihanBranch = dataOutsite.branch;
            var isiOption = "";

            //UPDATE DISTRICT
            var districtTemp = $("#edit-txtdistrict-dataoutsite").children("optgroup").eq(0);
            districtTemp.empty();
            $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
                addToDistrict(districtTemp, data, function(){
                    document.getElementById("edit-txtdistrict-dataoutsite").value = dataOutsite.district;
                });
            });

            //UPDATE BRANCH & CSO
            RetriveSelectedBranch(dataOutsite.country, dataOutsite.branch, "#edit-txtbranch-dataoutsite");
            RetriveSelectedCso(dataOutsite.branch, dataOutsite.cso, "#edit-txtcso-dataoutsite");

            //CEK ADA LOKASI APA TIDAK
            $("#edit-Outsite-Location").html("");
            if(dataOutsite.location != " - "){
                $("#edit-Outsite-Location").html(
                    "<span>LOCATION NAME</span><input list=\"location_list\" name=\"location_name\" class=\"text-uppercase form-control\" placeholder=\"example. CITRALAND, PAKUWON, etc.\" required=\"\"><datalist id=\"edit-location_list\"><span class=\"invalid-feedback\"><strong></strong></span>@foreach ($locations as $location)<option value=\"{{$location->name}}\">@endforeach</datalist>"
                );
                $("#edit-Outsite-Location > input").val(dataOutsite.location);
            }

            $("#modal-EditDataOutsite").modal("show");
        });

        $("#actionAddDataOutsite").on("submit", function (e) {
            e.preventDefault();
            frmAddOutsite = _("actionAddDataOutsite");
            frmAddOutsite = new FormData(frmAddOutsite);
            var URLNya = $("#actionAddDataOutsite").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerOutsite, false);
            ajax.addEventListener("load", completeHandlerOutsite, false);
            ajax.addEventListener("error", errorHandlerOutsite, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddOutsite);
        });

        $("#actionEditDataOutsite").on("submit", function (e) {
            e.preventDefault();
            isAddDataOutsite = false;
            frmEditOutsite = _("actionEditDataOutsite");
            frmEditOutsite = new FormData(frmEditOutsite);
            frmEditOutsite.append("id",$(this).find("button").eq(1).val());
            var URLNya = $("#actionEditDataOutsite").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerOutsite, false);
            ajax.addEventListener("load", completeHandlerOutsite, false);
            ajax.addEventListener("error", errorHandlerOutsite, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmEditOutsite);
        });
        
        function progressHandlerOutsite(event){
            if(isAddDataOutsite){
                document.getElementById("btn-actionAddDataOutsite").innerHTML = "UPLOADING...";
            }
            else{
                document.getElementById("btn-confirmUpdateDataOutsite").innerHTML = "UPLOADING...";
            }
        }
        function completeHandlerOutsite(event){
            var hasil = JSON.parse(event.target.responseText);

            if(isAddDataOutsite){
                for (var key of frmAddOutsite.keys()) {
                    $("#actionAddDataOutsite").find("input[name="+key+"]").removeClass("is-invalid");
                    $("#actionAddDataOutsite").find("select[name="+key+"]").removeClass("is-invalid");
                    $("#actionAddDataOutsite").find("textarea[name="+key+"]").removeClass("is-invalid");

                    $("#actionAddDataOutsite").find("input[name="+key+"]").next().find("strong").text("");
                    $("#actionAddDataOutsite").find("select[name="+key+"]").next().find("strong").text("");
                    $("#actionAddDataOutsite").find("textarea[name="+key+"]").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of frmAddOutsite.keys()) {
                        if(typeof hasil['errors'][key] === 'undefined') {
                            
                        }
                        else {
                            $("#actionAddDataOutsite").find("input[name="+key+"]").addClass("is-invalid");
                            $("#actionAddDataOutsite").find("select[name="+key+"]").addClass("is-invalid");
                            $("#actionAddDataOutsite").find("textarea[name="+key+"]").addClass("is-invalid");

                            $("#actionAddDataOutsite").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                            $("#actionAddDataOutsite").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                            $("#actionAddDataOutsite").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                }
                else{
                    // $('#modal-UpdateForm').modal('hide')
                    // $("#modal-NotificationUpdate").modal("show");
                    $('#modal-UpdateForm').modal('hide')
                    $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">New Data Out-Site has been ADDED successfully</div>");
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-actionAddDataOutsite").innerHTML = "SAVE";
            }
            else{
                for (var key of frmEditOutsite.keys()) {
                    $("#actionEditDataOutsite").find("input[name="+key+"]").removeClass("is-invalid");
                    $("#actionEditDataOutsite").find("select[name="+key+"]").removeClass("is-invalid");
                    $("#actionEditDataOutsite").find("textarea[name="+key+"]").removeClass("is-invalid");

                    $("#actionEditDataOutsite").find("input[name="+key+"]").next().find("strong").text("");
                    $("#actionEditDataOutsite").find("select[name="+key+"]").next().find("strong").text("");
                    $("#actionEditDataOutsite").find("textarea[name="+key+"]").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of frmEditOutsite.keys()) {
                        if(typeof hasil['errors'][key] === 'undefined') {
                            
                        }
                        else {
                            $("#actionEditDataOutsite").find("input[name="+key+"]").addClass("is-invalid");
                            $("#actionEditDataOutsite").find("select[name="+key+"]").addClass("is-invalid");
                            $("#actionEditDataOutsite").find("textarea[name="+key+"]").addClass("is-invalid");

                            $("#actionEditDataOutsite").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                            $("#actionEditDataOutsite").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                            $("#actionEditDataOutsite").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                }
                else{
                    // $('#modal-UpdateForm').modal('hide')
                    // $("#modal-NotificationUpdate").modal("show");
                    $('#modal-UpdateForm').modal('hide')
                    $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">New Data Out-Site has been ADDED successfully</div>");
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmUpdateDataOutsite").innerHTML = "SAVE";
            }
        }
        function errorHandlerOutsite(event){
            if(isAddDataOutsite){
                document.getElementById("btn-actionAddDataOutsite").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-error\">"+event.target.responseText+"</div>");
                $("#modal-Notification").modal("show");
            }
            else{
                document.getElementById("btn-confirmUpdateDataOutsite").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-error\">"+event.target.responseText+"</div>");
                $("#modal-Notification").modal("show");
            }
        }
        /*===================================================*/


        /*METHOD - METHOD DATA THERAPY
        * Khusus method" therapy dari awal sampai akhir
        */
        var frmAddTherapy;

        $('#btnFind-data-therapy').click(function(e){
            e.preventDefault();
        });

        $("#actionAddDataTherapy").on("submit", function (e) {
            e.preventDefault();
            frmAddTherapy = _("actionAddDataTherapy");
            frmAddTherapy = new FormData(frmAddTherapy);
            var URLNya = $("#actionAddDataTherapy").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerTherapy, false);
            ajax.addEventListener("load", completeHandlerTherapy, false);
            ajax.addEventListener("error", errorHandlerTherapy, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddTherapy);
        });
        function progressHandlerTherapy(event){
            document.getElementById("btn-actionAddDataTherapy").innerHTML = "UPLOADING...";
        }
        function completeHandlerTherapy(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddTherapy.keys()) {
                $("#actionAddDataTherapy").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataTherapy").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddDataTherapy").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddDataTherapy").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataTherapy").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddDataTherapy").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddTherapy.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddDataTherapy").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataTherapy").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddDataTherapy").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddDataTherapy").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataTherapy").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddDataTherapy").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
                $('#modal-UpdateForm').modal('hide')
                $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">New Data Therapy has been ADDED successfully</div>");
                $("#modal-Notification").modal("show");
            }

            document.getElementById("btn-actionAddDataTherapy").innerHTML = "SAVE";
        }
        function errorHandlerTherapy(event){
            document.getElementById("btn-actionAddDataTherapy").innerHTML = "SAVE";
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
            $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-error\">"+event.target.responseText+"</div>");
            $("#modal-Notification").modal("show");
        }
        /*===================================================*/


        /*METHOD - METHOD MPC
        * Khusus method" mpc dari awal sampai akhir
        */
        var frmAddMpc;

        $('#btnFind-mpc').click(function(e){
            e.preventDefault();
        });

        $("#actionAddMpc").on("submit", function (e) {
            e.preventDefault();
            frmAddMpc = _("actionAddMpc");
            frmAddMpc = new FormData(frmAddMpc);
            var URLNya = $("#actionAddMpc").attr('action');

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandlerMpc, false);
            ajax.addEventListener("load", completeHandlerMpc, false);
            ajax.addEventListener("error", errorHandlerMpc, false);
            ajax.open("POST", URLNya);
            ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
            ajax.send(frmAddMpc);
        });
        function progressHandlerMpc(event){
            document.getElementById("btn-actionAddMpc").innerHTML = "UPLOADING...";
        }
        function completeHandlerMpc(event){
            var hasil = JSON.parse(event.target.responseText);

            for (var key of frmAddMpc.keys()) {
                $("#actionAddMpc").find("input[name="+key+"]").removeClass("is-invalid");
                $("#actionAddMpc").find("select[name="+key+"]").removeClass("is-invalid");
                $("#actionAddMpc").find("textarea[name="+key+"]").removeClass("is-invalid");

                $("#actionAddMpc").find("input[name="+key+"]").next().find("strong").text("");
                $("#actionAddMpc").find("select[name="+key+"]").next().find("strong").text("");
                $("#actionAddMpc").find("textarea[name="+key+"]").next().find("strong").text("");
            }

            if(hasil['errors'] != null){
                for (var key of frmAddMpc.keys()) {
                    if(typeof hasil['errors'][key] === 'undefined') {
                        
                    }
                    else {
                        $("#actionAddMpc").find("input[name="+key+"]").addClass("is-invalid");
                        $("#actionAddMpc").find("select[name="+key+"]").addClass("is-invalid");
                        $("#actionAddMpc").find("textarea[name="+key+"]").addClass("is-invalid");

                        $("#actionAddMpc").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddMpc").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        $("#actionAddMpc").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                    }
                }
            }
            else{
                // $('#modal-UpdateForm').modal('hide')
                // $("#modal-NotificationUpdate").modal("show");
                $('#modal-UpdateForm').modal('hide')
                $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">New MPC has been ADDED successfully</div>");
                $("#modal-Notification").modal("show");
            }

            document.getElementById("btn-actionAddMpc").innerHTML = "SAVE";
        }
        function errorHandlerMpc(event){
            document.getElementById("btn-actionAddMpc").innerHTML = "SAVE";
            // $("#txt-notification > div").html(event.target.responseText);
            // $('#modal-UpdateForm').modal('hide')
            // $("#modal-NotificationUpdate").modal("show");
            $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-error\">"+event.target.responseText+"</div>");
            $("#modal-Notification").modal("show");
        }
        /*===================================================*/
    });
</script>
@endsection
