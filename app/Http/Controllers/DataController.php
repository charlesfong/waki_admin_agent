<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\DataUndangan;
use App\DataOutsite;
use App\DataTherapy;
use App\HistoryUndangan;
use App\Location;
use App\TypeCust;
use App\Mpc;
use App\Branch;
use App\Cso;
use Auth;
use DB;

class DataController extends Controller
{
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT INDEX DATA    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    public function index(Request $request)
	{
		$user = Auth::user();

		/*percabngan bisa masuk salah satu index data
		* kalo bisa masuk all-country atau all branch
		* maka dia bisa buka table salah satu data tersebut
		* sample : "if(all-branch-mpc || all-country-mpc)"
		*/
		if($user->can('all-branch-mpc') || $user->can('all-country-mpc'))
		{
			$dataMpcs = $this->IndexMpc($request, $user);
		}
		if($user->can('all-branch-data-undangan') || $user->can('all-country-data-undangan'))
		{
			$dataUndangans = $this->IndexUndangan($request, $user);
		}
		if($user->can('all-branch-data-outsite') || $user->can('all-country-data-outsite'))
		{
			$dataOutsites = $this->IndexOutsite($request, $user);
		}
		if($user->can('all-branch-data-therapy') || $user->can('all-country-data-therapy'))
		{
			$DataTherapies = $this->IndexTherapy($request, $user);
		}
		$branches = Branch::where('country', $user->branch['country'])->get();

        $branches = Branch::where([['country', $user->branch['country']],['active', true]])->get();
        $csos = Cso::where([['active', true],['branch_id', 1]])->get();

        return view('data', compact('dataMpcs', 'dataUndangans', 'dataOutsites', 'DataTherapies', 'csos', 'branches'));
	}

	/*Function untuk menampilkan data index MPC
	* menggunakan parameter request dan auth pada user itu sendiri
	* jika ada parameter request->keywordMpc, maka
	* akan di cari berdasarkan keyword yang ada di Mpc
	* mengembalikan return data $mpcs
	*/
	function IndexMpc(Request $request, User $user)
	{
        if($user->can('all-branch-mpc'))
        {
            if($user->can('all-country-mpc'))
            {
                $mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request) {
                    $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.phone', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.province', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.district', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.registration_date', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.ktp', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.birth_date', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true);
                })->where('mpcs.active', true)
                ->join('branches', 'mpcs.branch_id', '=', 'branches.id')
                ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
                ->join('users', 'mpcs.user_id', '=', 'users.id')
                ->select('mpcs.*')
                ->paginate(10);

