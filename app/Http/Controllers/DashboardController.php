<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataUndangan;
use App\DataOutsite;
use App\DataTherapy;
use App\Mpc;

class DashboardController extends Controller
{
    public function index()
    {
    	$dataUndangans = DataUndangan::where('active', true)->count();
    	$dataOutsites = DataOutsite::where('active', true)->count();
    	$dataTherapies = DataTherapy::where('active', true)->count();
    	$mpcs = Mpc::where('active', true)->count();
    	return view('dashboard', compact('dataUndangans', 'dataOutsites', 'dataTherapies', 'mpcs'));
    }
}
