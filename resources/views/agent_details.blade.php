@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/chart/styles.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> -->
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
<div class="col-md-12" style="box-shadow: none;background: transparent;margin-bottom: 0;">
<a class="btn btn-link d-inline float-left" role="button" id="logout" style="color: #048b32;" href="javascript:history.go(-1)">
    <i class="fa fa-arrow-left" style="margin-left:5px;display:inline;margin-right: 5px;"></i>{{ __('Back') }}                
</a>
</div>

<div class="container" style="overflow-x:auto;">
    <div class="col-md-12">
        <div class="card" style="border: none;">
            <h1 class="text-center" style="margin-bottom: .5rem;">Agent Child</h1>
            <div class="card-body">
                
                    <div class="sorting col-xs-12 col-sm-12 col-md-6" style="margin: 0; margin-top: 10px; padding-left: 0;">
                        <h6 style="font-size: 1em;">Filter Member Type</h6>
                        <?php
                            $typeMember = "";
                            $typeAgent = "";
                            $typeVvip = "";
                            if(isset($_GET['membertype']) && strtolower($_GET['membertype']) == 3){
                                $typeMember = "selected";
                            }
                            if(isset($_GET['membertype']) && strtolower($_GET['membertype']) == 4){
                                $typeAgent = "selected";
                            }
                            elseif(isset($_GET['membertype']) && strtolower($_GET['membertype']) == 5){
                                $typeVvip = "selected";
                            }
                           
                        ?>
                        <select id="dropdown_membertype" class="frm-field required sect col-md-10  form-control" style="margin: 0; min-width: 18em;">
                            <option value="">Select Member Type</option>
                            <option value="membertype=3" {{$typeMember}}>
                                  Member
                            </option>
                            <option value="membertype=4" {{$typeAgent}}>
                                  Agent
                            </option>
                            <option value="membertype=5" {{$typeVvip}}>
                                  VVIP
                            </option>
                        </select>
                    </div>
                
                    <div class="sorting col-xs-12 col-sm-12 col-md-6" style="margin: 0; margin-top: 10px; padding-left: 0;">
                        <h6 style="font-size: 1em;">Filter Verified</h6>
                        <?php
                            $statUnverified = "";
                            $statVerified = "";
                            if(isset($_GET['verified']) && strtolower($_GET['verified']) == 0){
                                $statUnverified = "selected";
                            }
                            elseif(isset($_GET['verified']) && strtolower($_GET['verified']) == 1){
                                $statVerified = "selected";
                            }

                        ?>
                        <select id="dropdown_verified" class="frm-field required sect col-md-10  form-control" style="margin: 0; min-width: 18em;">
                            <option value="">Select</option>
                            <option value="verified=0" {{$statUnverified}}>
                                Unverified
                            </option> 
                            <option value="verified=1" {{$statVerified}}>
                                Verified
                            </option>
                        </select>
                    </div>
               
                    <form action="{{route('admin_agent_details',['id'=>$member['id']])}}" method="get">
                        <div class="normal-input" style="margin: 3em 0 4em;">
                            <input type="text" name="membertype" value="<?= (isset($_GET['membertype'])) ? $_GET['membertype'] : '' ?>" hidden/>
                            <input type="text" name="verified" value="<?= (isset($_GET['verified'])) ? $_GET['verified'] : '' ?>" hidden/>
                            <label> 
                                <br/>
                                Start Date
                           </label>
                            <br>
                            <div class="col-xs-12" style="padding: 0;">
                                <input class="form-control" id="startDate" class="" type="date" name="start_date" oninvalid="this.setCustomValidity('Tolong isi kolom ini')" oninput="setCustomValidity('')" value="{{old('birth_date_partner')}}">
                            <span></span>
                            @if ($errors->has('start_date'))
                                <strong style="color: #e3342f;">{{ $errors->first('start_date') }}</strong>
                            @endif
                            </div>
                        </div>
                        <div class="normal-input" style="margin: 3em 0 4em;">
                            <label>
                                End Date
                            </label>
                            <br>
                            <div class="col-xs-12" style="padding: 0;">
                                <input class="form-control" id="endDate" class="" type="date" name="end_date" oninvalid="this.setCustomValidity('Tolong isi kolom ini')" oninput="setCustomValidity('')" value="{{old('birth_date_partner')}}">
                            <span></span>
                            @if ($errors->has('end_date'))
                                <strong style="color: #e3342f;">{{ $errors->first('end_date') }}</strong>
                            @endif
                            </div>
                        </div>
                        <button class="btn btn-default" type="submit" style="background: #048b32; color: #fff; margin-bottom: 20px;">
                                Go
                        </button>
                    </form>
                
                TOTAL: {{$agentChildTotal}}
                    <table class="table table-sm table-bordered" style="width:100%; font-size: 1em;">
                            <thead>
                                <tr>

                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Member Type</th>
                                    <th>Sponsor</th>
                                    <th>Register date</th>
                                    <th>Verified</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agentChilds as $agentChild)
                                <tr>
                                    @if($agentChild->member_type_id > 3)
                                        <td>{{$agentChild['agent_code']}}</td>
                                    @else
                                        <td>{{$agentChild['code']}}</td>
                                    @endif
                                    <td>{{$agentChild['name']}}</td>
                                    <td>{{$agentChild['phone']}}</td>
                                    <td>
                                        <?php
                                               if($agentChild->member_type!=null){
                                                   echo $agentChild->member_type->name;
                                               }                             
                                        ?>
                                    </td>
                                    <td><a href="{{route('admin_agent_details', ['id' => $agentChild->agent['id']])}}">{{$agentChild->agent['agent_code']}}</a></td>
                                    <td>{{$agentChild['created_at']}}</td>
                                    <td>

                                        @if(!empty($agentChild['email_verified_at']))
                                        <span class="label label-success">Verified</span>
                                        @else
                                        <span class="label label-warning">Unverified</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($agentChild['member_type_id']>3)
                                                <span><a href="{{route('admin_agent_details', ['id' => $agentChild['id']])}}"><button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></button></a></span>&nbsp;
                                            
                                        @else
                                                <span><a href="{{route('admin_member_details', ['id' => $agentChild['id']])}}"><button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></button></a></span>&nbsp;
                                            
                                        @endif
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>    
                
                <?php
                    echo $agentChilds->render();
                ?>
                
            </div>
        </div>
        
        
    </div>

    <div class="col-md-12">
        <div class="card" style="border: none;">
            <h1 class="text-center" style="margin-bottom: .5rem;">Agent Details</h1>
            <div class="card-body">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" style="border-right: 1px solid #efefef;">
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Code</div>
                        <div class="col-xs-8"  style="">{{$member->agent_code}}</div>
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
                    <div class="col-xs-12" >
                        <div class="col-xs-4" style="">Agent Type</div>
                        <div class="col-xs-8"  style="">
                        <?php
                                if($member->agent_type!=null){
                                    echo $member->agent_type->name;
                                }                             
                         ?>
                        </div>
                    </div>
                   
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
    var membertype = "<?php echo (isset($_GET["membertype"]) ? "membertype=".$_GET["membertype"] : "") ?>";
    var verified = "<?php echo (isset($_GET["verified"]) ? "verified=".$_GET["verified"] : "") ?>";
    
    $("#dropdown_membertype").change(function () {
        var val = this.value;
        membertype = val;
        
        window.location.href = "{{ route('admin_agent_details',['id'=>$member['id']]) }}" + mergeUrlParam();
       
    });
    
    $("#dropdown_verified").change(function () {
        var val = this.value;
        verified = val;
        window.location.href = "{{ route('admin_agent_details',['id'=>$member['id']]) }}" + mergeUrlParam();

    });
    
    if(startDate!=""){
        $("#startDate").val(startDate);
    }
    if(endDate!=""){
        $("#endDate").val(endDate);
    }
    
    function mergeUrlParam(){
        
        var urlParamArray = new Array();
        var urlParamStr = "";
       
        
        if (membertype!=="") {
            urlParamArray.push(membertype);
        }
        if (verified!=="") {
            urlParamArray.push(verified);
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
@endsection

