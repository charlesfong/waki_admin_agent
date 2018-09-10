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
@endsection