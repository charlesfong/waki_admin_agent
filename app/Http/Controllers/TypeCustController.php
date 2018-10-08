<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\TypeCust;
use DB;

class TypeCustController extends Controller
{
    public function index(Request $request)
    {
    	$typecusts = TypeCust::when($request->keyword, function($query) use ($request) {
    		$query->where('name', 'like', "%{$request->keyword}%")
                ->where('active', true)
                ->orWhere('type_input', 'like', "%{$request->keyword}%")
                ->where('active', true);
    	})->where('active', true)->paginate(10);

    	$typecusts->appends($request->only('keyword'));

        return view('typecust', compact('typecusts'));
    }

    public function store(Request $request)
    {
        //masukin dalam tampunngan validator dan di cek ada yg salah dengan RULE nya
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type_input' => 'required',
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
        	$typecusts = $request->get('type_input');
            $data = $request->only('name');
            $data['name'] = strtoupper($data['name']);

            foreach ($typecusts as $key => $value)
            {
                if(array_key_exists($key, $request->get('type_input')))
                {
                    $data['type_input'] = strtoupper($key);
	            	TypeCust::create($data); //INSERT INTO DATABASE (with created_at)
                }
            }

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    public function update(Request $request)
    {
        //masukin dalam tampunngan validator dan di cek ada yg salah dengan RULE nya
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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

            $typecust = TypeCust::find($request->get('id'));
            $typecust->fill($data)->save();

            return response()->json(['success'=>'Berhasil !!']);
        }
    }

    public function delete(TypeCust $typecust)
    {
        $typecust->active = false;
        $typecust->save();
        return redirect()->route('type_cust');
    }
}
