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
    <li class="list-selected">Master Data Type</li>
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
    <!-- FORM UNTUK DATA BARU -->
    <form id="actionAdd" method="POST" action="{{ route('store_type_cust') }}">
        {{ csrf_field() }}

        <h1 class="text-center">Add Data Type</h1>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <span>NAME</span>
            <input type="text" name="name" class="text-uppercase form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Data Type Name" required>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        </div>
        <div class="form-group {{ $errors->has('type_input') ? ' has-error' : '' }}">
            <span>TYPE INPUT</span>
            <div class="div-CheckboxGroup">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="undangan" name="type_input[undangan]" required>
                    <label class="form-check-label" for="undangan">UNDANGAN</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="out-site" name="type_input[out-site]" required>
                    <label class="form-check-label" for="out-site">OUT-SITE</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="therapy" name="type_input[therapy]" required>
                    <label class="form-check-label" for="therapy">THERAPY</label>
                </div>
            </div>
            <span class="invalid-feedback">
                <strong>{{ $errors->first('type_input') }}</strong>
            </span>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit" id="btn-confirmAddTypeCust">SAVE</button>
        </div>
    </form>
</div>

@can('browse-type-cust')
<div class="container" id="list-member" style="overflow-x:auto;">
    <h1 style="text-align:center;color:#505e6c;">List Data Type</h1>

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
                    <th>NAME</th>
                    <th>TYPE INPUT</th>
                </tr>
            </thead>
            <tbody name="collection">
                @php
                $i = 0
                @endphp
                @foreach($typecusts as $typecust)
                <tr>
                    <td>{{$typecust->name}}</td>
                    <td>{{$typecust->type_input}}</td>
                    @if(Gate::check('edit-type-cust'))
                    <td>
                        <button class="btn btn-primary btn-editTypeCust" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$typecust->id}}">
                            <i class="material-icons">mode_edit</i>
                        </button>
                    </td>
                    @endif
                    @if(Gate::check('delete-type-cust'))
                    <td>
                        <button class="btn btn-primary btn-deleteTypeCust" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$typecust->id}}">
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
    @foreach($typecusts as $typecust)
    <div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">{{$typecust->name}} - {{$typecust->type_input}}<br></h6>
                @if(Gate::check('edit-type-cust'))
                <button class="btn btn-primary btn-edithapus-card btn-editTypeCust" type="button" style="padding:0px 5px;" name="{{$i}}" value="{{$typecust->id}}">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-type-cust'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteTypeCust" type="button" style="padding:0px 5px;margin-right:10px;" name="{{$i}}" value="{{$typecust->id}}">
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
        {{ $typecusts->links() }}
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
                <p id="txt-delete-type-cust"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <form id="actionDelete" action="{{route('delete_type_cust', ['id' => ''])}}" method="post">
                    {{csrf_field()}}
                    <button class="btn btn-danger" type="submit" id="btn-confirmDeleteTypeCust" value="-">Delete</button>
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
                <h2 class="text-center">Edit Data Type</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- FORM UNTUK UPDATE DATA -->
            <form id="actionEdit" method="post" action="{{ route('update_type_cust') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                        <div class="form-group">
                            <span>NAME</span>
                            <input class="form-control text-uppercase" type="text" name="name" required="" placeholder="Name" autofocus="" id="txtnama-type-cust">
                        </div>
                        <div class="form-group">
                            <span>TYPE INPUT</span>
                            <input class="form-control text-uppercase" type="text" readonly="" id="txttypeinput-type-cust">
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-confirmUpdateTypeCust" value="-">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    //Validasi required pada group checkbox
    //prop required akan hilang jika checkbox sudah di centang setidaknya satu
    $('#btn-confirmAddTypeCust').on('click', function() {
        $cbx_group = $("input:checkbox[name^='type_input']");

        $cbx_group.prop('required', true);
        if($cbx_group.is(":checked")){
          $cbx_group.prop('required', false);
        }
    });

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

        //-- Add Type Cust --//
            var formAdd;
            
            $('#btn-confirmAddTypeCust').click(function(e){
                e.preventDefault();

                formAdd = _("actionAdd");
                formAdd = new FormData(formAdd);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerAdd, false);
                ajax.addEventListener("load", completeHandlerAdd, false);
                ajax.addEventListener("error", errorHandlerAdd, false);
                ajax.addEventListener("abort", abortHandlerAdd, false);
                ajax.open("POST", "{{ route('store_type_cust') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formAdd);
            });
            function progressHandlerAdd(event){
                document.getElementById("btn-confirmAddTypeCust").innerHTML = "Uploading...";
            }
            function completeHandlerAdd(event){
                var hasil = JSON.parse(event.target.responseText);
                var formDOM = _("actionAdd");

                for (var key of formAdd.keys()) {
                    $("#actionAdd").find("input[name^='"+key+"']").removeClass("is-invalid");
                    $("#actionAdd").find("select[name^='"+key+"']").removeClass("is-invalid");

                    $("#actionAdd").find("input[name^='"+key+"']").next().find("strong").text("");
                    $("#actionAdd").find("select[name^='"+key+"']").next().find("strong").text("");
                }

                if(hasil['errors'] != null){
                    for (var key of formAdd.keys()) {
                        if(typeof hasil['errors'][key] === 'undefined') {

                        }
                        else
                        {
                            $("#actionAdd").find("input[name^='"+key+"']").addClass("is-invalid");
                            $("#actionAdd").find("select[name^='"+key+"']").addClass("is-invalid");

                            $("#actionAdd").find("input[name^='"+key+"']").next().find("strong").text(hasil['errors'][key]);
                            $("#actionAdd").find("select[name^='"+key+"']").next().find("strong").text(hasil['errors'][key]);
                        }
                    }
                }
                else{
                    $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                    $("#modal-Notification").modal("show");
                }

                document.getElementById("btn-confirmAddTypeCust").innerHTML = "SAVE";
            }
            function errorHandlerAdd(event){
                document.getElementById("btn-confirmAddTypeCust").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerAdd(event){
            }

        //-- Edit Type Cust --//
            var formEdit;
            function _(el){
                return document.getElementById(el);
            }

            $('#btn-confirmUpdateTypeCust').click(function(e){
                e.preventDefault();

                formEdit = _("actionEdit");
                formEdit = new FormData(formEdit);
                formEdit.append("id", this.value);

                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandlerEdit, false);
                ajax.addEventListener("load", completeHandlerEdit, false);
                ajax.addEventListener("error", errorHandlerEdit, false);
                ajax.addEventListener("abort", abortHandlerEdit, false);
                ajax.open("POST", "{{ route('update_type_cust') }}");
                ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
                ajax.send(formEdit);
            });
            function progressHandlerEdit(event){
                document.getElementById("btn-confirmUpdateTypeCust").innerHTML = "Uploading...";
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

                document.getElementById("btn-confirmUpdateTypeCust").innerHTML = "SAVE";
            }
            function errorHandlerEdit(event){
                document.getElementById("btn-confirmUpdateTypeCust").innerHTML = "SAVE";
                $("#modal-Notification").find("p#txt-notification").html(event.target.responseText);
                $("#modal-Notification").modal("show");
            }
            function abortHandlerEdit(event){
            }
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