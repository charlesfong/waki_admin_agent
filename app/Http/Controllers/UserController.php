<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Branch;
use App\Role;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->can('all-branch-user'))
        {
            if($user->can('all-country-user'))
            {
                $users = User::when($request->keyword, function ($query) use ($request) {
                    $query->where('users.code', 'like', "%{$request->keyword}%")
                        ->where('users.active', true)
                        ->orWhere('users.name', 'like', "%{$request->keyword}%")
                        ->where('users.active', true)
                        ->orWhere('users.username', 'like', "%{$request->keyword}%")
                        ->where('users.active', true)
                        ->orWhere('branches.name', 'like', "%{$request->keyword}%")
                        ->where('users.active', true);
                        ->orWhere('branches.country', 'like', "%{$request->keyword}%")
                        ->where('users.active', true);
                })->where('users.active', true)
                ->join('branches', 'users.branch_id', '=', 'branches.id')
                ->select('users.*')
                ->paginate(10);

                $users->appends($request->only('keyword'));
            }
            else
            {
                $users = User::when($request->keyword, function ($query) use ($request) {
                    $query->where('users.code', 'like', "%{$request->keyword}%")
                        ->where([
                            ['users.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('users.name', 'like', "%{$request->keyword}%")
                        ->where([
                            ['users.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('users.username', 'like', "%{$request->keyword}%")
                        ->where([
                            ['users.active', true],
                            ['branches.country', $user->branch['country']]
                        ])
                        ->orWhere('branches.name', 'like', "%{$request->keyword}%")
                        ->where([
                            ['users.active', true],
                            ['branches.country', $user->branch['country']]
                        ]);
                })->where([
                    ['users.active', true],
                    ['branches.country', $user->branch['country']]
                ])
                ->join('branches', 'users.branch_id', '=', 'branches.id')
                ->select('users.*')
                ->paginate(10);

                $users->appends($request->only('keyword'));
            }
        }
        else
        {
            $users = User::when($request->keyword, function ($query) use ($request) {
                $query->where('code', 'like', "%{$request->keyword}%")
                    ->where([
                        ['active', true],
                        ['branch_id', $user->branch_id]
                    ])
                    ->orWhere('name', 'like', "%{$request->keyword}%")
                    ->where([
                        ['active', true],
                        ['branch_id', $user->branch_id]
                    ])
                    ->orWhere('username', 'like', "%{$request->keyword}%")
                    ->where([
                        ['active', true],
                        ['branch_id', $user->branch_id]
                    ]);
            })->where([
                ['active', true],
                ['branch_id', $user->branch_id]
            ])
            ->paginate(10);

            $users->appends($request->only('keyword'));
        }

        $roles = Role::orderBy('name')->pluck('name', 'id');
        $branches = Branch::orderBy('name')->pluck('name', 'id');
        return view('users.index', compact('branches', 'roles', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|',
            'role' => 'required|exists:roles,id',
            'branch' => 'required|exists:branches,id',
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
            $role = Role::find($request->get('role')); //ambil role sesuai id
            $count = User::all()->count();
            $count++;

            $data = $request->only('name', 'username');
            $data['name'] = strtoupper($data['name']);
            $data['username'] = strtoupper($data['username']);

            for($i=strlen($count); $i<4; $i++)
            {
                $count = "0".$count;
            }
            $code = "EMP-" . $count;

            $data['code'] = $code;
            $data['password'] = Hash::make($request->get('password'));
            $data['branch_id'] = $request->get('branch');
            $data['permissions'] = $role->permissions;

            $id = DB::table('users')->insertGetId([
                'code' => $data['code'], 
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => $data['password'],
                'permissions' => $data['permissions'],
                'branch_id' => $data['branch_id']
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->whereNot('id', $request->get('id'))->where('active', 1),
            ],
            'branch' => 'required|exists:branches,id',
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
        else 
        {
            $data = $request->only('name', 'username');
            $data['branch_id'] = $request->get('branch');

            $userParam = User::where([['active', true],['id', $request->get('id')]])->get();

            $userpermiss = json_decode($userParam['permissions'], true);
            foreach ($userpermiss as $key => $value)
            {
                if(array_key_exists($key, $request->permissions))
                {
                    $userpermiss[$key] = true;
                }
                else
                {
                    $userpermiss[$key] = false;
                }
            }
            $data['permissions'] = json_encode($userpermiss);

            DB::table('users')
                ->where('id', $request->get('id'))
                ->update(['name' => $data['name'],
                        'username' => $data['username'],
                        'permissions' => $data['permissions'],
                        'branch_id' => $data['branch_id']]);

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    public function delete(User $user)
    {
        $user->active = false;
        $user->save();
        return redirect()->route('list_users');
    }
}
