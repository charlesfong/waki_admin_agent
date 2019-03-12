@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/jquery.tabledit.js') }}"></script>
@endsection
@section('navmenu')
    <li> <a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="list-selected">Show Member</li>
    <li> <a href="{{route('add')}}">Add Member</a></li>
@endsection
@section('content')
<div class="container" style="overflow-x:auto;">
    <div class="col-md-12" style="margin-top: 5px;">
        <h1 class="text-center" style="margin-top: 20px;">Members Details</h1>
        <!--Filter-->
        <div class="col-md-12 col-sm-12 col-xs-12" style="background-color: transparent; -webkit-box-shadow: none;-moz-box-shadow: none;box-shadow: none;">
            <!-- <div class="card-body"> -->
                <!-- <form id="form-search" class="search-form" style="float: left;">
                    <div class="input-group custom-search-form" style="width: 100%;">
                        <input id="input-keyword" class="form-control" type="text" name="keyword" placeholder="Search...">
                        <span class="input-group-btn" style="min-width: 39px;width: 8%;">
                            <button class="btn btn-default" type="submit" style="background: #048b32; color: #2222;">
                                <span class="glyphicon glyphicon-searchz"></span>
                            </button>
                        </span>
                    </div>
                </form> -->
                <input id="input-keyword" class="form-control col-md-4" type="text" name="keyword" placeholder="Search...">
	            <button id="form-search" type="button" class="btn btn-success">Cari</button>
                <div class="col-xs-12 col-sm-12 col-md-12" style="box-shadow:none; margin-bottom: 0; z-index: 1;">
                    

                    <div class="sorting col-xs-12 col-sm-12 col-md-6" style="margin: 0; margin-top: 10px; padding-left: 0;">
                        <h6 style="font-size: 1em;">Filter Verified</h6>
                        <?php
                            $page = "";
                            $statUnverified = "";
                            $statVerified = "";
                            if(isset($_GET['verified']) && strtolower($_GET['verified']) == 0){
                                $statUnverified = "selected";
                            }
                            elseif(isset($_GET['verified']) && strtolower($_GET['verified']) == 1){
                                $statVerified = "selected";
                            }

                        ?>
                        <select id="dropdown_verified" class="frm-field required sect col-md-10 form-control" style="margin: 0; min-width: 18em;">
                            <option value="">Select</option>
                            <option value="verified=0" {{$statUnverified}}>
                                Unverified
                            </option> 
                            <option value="verified=1" {{$statVerified}}>
                                Verified
                            </option>
                        </select>
                    </div>
                    <div class="sorting col-xs-12 col-sm-12 col-md-6" style="margin: 0; margin-top: 10px; padding-left: 0;">
                        <h6 style="font-size: 1em;">Sort By</h6>
                        <?php
                            $codeAsc = "";
                            $codeDesc = "";
                            $nameAsc = "";
                            $nameDesc = "";
                            $regDateAsc = "";
                            $regDateDesc = "";
                           
                            
                            if(isset($_GET['sortby']) && strtolower($_GET['sortby']) == 'codeasc'){
                                $codeAsc = "selected";
                            }elseif(isset($_GET['sortby']) && strtolower($_GET['sortby']) == 'codedesc'){
                                $codeDesc = "selected";
                            }elseif(isset($_GET['sortby']) && strtolower($_GET['sortby']) == 'nameasc'){
                                $nameAsc = "selected";
                            }elseif(isset($_GET['sortby']) && strtolower($_GET['sortby']) == 'namedesc'){
                                $nameDesc = "selected";
                            }elseif(isset($_GET['sortby']) && strtolower($_GET['sortby']) == 'regdateasc'){
                                $regDateAsc = "selected";
                            }elseif(isset($_GET['sortby']) && strtolower($_GET['sortby']) == 'regdatedesc'){
                                $regDateDesc = "selected";
                            }
                        ?>
                        <select id="dropdown_sortby" class="frm-field required sect col-md-10 form-control" style="margin: 0; min-width: 18em;">
                            <option value="">Sort By</option>
                            <option value="sortby=codeasc" {{$codeAsc}}>
                                Code A-Z
                            </option> 
                            <option value="sortby=codedesc" {{$codeDesc}}>
                                Code Z-A
                            </option>
                             <option value="sortby=nameasc" {{$nameAsc}}>
                                Name A-Z
                            </option> 
                            <option value="sortby=namedesc" {{$nameDesc}}>
                                Name Z-A
                            </option>
                             <option value="sortby=regdateasc" {{$regDateAsc}}>
                                Register Date Ascending
                            </option> 
                            <option value="sortby=regdatedesc" {{$regDateDesc}}>
                                Register Date Descending
                            </option>
                          
                        </select>
                    </div>

                    <div class="sorting col-xs-12 col-sm-12 col-md-6" style="margin: 0; margin-top: 10px; padding-left: 0;">
                        <h6 style="font-size: 1em;">Show Entries</h6>
                        
                        <select id="dropdown_entries" class="frm-field required sect col-md-10 form-control" style="margin: 0; min-width: 18em;">
                            <option value="">Default</option>
                            <option value="">
                                20
                            </option> 
                            <option value="">
                                30
                            </option>
                             <option value="">
                                40
                            </option> 
                            <option value="">
                                50
                            </option>
                             <option value="">
                                All
                            </option>                          
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--//Filter-->

        <div class="col-md-12" style="background-color: #ffff; -webkit-box-shadow: none;-moz-box-shadow: none;box-shadow: none;">
            <div class="card-body">
                <div>Showing entries</div>
                <section id="table1">
                <table class="table table-sm table-bordered table-responsive-sm table-responsive-md tablesorter" style="width:100%; font-size: 1em;">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;">Code</th>
                            <th style="vertical-align: middle;">Name</th>
                            <th style="vertical-align: middle;">Phone</th>
                            <th style="vertical-align: middle;">Member Type</th>
                            <th style="vertical-align: middle;">Sponsor</th>
                            <th style="vertical-align: middle;">Register date</th>
                            <th style="vertical-align: middle;">Verified</th>
                            <th style="vertical-align: middle; text-align: center;">DETAIL/EDIT/DELETE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>{{$member['code']}}</td>
                            <td>{{$member['name']}}</td>
                            <td>{{$member['phone']}}</td>
                            <td>
                                <?php
                                       if($member->member_type!=null){
                                           echo $member->member_type->name;
                                       }                             
                                ?>
                            </td>
                            <td>
                                <a href="{{route('admin_agent_details', ['id' => $member->agent['id']])}}">{{$member->agent['agent_code']}}</a>
                            </td>
                            <td>{{$member['created_at']}}</td>
                            <td>

                                @if(!empty($member['email_verified_at']))
                                <span class="label label-success">Verified</span>
                                @else
                                <span class="label label-warning">Unverified</span>
                                @endif
                            </td>
                         
                            <td style="text-align: center;">
                                <span><a href="{{route('admin_member_details', ['id' => $member['id']])}}"><button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></button></a></span>&nbsp;
                                <span><button type="button" class="btn btn-primary btn-sm btn-edit" value="{{$member->id}}"><i class="fa fa-edit"></i></button></span>&nbsp;
                                <span><button type="button" data-toggle="modal" data-target="#modal-delete-member" class="btn btn-danger btn-sm btn-delete" value="{{$member->id}}"><i class="fa fa-trash"></i></button></span>&nbsp;
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </section>
                <!-- membuat pagination -->
                <div>Showing {{ $members->firstItem() }} to {{ $members->lastItem() }} of total {{$members->total()}} entries</div>
                <div>
                <?php echo $members->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- modal update data -->
