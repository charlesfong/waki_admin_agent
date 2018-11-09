<?php use App\Http\Controllers\CsoController; ?>

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
    <li class="list-selected">Master CSO</li>
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
    <!-- FORM UNTUK DATA BARU -->
    <form id="actionAdd" method="POST" action="{{ route('store_cso') }}">
        {{ csrf_field() }}

        <h1 class="text-center">Add CSO</h1>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <span>REGISTRATION DATE</span>
            <input type="date" name="registration_date" class="text-uppercase form-control {{ $errors->has('registration_date') ? ' is-invalid' : '' }}" value="{{ old('registration_date') }}" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('registration_date') }}</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('unregistration_date') ? ' has-error' : '' }}">
            <span>UNREGISTRATION DATE</span>
            <input type="date" name="unregistration_date" class="text-uppercase form-control {{ $errors->has('unregistration_date') ? ' is-invalid' : '' }}" value="{{ old('unregistration_date') }}" >
            <span class="invalid-feedback">
                <strong>{{ $errors->first('unregistration_date') }}</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <span>NAME</span>
            <input type="text" name="name" class="text-uppercase form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Full Name"  value="{{ old('name') }}" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
            <span>ADDRESS</span>
            <textarea name="address" class="text-uppercase form-control {{ $errors->has('address') ? ' is-invalid' : '' }} form-control-sm" placeholder="Address" required>{{ old('address') }}</textarea>
            @if ($errors->has('address'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group frm-group-select {{ $errors->has('country') ? ' has-error' : '' }}">
            <span>COUNTRY</span>
            <select id="country" class="text-uppercase form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old('country') }}" required>
                <optgroup label="Country">
                    @can('all-country-cso')
                    @include('etc.select-country')
                    @endcan
                    @cannot('all-country-cso')
                    <option value="{{Auth::user()->country}}">{{Auth::user()->country}}</option>
                    @endcan
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
        <div class="form-group frm-group-select {{ $errors->has('province') ? ' has-error' : '' }}">
            <span>PROVINCE</span>
            <select id="province" class="text-uppercase form-control{{ $errors->has('province') ? ' is-invalid' : '' }}" name="province" value="{{ old('province') }}" required>
                <optgroup label="Province">
                    @include('etc.select-province')
                </optgroup>
            </select>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('province') }}</strong>
            </span>
        </div>
        <div class="form-group frm-group-select select-right {{ $errors->has('district') ? ' has-error' : '' }}" style="/*float:right;*/">
            <span>DISTRICT</span>
            <select id="district" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }} text-uppercase" name="district" value="{{old('district')}}" required>
                <optgroup label="District">
                    <option value="" disabled selected>SELECT PROVINCE FIRST</option>
                </optgroup>
            </select>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('district') }}</strong>
            </span>
        </div>
        <div class="form-group frm-group-select {{ $errors->has('phone') ? ' has-error' : '' }}">
            <span>PHONE</span>
            <input type="number" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="0XXXXXXXXXXXX" value="{{ old('phone') }}" onkeypress="return isNumberKey(event)" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        </div>
        <div class="form-group frm-group-select select-right {{ $errors->has('komisi') ? ' has-error' : '' }}">
            <span>COMMISSION</span>
            <input type="number" step="0.01" name="komisi" class="form-control {{ $errors->has('komisi') ? ' is-invalid' : '' }}" placeholder="0.00" value="{{ old('komisi') }}" onkeypress="return isNumberKey(event)">
            <span class="invalid-feedback">
                <strong>{{ $errors->first('komisi') }}</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('no_rekening') ? ' has-error' : '' }}">
            <span>BANK ACCOUNT</span>
            <input type="number" name="no_rekening" class="text-uppercase form-control {{ $errors->has('no_rekening') ? ' is-invalid' : '' }}" value="{{ old('no_rekening') }}" placeholder="Bank Account">
            <span class="invalid-feedback">
                <strong>{{ $errors->first('no_rekening') }}</strong>
            </span>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit" id="btn-confirmAddCso">SAVE</button>
        </div>
    </form>
