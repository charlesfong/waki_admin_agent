<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Branch;
use Auth;
use DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->can('all-country-branch'))
        {
            $branches = Branch::when($request->keyword, function ($query) use ($request) {
                $query->where('code', 'like', "%{$request->keyword}%")
                    ->where('active', true)
                    ->orWhere('name', 'like', "%{$request->keyword}%")
                    ->where('active', true)
                    ->orWhere('country', 'like', "%{$request->keyword}%")
                    ->where('active', true);
            })->where('active', true)->paginate(10);

            $branches->appends($request->only('keyword'));
        }
        else
        {
            $branches = Branch::when($request->keyword, function ($query) use ($request) {
                $query->where('code', 'like', "%{$request->keyword}%")
                    ->where('active', true)
                    ->orWhere('name', 'like', "%{$request->keyword}%")
                    ->where('active', true)
                    ->orWhere('country', 'like', "%{$request->keyword}%")
                    ->where('active', true);
            })->where([
                ['branches.active', true],
                ['country', $user->branch['country']]
            ])
            ->paginate(10);

            $branches->appends($request->only('keyword'));
        }
        return view('branches.index', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //masukin dalam tampunngan validator dan di cek ada yg salah dengan RULE nya
        $validator = \Validator::make($request->all(), [
            'code' => 'required|unique:branches',
            'name' => 'required|string|max:255',
            'country' => 'required',
        ]);

        //di cek validasi nya kalo salah masuk IF, kalo berhasil masuk ELSE
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
            $data = $request->only('name');
            $data['name'] = strtoupper($data['name']);
            $data['code'] = strtoupper($request->get('code'));
            $data['country'] = strtoupper($request->get('country'));

            $id = DB::table('branches')->insertGetId([
                'code' => $data['code'], 
                'name' => $data['name'],
                'country' => $data['country']
            ]);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //masukin dalam tampunngan validator dan di cek ada yg salah dengan RULE nya
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country' => 'required',
        ]);

        //di cek validasi nya kalo salah masuk IF, kalo berhasil masuk ELSE
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
            $data = $request->only('name');
            $data['name'] = strtoupper($data['name']);
            $data['country'] = strtoupper($request->get('country'));

            DB::table('branches')
                ->where('id', $request->get('id'))
                ->update(['name' => $data['name'],
                        'country' => $data['country']]);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    public function delete(Branch $branch)
    {
        $branch->active = false;
        $branch->save();
        return redirect()->route('list_branches');
    }
}
