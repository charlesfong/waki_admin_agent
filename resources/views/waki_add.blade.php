@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('js/jquery.tabledit.js') }}"></script>
@endsection
@section('navmenu')
    <li> <a href="#">Dashboard</a></li>
    <li> <a href="{{route('waki')}}">Show Member</li>
    <li class="list-selected"> Add Member</a></li>
@endsection
@section('content')
<style>
    .center-block {
    float: none !important
}
</style>
<?php
// Utils::$country='id';
// if (Utils::$country=='id'){
//     $currency = "Rp ";
//     $crCode = "IDR";
// }else if (Utils::$country=='phl'){
//     $currency = "₱";
//     $crCode = "PHP";
// }else if(Utils::$country=='th'){
//     $currency = "฿";
//     $crCode = "THB";
// }else if(Utils::$country=='my'){
//     $currency = "RM";
//     $crCode = "MYR";
// }else{
//     $currency = "$";
//     $crCode = "USD";
// }    
?>
<!-- /banner_bottom_agile_info -->

<div class="banner_bottom_agile_info">
    <div class="container" style="padding: 0;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 contact-form2">
                <div class="col-md-7 center-block">
                    <h4 style="text-align: center;">
                    Form Pendaftaran Member
                    </h4>
                    <form id="form-register" action="{{ route('member_register') }}" method="post">
                        @csrf
                        <div class="styled-input agile-styled-input-top">
                            <input type="number" onkeydown="return event.keyCode !== 69" name="nik" required="true" value="{{old('nik')}}" onkeypress="return onKeyValidate(event, numeric);"> 
                            <label>N I K</label>
                            <span></span>
                            @if ($errors->has('nik'))
                            <strong style="color: #e3342f;">{{ $errors->first('nik') }}</strong>
                            @endif
                        </div>

                        <div class="styled-input">
                            <input type="text" name="name" required="" onkeypress="return onKeyValidate(event,alpha);"class="text-uppercase" value="{{old('name')}}">
                            <label>Nama</label>
                            <span></span>
                            @if ($errors->has('name'))
                                <strong style="color: #e3342f;">{{ $errors->first('name') }}</strong>
                            @endif
                        </div>

                        <div class="styled-input">
                            <input type="text" name="email" value="{{old('email')}}" 
                            oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" class=""> 
                            <label>Email</label>
                            <span></span>
                            @if ($errors->has('email'))
                                    <strong style="color: #e3342f;">{{ $errors->first('email') }}</strong>
                            @endif
                        </div>
                        
                        <div class="styled-input">
                            <input type="text" name="phone" required="" value="{{old('phone')}}" onkeypress="return onKeyValidate(event, numeric);" oninvalid="this.setCustomValidity(  'Tolong isi kolom ini') " oninput="setCustomValidity('')"> 
                            <label>No Telp. </label>
                            <span></span>
                            @if ($errors->has('phone'))
                                <strong style="color: #e3342f;">{{ $errors->first('phone') }}</strong>
                            @endif
                        </div>
                     
                        <div class="styled-input">
                            <input type="text" name="address" required="" value="{{old('address')}}" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" >
                            <label>Alamat Anda</label>
                            <span></span>
                            @if ($errors->has('address'))
                                <strong style="color: #e3342f;">{{ $errors->first('address') }}</strong>
                            @endif
                        </div>

                        <div class="normal-input ">
                            <label class="col-xs-12">Jenis Kelamin</label>
                            <br>
                            <br>
                            <div class="row col-xs-12">
                                <div class="col-xs-6"><input id="male1" type="radio" name="gender" value="male" required {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label style="transition: none;" for="male1">Laki-laki</label></div> &nbsp&nbsp&nbsp
                                <div class="col-xs-6"><input id="female1" type="radio"  name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label style="transition: none;" for="female1">Perempuan</label></div>
                            </div>
                            <span></span>
                            @if ($errors->has('gender'))
                                <strong style="color: #e3342f;">{{ $errors->first('gender') }}</strong>
                            @endif
                        </div>

                        <div class="normal-input" style="margin: 3em 0 3em;">
                            <label style="margin: 0 0 2em;">Tanggal Lahir</label>
                            <div class=" row col-md-12 center-block" style="padding: 0;">
                            <div class="col-sm-4 bd">
                                <select id="birth_day" name="birth_day" class="form-control text-uppercase" required="" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" value="{{old('birth_date')}}">  >

                                        <option value="" selected="selected" disabled="disabled">SELECT DAY</option> 
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{$i}}" id="{{$i}}">{{$i}}</option>
                                        @endfor
                                </select>
                            </div>
                            <div class="col-sm-4 bd">
                                <select id="birth_month" name="birth_month" class="form-control text-uppercase" required="" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" value="{{old('birth_date')}}">  >

                                        <option value="" selected="selected" disabled="disabled">SELECT MONTH</option> 
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{$i}}">{{$i}}</option>  
                                        @endfor
                                </select>
                            </div>
                            <div class="col-sm-4 bd">
                                <input type="Number" id="birth_year" name="birth_year" required="" placeholder="Year" max="<?php echo date("Y")-17;?>" min="1920" class="form-control text-uppercase" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" value="{{old('birth_date')}}">  
                                                       
                            <span></span>
                            @if ($errors->has('birth_date'))
                                <strong style="color: #e3342f;">{{ $errors->first('birth_date') }}</strong>
                            @endif
                            </div>
                            </div>
                        </div>

                        <div class="styled-input">
                            <label>Provinsi</label>
                            <br>
                            <br>
                            <div>
                                <select id="province" name="province" class="form-control text-uppercase" required="">

                                        @include('etc.select-province')
                                </select>
                            </div>
                            <span></span>
                            @if ($errors->has('province'))
                                <strong style="color: #e3342f;">{{ $errors->first('province') }}</strong>
                            @endif
                        </div>

                        <div class="styled-input">
                            <label>Kota</label>
                            <br>
                            <br>
                            <div>
                                <select id="district" name="district" class="form-control text-uppercase">
                                    <option value="" disabled selected>PILIH PROVINSI DAHULU</option>
                                </select>
                            </div>
                            @if ($errors->has('district'))
                                <strong style="color: #e3342f;">{{ $errors->first('district') }}</strong>
                            @endif
                        </div>

                        <div class="styled-input">
                            <input type="text" name="zipcode" required="" onkeypress="return onKeyValidate(event, numeric);" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" value="{{old('zipcode')}}"> 
                            <label>
                                Kode Pos
                            </label>
                            <span></span>
                            @if ($errors->has('zipcode'))
                                <strong style="color: #e3342f;">{{ $errors->first('zipcode') }}</strong>
                            @endif
                        </div>

                        <?php
                            $agentCode = "";
                            $agentName = "";
                            if(Session::has('agent_code')){
                                $agentCode = Session::get('agent_code');
                                $agentName = Session::get('agent_name');
                            }else if(isset($_GET['cdd'])){
                                $cdd = $_GET['cdd'];
                                $members = \App\Member::where('agent_code',$cdd)->get();
                                if(count($members)>0){
                                    $agentCode = $cdd;
                                    $agentName = $members[0]->name;                                
                                }
                            }
                        ?>
                        <div id="clearfix">
                            @if($agentCode!="")
                            <div class="normal-input">
                                <label>
                                    Kode Agen
                                </label>
                                <input id="agentcode" type="text" name="agent_code" required="" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" onchange="checkAgent(this.value)" value="{{$agentCode}}" readonly="">
                            @else
                            <div class="styled-input">
                                <input id="agentcode" type="text" name="agent_code" required="" oninvalid="this.setCustomValidity( 'Tolong isi kolom ini')" oninput="setCustomValidity('')" onchange="checkAgent(this.value)" value="">
                                <label>
                                    Kode Agen 
                                </label>
                            @endif
                                <span id="agentname" style="width:100%;background: transparent;"></span>
                                <span></span>
                                @if ($errors->has('agent_code'))
                                    <strong style="color: #e3342f;">{{ $errors->first('agent_code') }}</strong>
                                @endif
                            </div>
                        </div>
                        <br>
                        <br>
                                @php
                                    $labelReg = "Daftar";
                                @endphp
                        <input id="btn-submit" type="submit" value="{{$labelReg}}">

                        <div class="clearfix"> </div>
                        <div class="clearfix"> </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>

