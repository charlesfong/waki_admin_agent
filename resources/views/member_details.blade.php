@extends('layouts.template')
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/chart/styles.css') }}">
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/metisMenu.css') }}">
@endsection
@section('navmenu')
    <li> <a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="list-selected">Show Member</li>
    <li> <a href="{{route('dashboard')}}">Add Member</a></li>
@endsection
@section('content')
<div class="col-md-12" style="box-shadow: none;background: transparent;margin-bottom: 0;">
<a class="btn btn-link d-inline float-left" role="button" id="logout" style="color: #048b32;" href="javascript:history.go(-1)">
    <i class="fa fa-arrow-left" style="margin-left:5px;display:inline;margin-right: 5px;"></i>{{ __('Back') }}                
</a>
</div>

<div class="container" style="overflow-x:auto; font-size: 1em;">
    <div class="col-md-12">
        <div class="card">
            <h1 class="text-center" style="margin-bottom: .5rem;">Details</h1>
            <div class="card-body">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" style="border-right: 1px solid #efefef;">
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Code</div>
                        <div class="col-xs-8"  style="">{{$member->code}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Email</div>
                        <div class="col-xs-8"  style="">{{$member->email}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">NIK</div>
                        <div class="col-xs-8"  style="">{{$member->nik}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Name</div>
                        <div class="col-xs-8"  style="">{{$member->name}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Phone</div>
                        <div class="col-xs-8"  style="">{{$member->phone}}</div>
                    </div>
                     <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Gender</div>
                        <div class="col-xs-8"  style="">{{$member->gender}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Member Type</div>
                        <div class="col-xs-8"  style="">{{$member->member_type->name}}</div>
                    </div>
                   
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="col-xs-12" >
                        @php
                            $d1 = new DateTime(date("Y-m-d"));
                            $d2 = new DateTime($member->birth_date);

                            $diff = $d2->diff($d1);
                        @endphp
                        <div class="col-xs-4" style="">Age</div>
                        <div class="col-xs-8"  style="">{{$diff->y}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Address</div>
                        <div class="col-xs-8"  style="">{{$member->address}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Province</div>
                        <div class="col-xs-8"  style="">{{$member->province}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">District</div>
                        <div class="col-xs-8"  style="">{{$member->district}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Zipcode</div>
                        <div class="col-xs-8"  style="">{{$member->zipcode}}</div>
                    </div>
                     <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Created at</div>
                        <div class="col-xs-8"  style="">{{$member->created_at}}</div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Last Updated</div>
                        <div class="col-xs-8"  style="">{{$member->updated_at}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    /*METHOD - METHOD UMUM ATAU KESELURUHAN
     * Khusus method" PENOPANG PADA HALAMAN INI
     */
    function _(el) {
        return document.getElementById(el);
    }
    
    var startDate = "<?php echo (isset($_GET["start_date"]) ? $_GET["start_date"] : "") ?>";
    var endDate = "<?php echo (isset($_GET["end_date"]) ? $_GET["end_date"] : "") ?>";
    if(startDate!=""){
        $("#startDate").val(startDate);
    }
    if(endDate!=""){
        $("#endDate").val(endDate);
    }
</script>
@endsection