<div class="modal fade" role="dialog" tabindex="-1" id="modal-UpdateForm">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-center">Edit Member</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- FORM UNTUK UPDATE DATA -->
            <form id="actionEdit" method="post" action="{{ route('update_member') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <span>CODE</span>
                        <input id="edit-code" type="text" name="code" class="text-uppercase form-control" placeholder="Code"  value="" readonly>
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>NIK</span>
                        <input id="edit-nik" type="text" name="nik" class="text-uppercase form-control" onkeypress="return onKeyValidate(event, numeric);" placeholder="NIK"  value="">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>Nama</span>
                        <input id="edit-name" type="text" name="name" onkeypress="return onKeyValidate(event,alpha);" class="text-uppercase form-control" placeholder="Nama"  value="">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>Email</span>
                        <input id="edit-email" type="text" name="email" class="text-uppercase form-control" placeholder="Email"  value="" >
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>Phone</span>
                        <input id="edit-phone" type="text" name="phone" class="text-uppercase form-control" onkeypress="return onKeyValidate(event, numeric);" placeholder="Phone"  value="" >
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>Alamat</span>
                        <input id="edit-address" type="text" name="address" class="text-uppercase form-control" placeholder="Address"  value="">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <span>Tanggal Lahir</span>
                            <div class="row col-md-12 center-block" style="padding: 0;">
                                <div class="col-sm-4 bd">
                                    <select id="birth_day" name="birth_day" class="form-control text-uppercase" >
                                            <option value="" selected="selected" disabled="disabled">SELECT DAY</option> 
                                            @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{$i}}" id="{{$i}}">{{$i}}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="col-sm-4 bd">
                                    <select id="birth_month" name="birth_month" class="form-control text-uppercase" >
                                            <option value="" selected="selected" disabled="disabled">SELECT MONTH</option> 
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{$i}}">{{$i}}</option>  
                                            @endfor
                                    </select>
                                </div>
                                <div class="col-sm-4 bd">
                                    <input type="Number" id="birth_year" name="birth_year" required="" placeholder="Year" max="<?php echo date("Y")-17;?>" min="1920" class="form-control text-uppercase">  
                                    <span></span>
                                    @if ($errors->has('birth_date'))
                                        <strong style="color: #e3342f;">{{ $errors->first('birth_date') }}</strong>
                                    @endif
                                </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <span>Provinsi</span>
                        <select id="province" name="province" class="form-control text-uppercase">
                            @include('etc.select-province')
                        </select>
                    </div>
                    <div class="form-group">
                        <span>Kota</span>
                        <select id="district" name="district" class="form-control text-uppercase">
                            <option value="" id=edit-district></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <span>Kode Pos</span>
                        <input id="edit-zipcode" type="text" name="zipcode" onkeypress="return onKeyValidate(event, numeric);" class="text-uppercase form-control" placeholder="zipcode"  value="">
                    </div>
                    <div class="form-group">
                        <span>Kode Agen</span>
                        <input id="agentcode" type="text" name="agentcode" class="text-uppercase form-control" value="">
                        <span class="invalid-feedback">
                            <strong></strong>
                        </span>
                        <span id="agentname" style="width:100%;background: transparent;"></span>
                        <span></span>
                        @if ($errors->has('agent_code'))
                            <strong style="color: #e3342f;">{{ $errors->first('agent_code') }}</strong>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-confirmUpdate" value="-" name="id">SAVE</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete-member" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="top: 30vh;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                    <p style="text-align: center; color: black;">
                        <strong id="model-change-status-questions">Delete Member?</strong>
                    </p>
                    <form id="delete-member-form" method="post" action="{{route('delete_member')}}" hidden>
                        @csrf
                        <input id="order-id" name="id" >
                    </form>
                
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button id="btn-submit-delete-member" type="button" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
        <!-- //Modal content-->
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/admin/tags-input.js') }}"></script>
<script src="{{ asset('js/admin/jquery.tablesorter.js') }}"></script>
<script src="{{ asset('js/admin/jquery.tablesorter.widgets.js') }}"></script>