<!--modal loading -->
<div class="modal fade" id="modalloading"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="top: 45vh;">
    <div class="modal-dialog modal-dialog-centered justify-content-center" style="margin: auto; text-align: center; float: none;" role="document">
        <span class="fa fa-spinner fa-spin fa-3x"></span>
    </div>
</div>
<!--//modal loading -->
@endsection

@section("script")
<script type="text/javascript">
$('#province').change(function (e) {
    $("#district").html("");
    var provinceVal = $('#province').val();
    $.get("etc/select-" + unescape(provinceVal) + ".php", function (data) {
        $("#district").append(data);
    });
});
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
</script>
@if ($errors->isNotEmpty())
<script type="text/javascript">
    $(document).ready(function () {
    //Show old value of province
    const provinceOldValue = "{{ old('province') }}";
    if (provinceOldValue !== '') {
        $('#province').val(provinceOldValue);
    }
    console.log(provinceOldValue);
    //Show old value of district
    const districtOldValue = "{{ old('district') }}";
    $.get("etc/select-" + unescape(provinceOldValue) + ".php", function (data) {
    $("#district").append(data);
    $('#district').val(districtOldValue);
    });
    });
    
</script>
@endif
<!--modal loading -->
<script>
    function modalloading(){
        $('#modalloading').modal('show');
    }
    function modalloadingHide(){
        $('#modalloading').modal('hide');
    }
</script>
<script>
    var wto;
    var isAgentFilled = false;
    var isFirst = true;

    $("#form-register").submit(function(){
        if(isAgentFilled  && $('#agentcode').val()!="" ){
            $("#btn-submit").attr('disabled', true);
            modalloading();
            console.log('a');
        }else{
            $('#agentcode').html('<div style="color:red">Tolong isi code agent dengan benar</div>');
            alert('Tolong isi code agent dengan benar');
            
            $('#btnSubmit').attr('disabled', false);
            modalloadingHide();
            return false;
        }
    });

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
@endsection