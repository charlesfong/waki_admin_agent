@extends('layouts.template')
@section('navmenu')
    @if(Gate::check('dashboard'))
    <li> <a href="{{route('dashboard')}}">Dashboard</a></li>
    @endif

    @if(Gate::check('master-data'))
    <li class="list-selected">Master Data</li>
    @endif

    @if(Gate::check('master-data-type'))
    <li> <a href="">Master Data Type</a></li>
    @endif

    @if(Gate::check('master-branch'))
    <li> <a href="">Master Branch</a></li>
    @endif

    @if(Gate::check('master-cso'))
    <li> <a href="">Master CSO</a></li>
    @endif

    @if(Gate::check('master-user'))
    <li> <a href="">Master User</a></li>
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
                <a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1" aria-selected="true">Data Undangan</a>
            </li>
            @endif
            @if(Gate::check('find-data-outsite'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-2" aria-selected="true">Data Outsite</a>
            </li>
            @endif
            @if(Gate::check('find-data-therapy'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-3" aria-selected="true">Data Therapy</a>
            </li>
            @endif
            @if(Gate::check('find-mpc'))
            <li class="nav-item">
                <a class="nav-link" role="tab" data-toggle="tab" href="#tab-4" aria-selected="true">MPC</a>
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
                        <button class="btn btn-light border" type="submit" id="btnFind-data-undangan">Search</button>
                    </div>
                    <span class="invalid-feedback">
                        <strong style="margin-left: 40px; font-size: 12pt;">Phone Number not Found</strong>
                    </span>
                </div>
            </form>
            @endif

            @if(Gate::check('add-data-undangan'))
            <form method="POST" action="">
                {{ csrf_field() }}

                <h1 class="text-center" style="margin-bottom: .5rem;">Add Data Undangan</h1>
                <br>
                <div class="form-group">
                    <span>TYPE INVITATION</span>
                    <select id="type_cust" class="text-uppercase form-control" name="type_cust" value="" required>
                        <optgroup label="TYPE INVITATION"> 
                            <option value="" disabled selected>SELECT TYPE INVITATION</option>
                            <option>FACEBOOK</option>
                            <option>UNDAGAN HUT</option>
                            <option>UNDANGAN BANK</option>
                            <option>TELKOMSEL</option>
                            <option>MGM</option>
                            <option>WHATSAPP</option>
                        </optgroup>
                    </select>
                </div>
                <div id="input-DataUndangan" class="d-none">
                    <div class="form-group">
                        <span>REGISTRATION DATE</span>
                        <input type="date" name="registration_date" class="text-uppercase form-control" required>
                    </div>
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <span>NAME</span>
                        <input type="text" name="name" class="text-uppercase form-control" required>
                    </div>

                    <!-- BIRTH DATE -->
                     <div class="form-group">
                        <span>BIRTH DATE</span>
                        <input type="date" name="birth_date" class="text-uppercase form-control"required>
                    </div>

                    <div class="form-group">
                        <span>ADDRESS</span>
                        <textarea name="address" class="text-uppercase form-control form-control-sm" placeholder="Address" required></textarea>
                    </div>
                    <div class="form-group frm-group-select">
                        <span>COUNTRY</span>
                        <select id="country" class="text-uppercase form-control" name="country" value="" required>
                            <optgroup label="Country">
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>BRANCH</span>
                        <select id="branch" class="form-control" name="branch" value="" required>
                            <optgroup label="Branch">
                                @can('all-branch-data-undangan')
                                    @can('all-country-data-undangan')
                                        <!-- <option value="" disabled selected>SELECT COUNTRY FIRST</option> -->
                                        @php
                                            $temp_branch = old('branch');
                                        @endphp

                                        @foreach ($branches as $branch)
                                            @if($temp_branch == $branch->id)
                                                <option value="{{$branch->id}}" selected>{{$branch->code}} - {{$branch->name}}</option>
                                            @else
                                                <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->name}}</option>
                                            @endif
                                        @endforeach
                                    @endcan
                                    @cannot('all-country-data-undangan')
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
                        @if ($errors->has('branch'))
                            <span class="help-block">
                                <strong>{{ $errors->first('branch') }}</strong>
                            </span>
                        @endif
                    </div>


                    <!-- CSO -->
                    <div class="form-group" >
                        <span>CSO</span>
                        <select id="cso" class="form-control" name="cso" value="" required>
                            <optgroup label="Cso">
                                @php
                                $idxCso = 0;
                                @endphp
                                @foreach ($csos as $cso)
                                    <option value="{{$cso->id}}">{{$cso->name}}</option>
                                    @php
                                    $idxCso++;
                                    @endphp
                                @endforeach
                                @if($idxCso == 0)
                                    <option value="" disabled selected>CSO NOT FOUND</option>
                                @endif
                            </optgroup>
                        </select>
                    </div>

                    <!-- OFFLINE -->
                    <div class="form-group frm-group-select">
                        <span>PROVINCE</span>
                        <select id="province" class="text-uppercase form-control" name="province" value="" required>
                            <optgroup label="Province">
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group frm-group-select select-right">
                        <span>DISTRICT</span>
                        <select id="district" class="form-control" name="district" value="" required>
                            <optgroup label="District">
                                <option value="" disabled selected>SELECT PROVINCE FIRST</option>
                            </optgroup>
                        </select>
                    </div>
                    <!-- OFFLINE -->

                    <div class="form-group">
                        <span>PHONE</span>
                        <input type="number" name="phone" class="form-control" value="" placeholder="0XXXXXXXXXXX" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" disabled="">SAVE</button>
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
        </div>
    </div>
</div>

@if(Gate::check('browse-data-undangan'))
<div id="list-member" class="container" style="overflow-x: auto;"><h1 style="text-align: center; color: rgb(80, 94, 108);">List Data Undangan</h1> <form action="http://localhost/waki-customer/public/csos" class="search-form"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i></span></div> <input type="text" name="keyword" value="" placeholder="Search..." class="form-control"> <div class="input-group-append"><button type="submit" class="btn btn-light border">Search</button></div></div></form> <div class="table-responsive table table-striped table-indesktop"><table class="table table-sm table-bordered"><thead><tr><th>REG DATE</th> <th>CODE</th> <th>NAME</th> <th style="display: none;">ADDRESS</th> <th style="display: none;">PROVINCE</th> <th>DISTRICT</th> <th style="display: none;">COUNTRY</th>  <th>PHONE</th>   <th style="display: none;">UNREG DATE</th> <th colspan="2">EDIT/DELETE</th></tr></thead> <tbody name="collection"><tr><td>2018-06-01</td> <td>B40MAR0002</td> <td>MARDIONO</td> <td style="display: none;">Jalan jM9qGmCDfG</td> <td style="display: none;">JAWA TIMUR</td> <td>KOTA SURABAYA</td> <td style="display: none;">INDONESIA</td>  <td>02614980.2173913</td>   <td style="display: none;"></td> <td><button type="button" name="0" value="1" class="btn btn-primary btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button></td> <td><button type="button" name="0" value="1" class="btn btn-primary btn-deleteCso" style="padding: 0px 5px;"><i class="material-icons">delete</i></button></td></tr>    <tr><td>2018-06-01</td> <td>B40BAG0003</td> <td>BAGUS JAYA</td> <td style="display: none;">Jalan jM9qGmCDfG</td> <td style="display: none;">JAWA TIMUR</td> <td>KOTA SURABAYA</td> <td style="display: none;">INDONESIA</td>  <td>02614980.2173913</td>   <td style="display: none;"></td> <td><button type="button" name="0" value="1" class="btn btn-primary btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button></td> <td><button type="button" name="0" value="1" class="btn btn-primary btn-deleteCso" style="padding: 0px 5px;"><i class="material-icons">delete</i></button></td></tr></tbody></table></div> <div class="card-inmobile"><div class="card" style="margin-bottom: 10px;"><div class="card-body"><h6 class="card-title" style="border-bottom: 0.2px solid black; text-align: center;">B40MAR0002 - MARDIONO<br></h6> <h6 class="text-muted card-subtitle mb-2" style="font-size: 12px;">INDONESIA - GAJAH MADA<br></h6> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Registration Date :</b> 2018-06-01<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Phone :</b> 02614980.2173913<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Commission :</b> 66<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 10px;"><b>Bank Account :</b> 8752519<br></p> <button type="button" name="0" value="1" class="btn btn-primary btn-edithapus-card btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button> <button type="button" name="0" value="1" class="btn btn-primary btn-edithapus-card btn-deleteCso" style="padding: 0px 5px; margin-right: 10px;"><i class="material-icons">delete</i></button></div></div></div> <div class="card-inmobile"><div class="card" style="margin-bottom: 10px;"><div class="card-body"><h6 class="card-title" style="border-bottom: 0.2px solid black; text-align: center;">F01SUP0002 - SUPRIYATNO<br></h6> <h6 class="text-muted card-subtitle mb-2" style="font-size: 12px;">INDONESIA - TIM BUDI<br></h6> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Registration Date :</b> 2018-08-20<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Phone :</b> 08456881574999<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Commission :</b> 10<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 10px;"><b>Bank Account :</b> 25665655<br></p> <button type="button" name="1" value="2" class="btn btn-primary btn-edithapus-card btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button> <button type="button" name="1" value="2" class="btn btn-primary btn-edithapus-card btn-deleteCso" style="padding: 0px 5px; margin-right: 10px;"><i class="material-icons">delete</i></button></div></div></div> <div class="card-inmobile"><div class="card" style="margin-bottom: 10px;"><div class="card-body"><h6 class="card-title" style="border-bottom: 0.2px solid black; text-align: center;">F01SUJ0003 - SUJADI<br></h6> <h6 class="text-muted card-subtitle mb-2" style="font-size: 12px;">INDONESIA - TIM BUDI<br></h6> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Registration Date :</b> 2018-08-23<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Phone :</b> 02342234234<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Commission :</b> 23<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 10px;"><b>Bank Account :</b> 234234235345<br></p> <button type="button" name="2" value="3" class="btn btn-primary btn-edithapus-card btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button> <button type="button" name="2" value="3" class="btn btn-primary btn-edithapus-card btn-deleteCso" style="padding: 0px 5px; margin-right: 10px;"><i class="material-icons">delete</i></button></div></div></div> <div class="card-inmobile"><div class="card" style="margin-bottom: 10px;"><div class="card-body"><h6 class="card-title" style="border-bottom: 0.2px solid black; text-align: center;">B40DON0004 - DONO<br></h6> <h6 class="text-muted card-subtitle mb-2" style="font-size: 12px;">INDONESIA - GAJAH MADA<br></h6> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Registration Date :</b> 2018-08-25<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Phone :</b> 02342234239<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Commission :</b> 10<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 10px;"><b>Bank Account :</b> 2566566521652<br></p> <button type="button" name="3" value="4" class="btn btn-primary btn-edithapus-card btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button> <button type="button" name="3" value="4" class="btn btn-primary btn-edithapus-card btn-deleteCso" style="padding: 0px 5px; margin-right: 10px;"><i class="material-icons">delete</i></button></div></div></div> <div class="card-inmobile"><div class="card" style="margin-bottom: 10px;"><div class="card-body"><h6 class="card-title" style="border-bottom: 0.2px solid black; text-align: center;">B40JOK0005 - JOKO WARDOYO<br></h6> <h6 class="text-muted card-subtitle mb-2" style="font-size: 12px;">INDONESIA - GAJAH MADA<br></h6> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Registration Date :</b> 2018-08-08<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Phone :</b> 015688461654<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 3px;"><b>Commission :</b> 12<br></p> <p class="card-text" style="font-weight: normal; font-size: 14px; margin-bottom: 10px;"><b>Bank Account :</b> 5165168493<br></p> <button type="button" name="4" value="5" class="btn btn-primary btn-edithapus-card btn-editCso" style="padding: 0px 5px;"><i class="material-icons">mode_edit</i></button> <button type="button" name="4" value="5" class="btn btn-primary btn-edithapus-card btn-deleteCso" style="padding: 0px 5px; margin-right: 10px;"><i class="material-icons">delete</i></button></div></div></div> <div class="pagination-wrapper" style="float: right;"></div></div>

<div class="card-inmobile">
        <div class="card" style="margin-bottom:10px;">
            <div class="card-body">
                <h6 class="card-title" style="border-bottom:solid 0.2px black;text-align:center;">MARDIONO<br></h6>
                <h6 class="text-muted card-subtitle mb-2" style="font-size:12px;">F02 - Tim Basori<br></h6>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Registration Date :</b>21-August-2018<br></p>
                <p class="card-text" style="font-weight:normal;font-size:14px;margin-bottom:3px;"><b>Phone :</b> 0861554896111<br></p>
                @if(Gate::check('edit-data-undangan'))
                <button class="btn btn-primary btn-edithapus-card btn-editCso" type="button" style="padding:0px 5px;" name="1" value="1">
                    <i class="material-icons">mode_edit</i>
                </button>
                @endif
                @if(Gate::check('delete-data-undangan'))
                <button class="btn btn-primary btn-edithapus-card btn-deleteCso" type="button" style="padding:0px 5px;margin-right:10px;" name="1" value="1">
                    <i class="material-icons">delete</i>
                </button>
                @endif
            </div>
        </div>
    </div>
@endif

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
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#btnFind-data-undangan').click(function(e){
            e.preventDefault();

            if($("#txt-keywordDataUndangan").val() == "081544468999"){
                $("#txt-keywordDataUndangan").removeClass("is-invalid");
                $('#modal-DataUndangan').modal('show')
                $("#txt-keywordDataUndangan").val("");
            }
            else{
                $("#txt-keywordDataUndangan").addClass("is-invalid");
            }
        });
        $("#type_cust").change(function (e) {
            $("#input-DataUndangan").removeClass("d-none");
        });
    });
</script>
@endsection
