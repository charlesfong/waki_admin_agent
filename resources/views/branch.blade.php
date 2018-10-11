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
    <li class="list-selected">Master Branch</li>
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
    <!-- FORM UNTUK DATA BARU -->
    <form id="actionAdd" method="POST" action="{{ route('store_branch') }}">
        {{ csrf_field() }}

        <h1 class="text-center">Add Branch</h1>
        <div class="form-group {{ $errors->has('code') ? ' has-error' : '' }}">
            <span>CODE</span>
            <input id="code" type="text" name="code" class="text-uppercase form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="CODE" required>
            <span class="invalid-feedback">
                <strong>The code has already been taken.</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <span>NAME</span>
            <input type="text" name="name" class="text-uppercase form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Branch Name" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        </div>
        <div class="form-group frm-group-select {{ $errors->has('country') ? ' has-error' : '' }}">
            <span>COUNTRY</span>
            <select id="country" class="text-uppercase form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old('country') }}" required>
                <optgroup label="Country">
                    @can('all-country-branch')
                        @include('etc.select-country')
                    @endcan
                    @cannot('all-country-branch')
                        <option value="{{Auth::user()->country}}">{{Auth::user()->country}}</option>
                    @endcan
                </optgroup>
            </select>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit" id="btn-confirmAddBranch">SAVE</button>
        </div>
    </form>
</div>

@can('browse-branch')
<div class="container" id="list-member" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List Branch</h1>

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
                    <th>KODE</th>
                    <th>NAME</th>
                    <th>COUNTRY</th>
                    @if(Gate::check('edit-branch') || Gate::check('delete-branch'))
                    <th colspan="2">EDIT/DELETE</th>
                    @endif
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($branches as $branch)
                <tr>
                    <td>{{$branch->code}}</td>
                    <td>{{$branch->name}}</td>
                    <td>{{$branch->country}}</td>
                    @if(Gate::check('edit-branch'))
                    <td>
                        <button class="btn btn-primary btn-editBranch" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$branch->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-branch'))
                    <td>
                        <button class="btn btn-primary btn-deleteBranch" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$branch->id}}">
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
    @foreach($branches as $branch)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$branch->code}} - {{$branch->name}}<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">{{$branch->country}}
                @if(Gate::check('edit-branch'))
                <button class="btn btn-primary btn-edithapus-card btn-editBranch" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$branch->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-branch'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteBranch" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$branch->id}}">
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
        {{ $branches->links() }}
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
                <p id="txt-delete-branch"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <form id="actionDelete" action="{{route('delete_branch', ['id' => ''])}}" method="post">
                    {{csrf_field()}}
                    <button class="btn btn-danger" type="submit" id="btn-confirmDeleteBranch" value="-">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal update data -->
<div class="modal fade" role="dialog" tabindex="-1" id="modal-UpdateForm">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-center">Edit Branch</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- FORM UNTUK UPDATE DATA -->
            <form id="actionEdit" method="post" action="{{ route('update_branch') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                        <div class="form-group">
                            <span>CODE</span>
                            <input class="form-control text-uppercase" type="text" name="code" readonly="" required="" placeholder="Code" id="txtkode-branch">
                        </div>
                        <div class="form-group">
                            <span>NAME</span>
                            <input class="form-control text-uppercase" type="text" name="name" required="" placeholder="Name" autofocus="" id="txtnama-branch">
                        </div>
                        <div class="form-group frm-group-select">
                            <span>COUNTRY</span>
                            <select name="country" class="text-uppercase form-control" id="txtcountry-branch">
                                <optgroup label="Country">
                                    @include('etc.select-country')
                                </optgroup>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-confirmUpdateBranch" value="-">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        //untuk refresh halaman ketika modal [SUCCESS Update] ditutup 
        $('#modal-NotificationUpdate').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        //untuk refresh halaman ketika modal [SUCCESS Add] ditutup 
        $('#modal-Notification').on('hidden.bs.modal', function() { 
            location.reload(); 
        });

        //-- Add Branch --//
            var formAdd;
            function _(el){
                return document.getElementById(el);
            }
            $('#btn-confirmAddBranch').click(function(e){
                e.preventDefault();

                formAdd = _("actionAdd");
                formAdd = new FormData(formAdd);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerAdd, false);
                ajax.addEventListener("load", completeHandlerAdd, false);
                ajax.addEventListener("error", errorHandlerAdd, false);
                ajax.addEventListener("abort", abortHandlerAdd, false);
                ajax.open("POST", "{{ route('store_branch') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formAdd);
            });
            function progressHandlerAdd(event){
                document.getElementById("btn-confirmAddBranch").innerHTML = "Uploading...";
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
                    $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmAddBranch").innerHTML = "SAVE";
            }
            function errorHandlerAdd(event){
                document.getElementById("btn-confirmAddBranch").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerAdd(event){
            }

        //-- Edit Branch --//
            var formEdit;
            function _(el){
                return document.getElementById(el);
            }

            $('#btn-confirmUpdateBranch').click(function(e){
                e.preventDefault();

                formEdit = _("actionEdit");
                formEdit = new FormData(formEdit);
                formEdit.append("id", this.value);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerEdit, false);
                ajax.addEventListener("load", completeHandlerEdit, false);
                ajax.addEventListener("error", errorHandlerEdit, false);
                ajax.addEventListener("abort", abortHandlerEdit, false);
                ajax.open("POST", "{{ route('update_branch') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formEdit);
            });
            function progressHandlerEdit(event){
                document.getElementById("btn-confirmUpdateBranch").innerHTML = "Uploading...";
            }
            function completeHandlerEdit(event){
                var hasil = JSON.parse(event.target.responseText);
                var formDOM = _("actionEdit");

                for (var key of formEdit.keys()) {
                    $("#actionEdit").find("input[name="+key+"]").removeClass("is-invalid");
                    $("#actionEdit").find("select[name="+key+"]").removeClass("is-invalid");

                    $("#actionEdit").find("input[name="+key+"]").next().find("strong").text("");
                    $("#actionEdit").find("select[name="+key+"]").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of formEdit.keys()) {
                        if(typeof hasil['errors'][key] === 'undefined') {

                        }
                        else
                        {
                            $("#actionEdit").find("input[name="+key+"]").addClass("is-invalid");
                            $("#actionEdit").find("select[name="+key+"]").addClass("is-invalid");

                            $("#actionEdit").find("input[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                            $("#actionEdit").find("select[name="+key+"]").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                }
                else{
                    $('#modal-UpdateForm').modal('hide')
                    $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmUpdateBranch").innerHTML = "SAVE";
            }
            function errorHandlerEdit(event){
                document.getElementById("btn-confirmUpdateBranch").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerEdit(event){
            }
    });

    //Pengecekan KODE branch pada FORM NEW BRANCH
    //Ketika focusout dari input field 'code'
    //Maka akan diperiksa apakah terdapat kode yang sama
    $('#code').focusout(function(){
        var code = $('#code').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('check-branch-code')}}",
            data: {
                'code': code,
            },
            success: function(data){
                if(data == "success")
                {
                    $("#code").removeClass("is-invalid");
                }
                else
                {
                    $("#code").addClass("is-invalid");
                }
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