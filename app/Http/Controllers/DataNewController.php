<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\MemberPartner;
use App\MemberType;
use App\AgentType;
use App\Utils;
use App\Lang;
use DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class DataNewController extends Controller {

	public function __construct() {
        $this->fetchCompanyInfo();
    }
	public function showadd()
	{
		return view('waki_add');
	}
    
	public function adminListIndex(Request $request) {
        $show = 10;
        if ($request->has('show')) {
            $show = $request->input('show');
        }

        $members = Member::select('members.*')
                ->where('members.active', 1);

        if($request->has('sortby')&& $request->input('sortby')!=""){
            if($request->input('sortby')=="codeasc"){
                $members = $members->orderBy('members.code', 'asc');
            }else if($request->input('sortby')=="codedesc"){
                $members = $members->orderBy('members.code', 'desc');
            }else if($request->input('sortby')=="nameasc"){
                $members = $members->orderBy('members.name', 'asc');
            }else if($request->input('sortby')=="namedesc"){
                $members = $members->orderBy('members.name', 'desc');
            }else if($request->input('sortby')=="regdateasc"){
                $members = $members->orderBy('members.created_at', 'asc');
            }else if($request->input('sortby')=="regdatedesc"){
                $members = $members->orderBy('members.created_at', 'desc');
            }else if($request->input('sortby')=="agentchildsasc"){
                $members = $members->orderBy('total_agent_child', 'asc');
            }else if($request->input('sortby')=="agentchildsdesc"){
                $members = $members->orderBy('total_agent_child', 'desc');
            }
        }else{
            $members = $members->orderBy('members.updated_at', 'desc');
        }
        
        if($request->has('keyword') && $request->input('keyword')!=""){
            $members = $members->where(function($q) use($request) {
                                    $q->where('members.code', 'like', '%'.$request->input('keyword').'%')
                                      ->orWhere('members.name', 'like', '%'.$request->input('keyword').'%')
                                      ->orWhere('members.phone', 'like', '%'.$request->input('keyword').'%');
                                   });
        }
         $members = $members->where('members.member_type_id',3);    
        
         if($request->has('verified')&& $request->input('verified')!=""){
             if($request->input('verified')==1){
                $members = $members->whereNotNull('members.email_verified_at');
             }else{
                $members = $members->whereNull('members.email_verified_at');
             }
        }
                    
        $members = $members->paginate($show)->appends(request()->except('page'));
        
      
        $memberTypes = \App\MemberType::where("active",1)->get();

        return view('waki', compact('members', 'memberTypes'));
    }
    public function edit(Request $request) {
        if ($request->has('id')) {
            $member = Member::find($request->get('id'));
            return response()->json(['result' => $member]);
        } else {
            return response()->json(['result' => 'Gagal!!']);
        }
    }
    public function update(Request $request) {
        // return $request;
        $validator = \Validator::make($request->all(), [
                    // 'member_type_id' => 'required',
                    // 'id' => 'required',
        ]);
        if ($validator->fails()) {
            $arr_Errors = $validator->errors()->all();
            $arr_Keys = $validator->errors()->keys();
            $arr_Hasil = [];
            for ($i = 0; $i < count($arr_Keys); $i++) {
                $arr_Hasil[$arr_Keys[$i]] = $arr_Errors[$i];
            }

            // return response()->json(['errors' => $arr_Hasil]);
        } else {
            $member = Member::find($request->input('id'));
            $IdAgent = Member::where([['agent_id', $member->agent['id']], ['member_type_id', 4]])->count()+1;
            $parentCode = $member->agent['agent_code'];
            
            $Agent_type_id = Member::where('id', $member->agent['id'])->first()['agent_type_id']+1;
            if($Agent_type_id>5){
                $Agent_type_id == 5;
            }
            $finalAgentCode = $parentCode.'-'.$IdAgent;
            while(true){
                if(Member::where('agent_code', $finalAgentCode)->count()==0){
                    break;
                }else{
                     $finalAgentCode = $parentCode.'-'.($IdAgent+1);
                }
            }

            $birth_date = $request->get('birth_year').'-'.$request->get('birth_month').'-'.$request->get('birth_day');
            $birth_date = date('Y-m-d', strtotime($birth_date));

            $member->nik=$request->get('nik');
            $member->agent_code = $request->get('agentcode');
            $member->name = $request->get('name');
            $member->email = $request->get('email');
            $member->phone = $request->get('phone');
            $member->address = $request->get('address');
            $member->birth_date = $birth_date;
            $member->province = $request->get('province');
            $member->district = $request->get('district');
            $member->zipcode = $request->get('zipcode');

            $member->save();

            return redirect(route('waki'));
        }
    }
    public function delete(Request $request) {
        $member = Member::find($request->input('id'));
        $member->active = 0;
        $member->save();
        return redirect(route('waki'));
    }
    public function adminAgentDetailsIndex($id,Request $request){
        $member = Member::find($id);
        
        $agentChilds = Member::where('agent_id',$id);
        $agentChildTotal = Member::where('agent_id',$id);

        if($request->has('start_date')&&$request->has('end_date')&&!empty($request->input('end_date'))&&!empty($request->input('end_date'))){
            $agentChilds = $agentChilds->whereDate('created_at','>=',$request->input('start_date'))
                                               ->whereDate('created_at','<=',$request->input('end_date')) ;
            
            $agentChildTotal = $agentChildTotal->whereDate('created_at','>=',$request->input('start_date'))
                                               ->whereDate('created_at','<=',$request->input('end_date')) ;
        }
        
        if($request->has('membertype') && $request->input('membertype')!=""){
            $agentChilds = $agentChilds->where('members.member_type_id',$request->input('membertype'));
            $agentChildTotal = $agentChildTotal->where('members.member_type_id',$request->input('membertype'));
        }
        
         if($request->has('verified')&& $request->input('verified')!=""){
             if($request->input('verified')==1){
                $agentChilds = $agentChilds->whereNotNull('members.email_verified_at');
                $agentChildTotal = $agentChildTotal->whereNotNull('members.email_verified_at');
             }else{
                $agentChilds = $agentChilds->whereNull('members.email_verified_at');
                $agentChildTotal = $agentChildTotal->whereNull('members.email_verified_at');
             }
        }
        
        $agentChilds = $agentChilds->paginate(10)->appends(request()->except('page'));
        $agentChildTotal = count($agentChildTotal->get());
        return view('agent_details', compact('member','agentChilds','agentChildTotal'));
    }
    public function adminDetailsIndex($id,Request $request) {
        $member = Member::find($id);
        
        $agentChilds = Member::where('agent_id',$id);
        $agentChildTotal = Member::where('agent_id',$id);

        if($request->has('start_date')&&$request->has('end_date')&&!empty($request->input('start_date'))&&!empty($request->input('end_date'))){
            $agentChilds = $agentChilds->whereDate('created_at','>=',$request->input('start_date'))
                                               ->whereDate('created_at','<=',$request->input('end_date')) ;
            
            $agentChildTotal = $agentChildTotal->whereDate('created_at','>=',$request->input('start_date'))
                                               ->whereDate('created_at','<=',$request->input('end_date')) ;
        }
        
        $agentChilds = $agentChilds->paginate(10)->appends(request()->except('page'));
        $agentChildTotal = count($agentChildTotal->get());
        return view('member_details', compact('member','agentChilds','agentChildTotal'));
    }

    //copas registercontroller
    protected function validator(array $data)
    {
        
        $messages = [
            'email.unique' => Lang::getEmailAlreadyRegistered(),
            'phone.unique' => Lang::getPhoneNumberAlreadyRegistered(),
            'phone.numeric' => Lang::getPhoneMustBeNumber(),
            //'password.confirmed' => Lang::getPasswordDoesntMatch(),
            //'password.min' => Lang::getPasswordMinimum8Char(),
            'name.required' => Lang::getNameRequired(),
            'phone.required' => Lang::getPhoneRequired(),
            'nik.required' => Lang::getNikRequired(),
            'address.required' => Lang::getAddressRequired(),
            'gender.required' => Lang::getGenderRequired(),
            'province.required' => Lang::getProvinceRequired(),
            'district.required' => Lang::getDistrictRequired(),
            'birth_year.required' => Lang::getBirthdateRequired(),
            'zipcode.required' => Lang::getZipcodeRequired(),
            'nik.unique' => Lang::getIdCardAlreadyRegistered(),
            'nik.min' => Lang::getIdCardMin6Character(),
        ];
        if(!empty($data["email"])){
            $validation = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', Rule::unique('member_partners')->where('active', 1), Rule::unique('members')->where('active', 1)],
                'phone' => ['required', 'numeric',  Rule::unique('members')->where('active', 1)],
                //'password' => ['required', 'string', 'min:6', 'confirmed'],
                'address' => ['required', 'string'],
                'gender' => ['required'],
                'province' => ['required'],
                'district' => ['required'],
                'birth_year' => ['required'],
                'zipcode' => ['required'],
                'nik' => ['required', 'string',  Rule::unique('members')->where('active', 1)],
            ], $messages);
        }else{
            $validation = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'numeric',  Rule::unique('members')->where('active', 1)],
                //'password' => ['required', 'string', 'min:6', 'confirmed'],
                'address' => ['required', 'string'],
                'gender' => ['required'],
                'province' => ['required'],
                'district' => ['required'],
                'birth_year' => ['required'],
                'zipcode' => ['required'],
                'nik' => ['required', 'string',  Rule::unique('members')->where('active', 1)],
            ], $messages);
        }
         
        
        return $validation;
    }

    protected function validatorPartner(array $data)
    {
        $messages = [
            'phone_partner.unique' => Lang::getPhoneNumberAlreadyRegistered(),
            'phone_partner.numeric' => Lang::getPhoneMustBeNumber(),
            'email_partner.unique' => Lang::getEmailAlreadyRegistered(),
        ];
        return Validator::make($data, [
            'phone_partner' => ['required', 'numeric', 'unique:member_partners,phone'],
            'email_partner' => ['email', 'unique:member_partners,email', 'unique:members,email'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $agent_id = null;
        if(isset($data['agent_code']) || $data['agent_code'] == ""){
            $agent_id = Member::where('agent_code', $data['agent_code'])->first()['id'];
        }
        
        $partner_id = null;
        if(isset($data['married'])){
            if($data['married'] == 'true'){
                $data['married'] = true;
                $partner_id = $this->createPartner($data);
            }
            else{
                $data['married'] = false;
            }  
        }
        else {
            $data['married'] = false;
        }

        $code = null;
        if(strtoupper(substr($data['agent_code'], 0, 2)) == "WK" && strlen($data['agent_code']) == 6){
            $asal = $data['agent_code'];
            $code = "M".$asal."-".$data['nik'];
        }
        else {
            $code = "U"."-".$data['nik'];
        }
        $phone = Utils::phoneNumberFormat($data['phone']);
        $pass = substr($data['nik'],-6);
        $birth_date = $data['birth_year'].'-'.$data['birth_month'].'-'.$data['birth_day'];
        $birth_date = date('Y-m-d', strtotime($birth_date));
        return Member::create([
            'code' => $code,
            'name' => $data['name'],
            'email' => $data['email'],
            'nik' => $data['nik'],
            'phone' => $phone,
            'birth_date' => $birth_date,
            'address' => $data['address'],
            'province' => $data['province'],
            'district' => $data['district'],
            'zipcode' => $data['zipcode'],
            'password' => Hash::make($pass),
            'member_type_id' => 3, // MEMBER TYPE = 'MEMBER'
            'gender' => $data['gender'],
            'married' => $data['married'],
            'member_partner_id' => $partner_id['id'],
            'agent_id' => $agent_id,
            'nik_image' => null, //sementara blom upload foto
        ]);
    }

    protected function createPartner(array $data)
    {
        $phone = Utils::phoneNumberFormat($data['phone_partner']);
        $partner_id = MemberPartner::create([
                        'name' => $data['name_partner'],
                        'phone' => $phone,
                        'email' => $data['email_partner'],
                        'gender' => $data['gender_partner'],
                        'birth_date' => $data['birth_date_partner'],
                    ]);
        return $partner_id;
    }
     /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if(isset($request->married)){
            if($request->married == "true"){
                $this->validatorPartner($request->all())->validate();
                $request->merge([
                    'phone_partner' => Utils::phoneNumberFormat($request->phone_partner)
                ]);
                $this->validatorPartner($request->all())->validate();
            }
        }
        
        $birth_date = $request->birth_year.'-'.$request->birth_month.'-'.$request->birth_day;
        $birth_date = date('Y-m-d', strtotime($birth_date));

        $this->validator($request->all())->validate();
        $request->merge([
                'phone' => Utils::phoneNumberFormat($request->phone)
            ]);
        $this->validator($request->all())->validate();
        $member = $this->create($request->all());
        event(new Registered($member));
        
        //Auth::guard('member')->login($member);
        $member->sendRegistrationSuccess($member);

        $request->session()->put('success_registermember', "1");
        // return $this->registered($request, $member)
        //                 ?: redirect($this->redirectPath());
        
        return redirect()->route('waki');
    }
    
    public function registerApi(Request $request)
    {
        $validator = $this->validator($request->all());
        //first check the phone and other stuff, is null or not
        if ($validator->fails()) {
            $response = ['errors' => $validator->errors()];
            $response += ['validationError' => 1];
            return response()->json($response, 401);
        }
        // if success, merge phone into correct phone format
        $request->merge([
                'phone' => Utils::phoneNumberFormat($request->phone)
            ]);
        // validate again 
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            $response = ['errors' => $validator->errors()];
            $response += ['validationError' => 1];
            return response()->json($response, 401);
        }
        
        try{
            $member = $this->create($request->all());
            event(new Registered($member));
            $member->sendRegistrationSuccess($member);

            return response()->json($member, 201);
        }
        catch(\Exception $e){
            $response = ['errors' => $e->getMessage()];
            return response()->json($response, 401);
        }

    }
    //end of kopas
    public function getAgentByCode(Request $request) {
        return Member::select('name', 'agent_type_id')
                        ->where('agent_code', $request->input('agentcode'))
                        ->where('member_type_id', '>=', 4)
                        ->first();
    }
}