<!-- Tablesorter -->
<script>
    var alpha = "[ A-Za-z]";
    var numeric = "[0-9]"; 
    var alphanumeric = "[ A-Za-z0-9]"; 

    function onKeyValidate(e,charVal){
        var keynum;
        var keyChars = /[\x00\x08]/;
        var validChars = new RegExp(charVal);
        if(window.event)
        {
            keynum = e.keyCode;
        }
        else if(e.which)
        {
            keynum = e.which;
        }
        var keychar = String.fromCharCode(keynum);
        if (!validChars.test(keychar) && !keyChars.test(keychar))   {
            return false
        } else{
            return keychar;
        }
    }
</script>
<script>
$('#birth_month, #birth_year').on("change paste keyup", function() {
    if ($('#birth_month').val()==2) {
        if($('#birth_year').val()%4==0){
            $("#29").show();
            if($('#birth_day').val() > 29){
                $('#birth_day').val(29);
            }
        }
        else{
            $("#29").hide();
            if($('#birth_day').val() > 28){
                $('#birth_day').val(28);
            }
        }
        $("#30").hide();
        $("#31").hide();
    }
    else if ($('#birth_month').val()==1||$('#birth_month').val()==3||$('#birth_month').val()==5||$('#birth_month').val()==7||
        $('#birth_month').val()==8||$('#birth_month').val()==10||$('#birth_month').val()==12){
        $("#30").show();
        $("#31").show();
    }
    else
    {
        $("#30").show();
        $("#31").hide();
        if($('#birth_day').val() > 30){
            $('#birth_day').val(30);
        }
    }
    console.log($('#birth_year').val().length);
    if(parseInt($('#birth_year').val()) > parseInt($('#birth_year').attr('max')) && $('#birth_year').val().length > 3){
        $('#birth_year').val($('#birth_year').attr('max'));
    }
    if(parseInt($('#birth_year').val()) < parseInt($('#birth_year').attr('min')) && $('#birth_year').val().length > 3){
        $('#birth_year').val($('#birth_year').attr('min'));
    }  
});
$('#province').change(function (e) {
    $("#district").html("");
    var provinceVal = $('#province').val();
    $.get("etc/select-" + unescape(provinceVal) + ".php", function (data) {
        $("#district").empty();
        $("#district").append(data);
    });

});    
$(function() {
    $('table').tablesorter({
    // third click on table header will reset column to default - unsorted
    sortReset   : true,
    widthFixed: true,
    duplicateSpan : true,
    headers: {
        2:{sorter:false},
        3:{sorter:false},
        7:{sorter:false}
    },
        widgets: ["saveSort"],
        widgetOptions: {
          // enable/disable saveSort dynamically
          saveSort: true
        }
    });
});
var isFirst = true;
checkAgent($('#agentcode').val());