                $mpcs->appends($request->only('keywordMpc'));
            }
            else
            {
            	$mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request) {
                    $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.phone', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.province', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.district', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.registration_date', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.ktp', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.birth_date', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['mpcs.active', true],
	                    ['branches.country', $user->branch['country']]])
                ->join('branches', 'mpcs.branch_id', '=', 'branches.id')
                ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
                ->join('users', 'mpcs.user_id', '=', 'users.id')
                ->select('mpcs.*')
                ->paginate(10);

                $mpcs->appends($request->only('keywordMpc'));
            }
        }
        else
        {
            $mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request) {
                $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
	                ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.phone', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.province', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.district', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.registration_date', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.ktp', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.birth_date', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('csos.name', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ]);
            })
            ->where([
                ['mpcs.active', true],
                ['mpcs.branch_id', $user->branch_id]
            ])
            ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
            ->join('users', 'mpcs.user_id', '=', 'users.id')
            ->select('mpcs.*')
            ->paginate(10);

            $mpcs->appends($request->only('keywordMpc'));
        }

        return $mpcs;
	}

	//blom selesai masih ada masalah dengan history nya...
	function IndexUndangan(Request $request, User $user)
	{
        if($user->can('all-branch-data-undangan'))
        {
            if($user->can('all-country-data-undangan'))
            {
                $mpcs = Mpc::when($request->keywordDataUndangan, function ($query) use ($request) {
                    $query->where('data_undangans.code', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('data_undangans.active', true)
                        ->orWhere('data_undangans.name', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('data_undangans.active', true)
                        ->orWhere('data_undangans.address', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('data_undangans.active', true)
                        ->orWhere('data_undangans.phone', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('data_undangans.active', true)
                        ->orWhere('data_undangans.registration_date', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('data_undangans.active', true)
                        ->orWhere('data_undangans.birth_date', 'like', "%{$request->keywordDataUndangan}%")
                        ->where('data_undangans.active', true)
                        //----------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true)
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where('mpcs.active', true);
                })->where('data_undangans.active', true)
                ->join('branches', 'mpcs.branch_id', '=', 'branches.id')
                ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
                ->join('users', 'mpcs.user_id', '=', 'users.id')
                ->select('mpcs.*')
                ->paginate(10);

                $mpcs->appends($request->only('keywordMpc'));
            }
            else
            {
            	$mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request) {
                    $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.phone', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.province', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.district', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.registration_date', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.ktp', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.birth_date', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('branches.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                        ->where([
                            ['mpcs.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['mpcs.active', true],
	                    ['branches.country', $user->branch['country']]])
                ->join('branches', 'mpcs.branch_id', '=', 'branches.id')
                ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
                ->join('users', 'mpcs.user_id', '=', 'users.id')
                ->select('mpcs.*')
                ->paginate(10);

                $mpcs->appends($request->only('keywordMpc'));
            }
        }
        else
        {
            $mpcs = Mpc::when($request->keywordMpc, function ($query) use ($request) {
                $query->where('mpcs.code', 'like', "%{$request->keywordMpc}%")
	                ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.name', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.address', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.phone', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.province', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.district', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.registration_date', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.ktp', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.birth_date', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('mpcs.gender', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('csos.name', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ])
                    ->orWhere('users.name', 'like', "%{$request->keywordMpc}%")
                    ->where([
		                ['mpcs.active', true],
		                ['mpcs.branch_id', $user->branch_id]
		            ]);
            })
            ->where([
                ['mpcs.active', true],
                ['mpcs.branch_id', $user->branch_id]
            ])
            ->join('csos', 'mpcs.cso_id', '=', 'csos.id')
            ->join('users', 'mpcs.user_id', '=', 'users.id')
            ->select('mpcs.*')
            ->paginate(10);

            $mpcs->appends($request->only('keywordMpc'));
        }

        return $mpcs;
	}

	function IndexOutsite(Request $request, User $user)
	{
        if($user->can('all-branch-data-outsite'))
        {
            if($user->can('all-country-data-outsite'))
            {
                $data_outsites = DataOutsite::when($request->keywordDataOutsite, function ($query) use ($request) {
                    $query->where('data_outsites.code', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.phone', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.province', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.district', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('data_outsites.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('location.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true)
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where('data_outsites.active', true);
                })->where('data_outsites.active', true)
                ->join('branches', 'data_outsites.branch_id', '=', 'branches.id')
                ->join('csos', 'data_outsites.cso_id', '=', 'csos.id')
                ->join('locations', 'data_outsites.location_id', '=', 'locations.id')
                ->join('type_custs', 'data_outsites.type_cust_id', '=', 'type_custs.id')
                ->select('data_outsites.*')
                ->paginate(10);

                $data_outsites->appends($request->only('keywordDataOutsite'));
            }
            else
            {
            	$data_outsites = DataOutsite::when($request->keywordDataOutsite, function ($query) use ($request) {
                    $query->where('data_outsites.code', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.phone', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.province', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.district', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_outsites.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        //------------------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('locations.name', 'like', "%{$request->keywordDataOutsite}%")
                        ->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ])                        
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
						->where([
                            ['data_outsites.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['mpcs.active', true],
	                    ['branches.country', $user->branch['country']]])
                ->join('branches', 'data_outsites.branch_id', '=', 'branches.id')
                ->join('csos', 'data_outsites.cso_id', '=', 'csos.id')
                ->join('locations', 'data_outsites.user_id', '=', 'locations.id')
                ->join('type_custs', 'data_outsites.type_cust_id', '=', 'type_custs.id')
                ->select('data_outsites.*')
                ->paginate(10);

                $data_outsites->appends($request->only('keywordDataOutsite'));
            }
        }
        else
        {
            $data_outsites = DataOutsite::when($request->keywordDataOutsite, function ($query) use ($request) {
                $query->where('data_outsites.code', 'like', "%{$request->keywordDataOutsite}%")
	                ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.address', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.phone', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.province', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.district', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.ktp', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.birth_date', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_outsites.gender', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
		            //------------------------------------------------------------------------------------------
                    ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('users.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ])
                    ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_outsites.active', true],
		                ['data_outsites.branch_id', $user->branch_id]
		            ]);
            })
            ->where([
                ['data_outsites.active', true],
                ['data_outsites.branch_id', $user->branch_id]
            ])
            ->join('csos', 'data_outsites.cso_id', '=', 'csos.id')
            ->join('locations', 'data_outsites.user_id', '=', 'locations.id')
            ->join('type_custs', 'data_outsites.type_cust_id', '=', 'type_custs.id')
            ->select('data_outsites.*')
            ->paginate(10);

            $data_outsites->appends($request->only('keywordDataOutsite'));
        }

        return $data_outsites;
	}

	function IndexTheraphy(Request $request, User $user)
	{
        if($user->can('all-branch-data-therapy'))
        {
            if($user->can('all-country-data-therapy'))
            {
                $data_therapies = DataTherapy::when($request->keywordDataTherapy, function ($query) use ($request) {
                    $query->where('data_therapies.code', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.phone', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.province', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.district', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.registration_date', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('data_therapies.address', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        //----------------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('branches.country', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true)
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where('data_therapies.active', true);
                })->where('data_therapies.active', true)
                ->join('branches', 'data_therapies.branch_id', '=', 'branches.id')
                ->join('csos', 'data_therapies.cso_id', '=', 'csos.id')
                ->join('type_custs', 'data_therapies.type_cust_id', '=', 'type_custs.id')
                ->select('data_therapies.*')
                ->paginate(10);

                $data_therapies->appends($request->only('keywordDataTherapy'));
            }
            else
            {
            	$data_therapies = DataTherapy::when($request->keywordDataTherapy, function ($query) use ($request) {
                    $query->where('data_therapies.code', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.phone', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.province', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.district', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.registration_date', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('data_therapies.address', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        //------------------------------------------------------------
                        ->orWhere('branches.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('csos.name', 'like', "%{$request->keywordDataTherapy}%")
                        ->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ])                      
                        ->orWhere('type_custs.name', 'like', "%{$request->keywordDataTherapy}%")
						->where([
                            ['data_therapies.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })
                ->where([['data_therapies.active', true],
	                    ['branches.country', $user->branch['country']]])
                ->join('branches', 'data_therapies.branch_id', '=', 'branches.id')
                ->join('csos', 'data_therapies.cso_id', '=', 'csos.id')
                ->join('type_custs', 'data_therapies.type_cust_id', '=', 'type_custs.id')
                ->select('data_therapies.*')
                ->paginate(10);

                $data_therapies->appends($request->only('keywordDataTherapy'));
            }
        }
        else
        {
            $data_therapies = DataTherapy::when($request->keywordDataTherapy, function ($query) use ($request) {
                $query->where('data_therapies.code', 'like', "%{$request->keywordDataOutsite}%")
	                ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_therapies.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_therapies.address', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_therapies.phone', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_therapies.province', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_therapies.district', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('data_therapies.registration_date', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
		            //------------------------------------------------------------------------------------------
                    ->orWhere('csos.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('users.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ])
                    ->orWhere('type_custs.name', 'like', "%{$request->keywordDataOutsite}%")
                    ->where([
		                ['data_therapies.active', true],
		                ['data_therapies.branch_id', $user->branch_id]
		            ]);
            })
            ->where([
                ['data_therapies.active', true],
                ['data_therapies.branch_id', $user->branch_id]
            ])
            ->join('csos', 'data_therapies.cso_id', '=', 'csos.id')
            ->join('type_custs', 'data_therapies.type_cust_id', '=', 'type_custs.id')
            ->select('data_therapies.*')
            ->paginate(10);

            $data_therapies->appends($request->only('keywordDataOutsite'));
        }

        return $data_therapies;
	}

	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++    BUAT STORE DATA BARU    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

	/*Function store untuk menambah data pada table Data MPC
	* menggunakan parameter request langsung
	* jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
	* user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
	*/
	public function storeMpc(Request $request)
	{
		if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($request->phone * 23)]);

        $validator = \Validator::make($request->all(), [
            'code' =>  [
                'required',
                Rule::unique('mpcs')->where('active', 1),
            ],
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('mpcs')->where('active', 1),
            ],
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'birth_date' => 'required',
            'ktp' => [
                'required',
                Rule::unique('mpcs')->where('active', 1),
            ],
            'gender' => 'required',
            'cso' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
        	$user = Auth::user();

            $data = $request->only('code', 'registration_date', 'ktp', 'name', 'birth_date', 'gender', 'address', 'phone', 'province', 'district', 'branch', 'cso');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);

            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['user_id'] = $user->get('id');

             $id = DB::table('csos')->insertGetId([
                'code' => $data['code'],
	            'name' => $data['name'],
	            'address' => $data['address'],
	            'registration_date' => $data['registration_date'],
	            'phone' => $data['phone'],
	            'province' => $data['province'],
	            'district' => $data['district'],
	            'birth_date' => $data['birth_date'],
	            'ktp' => $data['ktp'],
	            'gender' => $data['gender'],
	            'branch_id' => $data['branch_id'],
	            'user_id' => $data['user_id'],
	            'cso_id' => $data['cso_id']]);

            return response()->json(['success'=>'Berhasil !!']);
        }
	}

	/*Function store untuk menambah data pada table Data Undangan
	* menggunakan parameter request langsung
	* jadi gk pake request dia jenis nya apa tapi langsung di panggil di route nya
	* user_id bisa di dapet dari Auth->usernya yg lagi online sekarang atau login
	* pertama kali masukin di buat langsung sama masuk ke history-nya
	*/
	public function storeDataUndangan(Request $request)
	{
		if ($request->has('phone') && $request->phone != null)
            $request->merge(['phone'=> ($request->phone * 23)]);

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'registration_date' => 'required',
            'phone' => [
                'required',
                Rule::unique('data_undangans')->where('active', 1),
            ],
            'bank_name' => 'required',
            'province' => 'required',
            'district' => 'required',
            'branch' => 'required',
            'country' => 'required',
            'birth_date' => 'required',
            'cso' => 'required',
            'type_cust' => 'required',
        ]);

        if ($validator->fails())
        {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i=0; $i < count($arr_Keys); $i++) { 
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }
            return response()->json(['errors'=>$arr_Hasil]);
        }
        else {
        	$user = Auth::user();
        	$count = DataUndangan::all()->count();
            $count++;

            $data = $request->only('code', 'registration_date', 'name', 'birth_date', 'address', 'phone', 'bank_name', 'province', 'district');
            $data['name'] = strtoupper($data['name']);
            $data['address'] = strtoupper($data['address']);
            $data['bank_name'] = strtoupper($data['bank_name']);

            //pembentukan kode data undangan
            $name = strtoupper(substr(str_slug($request->get('name'), ""), 0, 3));
            for($i=strlen($count); $i<4; $i++)
            {
                $count = "0".$count;
            }
            $codeDepan = "INV"
            $code = $codeDepan . $name . $count;
            $data['code'] = $code;

            $idDataUndangan = DB::table('csos')->insertGetId([	
                'code' => $data['code'],
	            'name' => $data['name'],
	            'address' => $data['address'],
	            'registration_date' => $data['registration_date'],
	            'phone' => $data['phone']]);

            $data['branch_id'] = $request->get('branch');
            $data['cso_id'] = $request->get('cso');
            $data['user_id'] = $user->get('id');

            $idHistory = DB::table('csos')->insertGetId([
                'code' => $data['code'],
	            'name' => $data['name'],
	            'address' => $data['address'],
	            'registration_date' => $data['registration_date'],
	            'phone' => $data['phone'],
	            'province' => $data['province'],
	            'district' => $data['district'],
	            'birth_date' => $data['birth_date'],
	            'ktp' => $data['ktp'],
	            'gender' => $data['gender'],
	            'branch_id' => $data['branch_id'],
	            'user_id' => $data['user_id'],
	            'cso_id' => $data['cso_id']]);

            return response()->json(['success'=>'Berhasil !!']);
        }
	}
}