</div>
@can('browse-cso')
<div class="container" id="list-member" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List CSO</h1>

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
                    <th>REG DATE</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th style="display: none;">ADDRESS</th>
                    <th style="display: none;">PROVINCE</th>
                    <th>DISTRICT</th>
                    <th style="display: none;">COUNTRY</th>
                    <th>BRANCH</th>
                    <th>PHONE</th>
                    <th>COMMISSION</th>
                    <th>BANK ACCOUNT</th>
                    <th style="display: none;">UNREG DATE</th>
                    @if(Gate::check('edit-cso') || Gate::check('delete-cso'))
                    <th colspan="2">EDIT/DELETE</th>
                    @endif
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($csos as $cso)
                <tr>
                    <td>{{$cso->registration_date}}</td>
                    <td>{{$cso->code}}</td>
                    <td>{{$cso->name}}</td>
                    <td style="display: none;">{{$cso->address}}</td>
                    <td style="display: none;">{{$cso->province}}</td>
                    <td>{{$cso->district}}</td>
                    <td style="display: none;">{{$cso->branch['country']}}</td>
                    <td>{{$cso->branch['name']}}</td>
                    @if($cso->phone == "")
                        <td>-</td>
                    @else
                        <td>{{CsoController::Decr($cso->phone)}}</td>
                    @endif
                    <td>{{$cso->komisi}}</td>
                    <td>{{$cso->no_rekening}}</td>
                    <td style="display: none;">{{$cso->unregistration_date}}</td>
                    @if(Gate::check('edit-cso'))
                    <td>
                        <button class="btn btn-primary btn-editCso" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$cso->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-cso'))
                    <td>
                        <button class="btn btn-primary btn-deleteCso" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$cso->id}}">
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
    @foreach($csos as $cso)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$cso->code}} - {{$cso->name}}<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">{{$cso->branch['country']}} - {{$cso->branch['name']}}<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Registration Date :</b> {{$cso->registration_date}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Phone :</b>
                    @if($cso->phone == "")
                        -
                    @else
                        {{CsoController::Decr($cso->phone)}}
                    @endif
                    <br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Commission :</b> {{$cso->komisi}}<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:10px;"><b>Bank Account :</b> {{$cso->no_rekening}}<br></p>
                @if(Gate::check('edit-cso'))
                <button class="btn btn-primary btn-edithapus-card btn-editCso" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$cso->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-cso'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteCso" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$cso->id}}">
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
        {{ $csos->links() }}
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
                <p id="txt-delete-cso"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <form id="actionDelete" action="{{route('delete_cso', ['id' => ''])}}" method="post">
                    {{csrf_field()}}
                    <button class="btn btn-danger" type="submit" id="btn-confirmDeleteCso" value="-">Delete</button>
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
                <h2 class="text-center">Edit CSO</h2>
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
                        <input class="text-uppercase form-control" type="text" name="code" readonly placeholder="CODE" id="txtkode-cso">
                    </div>
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input class="text-uppercase form-control" type="date" name="registration_date" id="txtregdate-cso">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>UNREGISTRATION DATE</span>
                        <input class="text-uppercase form-control" type="date" name="unregistration_date" id="txtunregdate-cso">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NAME</span>
                        <input class="text-uppercase form-control" type="text" name="name" placeholder="Full Name" id="txtnama-cso">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>ADDRESS</span>
                        <textarea name="address" class="text-uppercase form-control form-control-sm" id="txtaddress-cso"></textarea>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select class="text-uppercase form-control" value="-" id="txtcountry-cso" name="country">
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
                        <select class="text-uppercase form-control" id="txtbranch-cso" name="branch">
                            <optgroup label="Branch">
                                <option value="" disabled="disabled" selected="selected">Select COUNTRY first1</option>
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('branch') }}</strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select class="text-uppercase form-control" id="txtprovince-cso" name="province">
                            <optgroup label="Province">
                                @include('etc.select-province')
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('province') }}</strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select select-right" style="/*float:right;*/">
                        <span>DISTRICT</span>
                        <select class="text-uppercase form-control" id="txtdistrict-cso" name="district">
                            <optgroup label="District">
                            </optgroup>
                        </select>
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('district') }}</strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select">
                        <span>PHONE</span>
                        <input class="form-control" type="number" id="txtphone-cso" name="phone" onkeypress="return isNumberKey(event)">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COMMISSION</span>
                        <input class="form-control" type="number" step="0.01" id="txtkomisi-cso" name="komisi" onkeypress="return isNumberKey(event)">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>BANK ACCOUNT</span>
                        <input class="form-control text-uppercase" type="number" id="txtnorekening-cso" name="no_rekening" placeholder="Bank Account">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-confirmUpdateCso" value="-">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        function _(el){
            return document.getElementById(el);
        }

        //untuk refresh halaman ketika modal [SUCCESS Update] ditutup 
        $('#modal-NotificationUpdate').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        //untuk refresh halaman ketika modal [SUCCESS Add] ditutup 
        $('#modal-Notification').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        //-- Add CSO --//
            var formAdd;
            $('#btn-confirmAddCso').click(function(e){
                e.preventDefault();

                formAdd = _("actionAdd");
                formAdd = new FormData(formAdd);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerAdd, false);
                ajax.addEventListener("load", completeHandlerAdd, false);
                ajax.addEventListener("error", errorHandlerAdd, false);
                ajax.addEventListener("abort", abortHandlerAdd, false);
                ajax.open("POST", "{{ route('store_cso') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formAdd);
            });
            function progressHandlerAdd(event){
                document.getElementById("btn-confirmAddCso").innerHTML = "Uploading...";
            }
            function completeHandlerAdd(event){
                var hasil = JSON.parse(event.target.responseText);
                var formDOM = _("actionAdd");

                for (var key of formAdd.keys()) {
                    $("#actionAdd").find("input[name="+key+"]").removeClass("is-invalid");
                    $("#actionAdd").find("select[name="+key+"]").removeClass("is-invalid");
                    $("#actionEdit").find("textarea[name="+key+"]").removeClass("is-invalid");

                    $("#actionAdd").find("input[name="+key+"]").next().find("strong").text("");
                    $("#actionAdd").find("select[name="+key+"]").next().find("strong").text("");
                    $("#actionEdit").find("textarea[name="+key+"]").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of formAdd.keys()) {
                        // console.log(key);
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

                document.getElementById("btn-confirmAddCso").innerHTML = "SAVE";
            }
            function errorHandlerAdd(event){
                document.getElementById("btn-confirmAddCso").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerAdd(event){
            }

        //-- Edit CSO --//
            var formEdit;
            $('#btn-confirmUpdateCso').click(function(e){
                e.preventDefault();

                formEdit = _("actionEdit");
                formEdit = new FormData(formEdit);
                formEdit.append("id", this.value);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerEdit, false);
                ajax.addEventListener("load", completeHandlerEdit, false);
                ajax.addEventListener("error", errorHandlerEdit, false);
                ajax.addEventListener("abort", abortHandlerEdit, false);
                ajax.open("POST", "{{ route('update_cso') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formEdit);
            });
            function progressHandlerEdit(event){
                document.getElementById("btn-confirmUpdateCso").innerHTML = "Uploading...";
            }
            function completeHandlerEdit(event){
                var hasil = JSON.parse(event.target.responseText);
                var formDOM = _("actionEdit");

                for (var key of formEdit.keys()) {
                    $("#actionEdit").find("input[name^='"+key+"']").removeClass("is-invalid");
                    $("#actionEdit").find("select[name^='"+key+"']").removeClass("is-invalid");
                    $("#actionEdit").find("textarea[name="+key+"]").removeClass("is-invalid");

                    $("#actionEdit").find("input[name^='"+key+"']").next().find("strong").text("");
                    $("#actionEdit").find("select[name^='"+key+"']").next().find("strong").text("");
                    $("#actionEdit").find("textarea[name="+key+"]").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of formEdit.keys()) {
                        if(typeof hasil['errors'][key] === 'undefined') {

                        }
                        else
                        {
                            $("#actionEdit").find("input[name^='"+key+"']").addClass("is-invalid");
                            $("#actionEdit").find("select[name^='"+key+"']").addClass("is-invalid");
                            $("#actionEdit").find("textarea[name="+key+"]").addClass("is-invalid");

                            $("#actionEdit").find("input[name^='"+key+"']").next().find("strong").text(hasil['errors'][key]);
                            $("#actionEdit").find("select[name^='"+key+"']").next().find("strong").text(hasil['errors'][key]);
                            $("#actionEdit").find("textarea[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                    //Jika ada error, scroll langsung menuju error
                    var elmnt = document.getElementsByClassName("is-invalid");
                    elmnt[0].scrollIntoView();
                }
                else{
                    $('#modal-UpdateForm').modal('hide');
                    // $("#modal-NotificationUpdate").modal("show");
                    $("#modal-Notification").find("p#txt-notification").html("<div class=\"alert alert-success\">Data has been CHANGED successfully</div>");
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmUpdateCso").innerHTML = "SAVE";
            }
            function errorHandlerEdit(event){
                document.getElementById("btn-confirmUpdateCso").innerHTML = "SAVE";
                $("#txt-notification > div").html(event.target.responseText);
                $('#modal-UpdateForm').modal('hide');
                // $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-NotificationUpdate").modal("show");
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
    $("#txtcountry-cso").change(function () {
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
                    $("#txtbranch-cso").html("");
                    $("#txtbranch-cso").append(branches);
                }
                else
                {
                    $("#txtbranch-user").html("");
                    $("#txtbranch-user").append("<option value=\"\" readonly selected>BRANCH NOT FOUND</option>");
                }
            },
        });
    });

    //The Branch field is selected based on what CSO has, when Edit Button clicked
    $(".btn-editCso").click(function(e) {
        var dataCso = GetListCsoData(this.name);
        var countryName = dataCso.country;
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
                    branches += '<option value="'+data[value].id+'">'+data[value].code+' - '+data[value].name+'</option>';
                });
                $("#txtbranch-cso").children("optgroup").eq(0).html("");
                $("#txtbranch-cso").children("optgroup").eq(0).append(branches);
                $("#txtbranch-cso").children("optgroup").eq(0).children("option:contains('"+dataCso.branch+"')").attr("selected", "selected");

                var idSelectedBranch = $("#txtbranch-cso").val();
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