$("#agentcode").on("change paste keyup", function() {
    checkAgent($('#agentcode').val());
});

function checkAgent(code){
   $.get( '{{route("get_agent_by_code")}}', { agentcode: code })
    .done(function( data ) {
        console.log(data);
        if(data && data['agent_type_id']<=3){
            $('#agentname').html('<div style="color:green">Code Agent Benar</div>');
            isAgentFilled=true;
        }else{
            isAgentFilled=false
            if(!isFirst && code!=""){
                $('#agentname').html('<div style="color:red">Code Agent Salah</div>');
            }else{
                $('#agentname').html('');
            }
        }
        isFirst=false;
    });
}
</script>
<!-- //Tablesorter -->

<script type="text/javascript">
//$('#modal-DataUndangan').modal('show');
/*METHOD - METHOD UMUM ATAU KESELURUHAN
 * Khusus method" PENOPANG PADA HALAMAN INI
 */
function _(el) {
    return document.getElementById(el);
}



function progressHandler(event) {
    document.getElementById("btn-actionAdd").innerHTML = "UPLOADING...";
}
function completeHandler(event) {
    var hasil = JSON.parse(event.target.responseText);

    for (var key of frmUpdate.keys()) {
        $("#actionAdd").find("input[name=" + key + "]").removeClass("is-invalid");
        $("#actionAdd").find("select[name=" + key + "]").removeClass("is-invalid");
        $("#actionAdd").find("textarea[name=" + key + "]").removeClass("is-invalid");

        $("#actionAdd").find("input[name=" + key + "]").next().find("strong").text("");
        $("#actionAdd").find("select[name=" + key + "]").next().find("strong").text("");
        $("#actionAdd").find("textarea[name=" + key + "]").next().find("strong").text("");
    }

    if (hasil['errors'] != null) {
        for (var key of frmUpdate.keys()) {
            if (typeof hasil['errors'][key] === 'undefined') {

            } else {
                $("#actionAdd").find("input[name=" + key + "]").addClass("is-invalid");
                $("#actionAdd").find("select[name=" + key + "]").addClass("is-invalid");
                $("#actionAdd").find("textarea[name=" + key + "]").addClass("is-invalid");

                $("#actionAdd").find("input[name=" + key + "]").next().find("strong").text(hasil['errors'][key]);
                $("#actionAdd").find("select[name=" + key + "]").next().find("strong").text(hasil['errors'][key]);
                $("#actionAdd").find("textarea[name=" + key + "]").next().find("strong").text(hasil['errors'][key]);
            }
        }
    } else {
        alert("Berhasil Keyin !!!")
    }

    document.getElementById("btn-actionAdd").innerHTML = "SAVE";
}
function errorHandler(event) {
    document.getElementById("btn-actionAdd").innerHTML = "SAVE";
}
</script>
<script type="text/javascript">
    for (let input of document.querySelectorAll('#tags')) {
        tagsInput(input);
    }

    var editMode = false;

    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13 && editMode) {
                event.preventDefault();
                return false;
            }
        });
    });

    $(function () {
        $(".td_edit").dblclick(function (e) {
            e.stopPropagation();
            var type_price = "";
            if (!editMode) {
                var currentEle = $("#" + $(this).attr('id'));
                var value = currentEle.html();
                updateVal(currentEle, value);
                editMode = true;
                console.log("asdasd");
            }
        });
    });

    $(".btn-edit").click(function (e) {
        var id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{route('edit_member')}}",
            data: {
                'id': id
            },
            success: function (data) {
                var data        = data['result'];
                var id          = data['id'];
                var code        = data['code'];
                var email       = data['email'];
                var phone       = data['phone'];
                var nik         = data['nik'];
                var name        = data['name'];
                var address     = data['address'];
                var province    = data['province'];
                var district    = data['district'];
                var zipcode     = data['zipcode'];
                var active      = data['active'];
                var agent_id    = data['agent_id'];
                var norekening  = data['norekening'];
                var agent_code  = data['agent_code'];
                var birth_date  = data['birth_date'];
                var memberTypeId = data['member_type_id'];
                $("#district").empty();
                $("#edit-code").val(code);
                $("#edit-email").val(email);
                $("#edit-phone").val(phone);
                $("#edit-nik").val(nik);
                $("#edit-name").val(name);
                $("#edit-address").val(address);
                $("#province").val(province);
                // $("#edit-district").val(district);
                $("#edit-zipcode").val(zipcode);
                $("#edit-agent_id").val(agent_id);
                $("#edit-norekening").val(norekening);
                $("#agentcode").val(agent_code);
                d=new Date(birth_date);
                dt=d.getDate();
                mn=d.getMonth();
                mn++;
                yy=d.getFullYear();
                $("#birth_day").find('option:contains('+dt+')').attr('selected','selected');
                $("#birth_month").find('option:contains('+mn+')').attr('selected','selected');
                $("#birth_year").val(yy);
                $("#edit-birth_date").val(birth_date);
                $("#edit-active").val(active);
                $("#edit-member_type").val(memberTypeId);
                $("#btn-confirmUpdate").val(id);
                // $('#province').find('option:contains('+province+')').attr('selected','selected');
                $('#province').val(province);
                var provinceVal = $('#province').val();
                $("#district").append(data);
                $.get("etc/select-" + unescape(provinceVal) + ".php", function (data) {
                    $("#district").append(data); 
                });
                setTimeout(function(){ 
                    $('#district').val(district);
                }, 500);
                $("#modal-UpdateForm").modal("show");
            }
        });
    });
    
    $(".btn-delete").click(function(){
        var id = $(this).val();
        $('#order-id').val(id);
        
    });
    
    $('#btn-submit-delete-member').click(function(){
        $('#delete-member-form').submit();
    });

    // var frmUpdate;

    // $("#actionEdit").on("submit", function (e) {
    //     e.preventDefault();
    //     frmUpdate = _("actionEdit");
    //     frmUpdate = new FormData(frmUpdate);
    //     frmUpdate.enctype = "multipart/form-data";
    //     // var images = $("#gambars")[0].files;

    //     frmUpdate.append('id', $("#btn-confirmUpdate").val());
    //     var URLNya = $("#actionEdit").attr('action');

    //     var ajax = new XMLHttpRequest();
    //     ajax.upload.addEventListener("progress", progressHandler, false);
    //     ajax.addEventListener("load", completeHandler, false);
    //     ajax.addEventListener("error", errorHandler, false);
    //     ajax.open("POST", URLNya);
    //     ajax.setRequestHeader("X-CSRF-TOKEN",$('meta[name="csrf-token"]').attr('content'));
    //     ajax.send(frmUpdate);
    // });
    // $("#btn-confirmUpdate").click(function () {
    //     e.preventDefault();
        
    //     $("#actionEdit").submit();
    // });

    $("#input-keyword").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#form-search").click();
        }
    });
</script>

<!--sort -->
<script>

    var keyword = "<?php echo (isset($_GET["keyword"]) ? "keyword=".$_GET["keyword"] : "") ?>";
    var membertype = "<?php echo (isset($_GET["membertype"]) ? "membertype=".$_GET["membertype"] : "") ?>";
    var verified = "<?php echo (isset($_GET["verified"]) ? "verified=".$_GET["verified"] : "") ?>";
    var sortby = "<?php echo (isset($_GET["sortby"]) ? "page=".$_GET["sortby"] : "") ?>";
    
    console.log(keyword);
    console.log(membertype)
    mergeUrlParam();
    
    $("#dropdown_membertype").change(function () {
        var val = this.value;
        membertype = val;
        
        window.location.href = "{{ route('waki') }}" + mergeUrlParam();
       
    });
    
    $("#dropdown_verified").change(function () {
        var val = this.value;
        verified = val;
        window.location.href = "{{ route('waki') }}" + mergeUrlParam();

    });
    
    $("#dropdown_sortby").change(function () {
        var val = this.value;
        sortby = val;
        window.location.href = "{{ route('waki') }}" + mergeUrlParam();

    });
    
    $("#form-search").click(function(){
        var val = "keyword="+$("#input-keyword").val();
        keyword = val;
        window.location.href = "{{ route('waki') }}" + mergeUrlParam();
        console.log('huih');
        // return false;
    });
    
    function mergeUrlParam(){
        
        var urlParamArray = new Array();
        var urlParamStr = "";
       
        if (keyword!=="") {
            urlParamArray.push(keyword);
        }
        if (membertype!=="") {
            urlParamArray.push(membertype);
        }
        if (verified!=="") {
            urlParamArray.push(verified);
        }
        if (sortby!=="") {
            urlParamArray.push(sortby);
        }
        for (var i = 0; i < urlParamArray.length; i++) {
            if (i === 0) {
                urlParamStr += "?" + urlParamArray[i]
            } else {
                urlParamStr += "&" + urlParamArray[i]
            }
        }
        return urlParamStr;
    }
</script>
<!--//sort -->

@endsection