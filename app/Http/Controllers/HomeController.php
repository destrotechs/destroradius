<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Charts\userChart;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {       
            $sales=DB::table('transactions')->sum('amount');
            $customers=count(DB::table('customers')->get());
            $plans=DB::table('bundle_plans')->pluck('plantitle');
            $planscost=DB::table('bundle_plans')->pluck('cost');
            $onlineusers=DB::table('radacct')->where('acctstoptime','=',NULL)->count();
            $usersChart = new userChart;
        $usersChart->labels($plans);
        $usersChart->dataset('Plan cost (KES)', 'line', $planscost)->options(['fill'=>'true','borderColor'=>'red','backgroundcolor'=>'rgb(255, 99, 132)']);

        return view('home',compact('sales','customers','usersChart','onlineusers'));
    }
    public function getAllCustomers(Request $request){
        $customers=DB::table('customers')->get();
                    // ->leftjoin('radcheck','radcheck.username','=','customers.username')
                    // ->leftjoin('radreply','radreply.username','=','customers.username')->get();
        return view('pages.allcustomers',compact('customers'));
    }
    public function getNewCustomer(Request $request){
        if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
        $radgroupcheck=DB::table('radgroupcheck')->distinct()->get();
        $radgroupreply=DB::table('radgroupreply')->distinct()->get();
        $limitattributes=DB::table('limitattributes')->distinct()->get();
        return view('pages.newcustomer',compact('radgroupcheck','radgroupreply','limitattributes'));
    }
    public function postNewCustomer(Request $request){
        //validate info
        $request->validate([
            'username'=>['required','unique:radcheck','unique:customers'],
            'cleartextpassword'=>['required','min:4','max:8'],
            'name'=>['required'],
            'phone'=>['required','max:10','min:10']
        ]);

        //details
        $attribute=$request->get('attribute');
        $username=$request->get('username');
        $attributevalue=$request->get('value');
        $op=$request->get('op');
        $type=$request->get('type');
        $hashedpassword=Hash::make($request->get('cleartextpassword'));
        //add user to customers table

        $customer=DB::table('customers')->insert([
            'name'=>$request->get('name'),'username'=>$request->get('username'),'password'=>$hashedpassword,'cleartextpassword'=>$request->get('cleartextpassword'),'phone'=>$request->get('phone'),'email'=>$request->get('email'),
        ]);

        //add user to radcheck
        $raduser=DB::table('radcheck')->insert([
            'username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$request->get('cleartextpassword'),
        ]);
        if(isset($attribute)){
        for ($i=0; $i < count($attribute); $i++) { 
                if($type[$i]=='reply'){
                    DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );  
                }else{
                    DB::table('radcheck')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );
                }
            
         }
     }
        //if usergroupnot empty,add user to group
     $radusergroup=$request->get('radusergroup');
     if(isset($radusergroup) && $radusergroup!=" "){
        for($i=0;$i<count($radusergroup);$i++){
            if ($radusergroup[$i]!=NULL) {
                $groupuser=DB::table('radusergroup')->updateOrInsert(
                    ['username'=>$username],
                    ['groupname'=>$radusergroup[$i],'priority'=>0]
                );
            }
            
        }
        
     }
        //assign user attributes if given
        return redirect()->back()->with("success","Customer created successfully");
    }
    public function fetchCustomer(){
        return view('pages.editcustomer');
    }
    public function getSpecificCustomer(Request $request,$id){
        $customerinfo=DB::table('customers')->where('id','=',$id)->get();
        $username="";
        foreach ($customerinfo as $key => $c) {
            $username=$c->username;
        }
        $checkattributes=DB::table('radcheck')->where('username','=',$username)->get();
        $replyattributes=DB::table('radreply')->where('username','=',$username)->get();
        $limitattributes=DB::table('limitattributes')->distinct()->get();
        $groups=DB::table('radusergroup')->where('username','=',$username)->get();
        $checkgroups=DB::table('radgroupcheck')->distinct()->get();
        $allgroups=DB::table('radgroupreply')->distinct()->get();
        //$allgroups=array_merge($checkgroups,$replygroups);
        return view('pages.specificcustomer',compact('customerinfo','groups','replyattributes','checkattributes','limitattributes','allgroups'));
    }
    public function postFetchCustomer(Request $request){
        $username=$request->get('username');
        $customerdetails=DB::table('customers')->where('customers.username','=',$username)->get();
        $id=0;
        if (count($customerdetails)>0) {
            foreach ($customerdetails as $key => $c) {
                $id=$c->id;
            }
            return redirect()->route('specificcustomer',['id'=>$id]);
        }else{
            return redirect()->back()->with("error","No customer found under username ".$username);
        }

    }
    public function getNasList(Request $request){
        $nas=DB::table('nas')->get();
        return view('pages.listnas',compact('nas'));
    }
    public function getNewNas(Request $request){
        return view('pages.newnas');
    }
    public function postNewNas(Request $request){
        $request->validate([
            'secret'=>['required'],
            'nasname'=>['required'],
            'shortname'=>['required'],
        ]);
        $newnas=DB::table('nas')->insert([
            'secret'=>$request->get('secret'),'nasname'=>$request->get('nasname'),'shortname'=>$request->get('shortname'),
        ]);
        return redirect()->back()->with("success","Nas saved successfully");
    }
    public function getEditNas(Request $rquest,$id){
        $nas=DB::table('nas')->where('id','=',$id)->get();

        return view('pages.editnas',compact('nas'));
    }
    public function postEditedNas(Request $request){
        $id=$request->get('id');
        $updatenas=DB::table('nas')->where('id','=',$id)->update(['nasname'=>$request->get('nasname'),'secret'=>$request->get('secret'),'shortname'=>$request->get('shortname')]);

        return redirect()->back()->with("success","nas details updated successfully");
    }
    public function getNewLimitAttr(Request $request){
        return view('pages.createlimit');
    }
    public function postNewLimit(Request $request){
        $request->validate([
            'vendor'=>['required'],
            'limitname'=>['required','unique:limitattributes'],
            'type'=>['required'],
            'table'=>['required'],
            'op'=>['required'],
            'description'=>['required'],
        ]);

        $newlimit=DB::table('limitattributes')->insert([
            'vendor'=>$request->get('vendor'),'limitname'=>$request->get('limitname'),'type'=>$request->get('type'),'table'=>$request->get('table'),'op'=>$request->get('op'),'description'=>$request->get('description'),
        ]);
        if ($newlimit) {
            return redirect()->back()->with('success','New Limit created successfully');
        }else{
            return redirect()->back()->with('error','New Limit could not be saved, try again');
        }
    }
    public function getUserlimitGroups(Request $request){
         $limitattributes=DB::table('limitattributes')->distinct()->get();
        return view('pages.userlimitgroups',compact('limitattributes'));
    }
    public function postNewLimitGroup(Request $request){
        $request->validate([
            'groupname'=>['required','unique:radgroupcheck','unique:radgroupreply'],
        ]);
        
        $attribute=$request->get('attribute');
        $attributevalue=$request->get('value');
        $op=$request->get('op');
        $type=$request->get('type');
        $groupname=$request->get('groupname');
        if(isset($attribute)){
        for ($i=0; $i < count($attribute); $i++) { 
                if($type[$i]=='reply'){
                    DB::table('radgroupreply')->updateOrInsert(
                        ['groupname'=>$groupname,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );  
                }else{
                    DB::table('radgroupcheck')->updateOrInsert(
                        ['groupname'=>$groupname,'attribute'=>$attribute[$i]],
                        ['op'=>$op[$i],'value'=>$attributevalue[$i]]
                    );
                }
            
         }
     }
     return redirect()->back()->with("success","Group created successfully");
    }
    public function getAllPayments(Request $request){
        $payments=DB::table('transactions')->get();
        return view('pages.allpayments',compact('payments'));
    }
    public function getInitializePayment(){
        $plans=DB::table('bundle_plans')->get();
        return view('pages.initiatepayment',compact('plans'));
    }
    public function getLastConnectionAtt(Request $request){
        $attempts=DB::table('radpostauth')->orderBy('id','desc')->get();
        return view('pages.connectionattempts',compact('attempts'));
    }
    public function getOnlineusers(){
        $onlineusers=DB::table('radacct')->where('acctstoptime','=',NULL)->orWhere('acctstoptime','=','0000-00-00 00:00:00')->paginate(10);
        return view('pages.onlineusers',compact('onlineusers'));
    }
    public function getUserAccounting(){
        return view('pages.useraccounting');
    }
    public function userAccounting(Request $request){
        $username=$request->get('username');
        $useraccounting=DB::table('radacct')->where('username','=',$username)->get();
        $output='<table class="table table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.($o->acctstoptime-$o->acctstarttime).'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminationcause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this user</td></tr>';
        }
        
        $output.='</tbody></table>';
        echo $output;

    }
    public function getIpAccounting(){
        return view('pages.ipaccounting');
    }
    public function ipAccounting(Request $request){
        $ip=$request->get('ip');
        $useraccounting=DB::table('radacct')->where('framedipaddress','=',$ip)->get();
        $output='<table class="table table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.($o->acctstoptime-$o->acctstarttime).'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminationcause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for this ip</td></tr>';
        }
        
        $output.='</tbody></table>';
        echo $output;
    }
    public function getNasAccounting(){
        return view('pages.nasaccounting');
    }
    public function nasAccounting(Request $request){
        $ip=$request->get('ip');
        $useraccounting=DB::table('radacct')->where('nasipaddress','=',$ip)->get();
        $output='<table class="table table-striped table-bordered table-sm"><thead><tr><th>ID</th><th>username</th><th>Ip Address</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Uplaod</th><th>Download</th><th>Termination Cause</th><th>Nas IP address</th></tr></thead><tbody>';
        if (count($useraccounting)>0) {
           foreach ($useraccounting as $key => $o) {
            $output.='<tr><td>'.$o->radacctid.'</td><td>'.$o->username.'</td><td>'.$o->framedipaddress.'</td><td>'.$o->acctstarttime.'</td><td>'.$o->acctstoptime.'</td><td>'.($o->acctstoptime-$o->acctstarttime).'</td><td>'.$o->acctoutputoctets.'</td><td>'.$o->acctinputoctets.'</td><td>'.$o->acctterminationcause.'</td><td>'.$o->nasipaddress.'</td></tr>';
            }
        }else{
            $output.='<tr><td colspan="10" class="alert alert-danger">No accounting records for nas '.$ip.'</td></tr>';
        }
        
        $output.='</tbody></table>';
        echo $output;
    }
    public function getPlans(Request $request){
        if($request->session()->has('success_message')){
            toast($request->session()->get('success_message'),'success','top-end');  
        }
        if($request->session()->has('error')){
            toast($request->session()->get('error'),'error','top-end');  
        }
        $plans=DB::table('bundle_plans')->get();
        return view('pages.plans',compact('plans'));
    }
    public function postPlan(Request $request){
        $request->validate([
            'plantitle'=>['required','unique:bundle_plans'],
            'planname'=>['required','unique:bundle_plans'],
            'cost'=>['required'],
            'desc'=>['required']
        ]);
    
        $p=DB::table('bundle_plans')->insert([
            ['plantitle'=>$request->get('plantitle'),'planname'=>$request->get('planname'),'cost'=>$request->get('cost'),'desc'=>$request->get('desc')]
        ]);
        if ($p) {
            return redirect()->back()->with("success_message","plan created successfully");
        }
    }
    public function getDeleteRec(){
        return view('pages.deleteaccrec');
    }
    public function postDeleteAcctRec(Request $request){
        $username=$request->get('username');
        $deleterec=DB::table('radacct')->where('username','=',$username)->delete();
        if ($deleterec) {
            echo"success";
        }else{
             echo"Accounting record for ".$username." were not found";
        }
       
    }
    public function getOperators(){
        $operators=DB::table('users')->get();
        return view('pages.operators',compact('operators'));
    }
    public function postOperator(Request $request){
        $request->validate([
            'name'=>['required','string','max:50'],
            'email'=>['unique:users','required','email','string','max:50'],
            'password'=>['required','confirmed','min:6','string','max:20'],
        ]);
        $password=Hash::make($request->get('password'));
        $operator=DB::table('users')->insert(['name'=>$request->get('name'),'email'=>$request->get('email'),'password'=>$password,'created_by'=>$request->get('created_by')]);
        if ($operator) {
           return redirect()->back()->with("success","operator has been added successfully");
        }else{
             return redirect()->back()->with("error","There was trouble creating the new operator, try again");
        }
    }
    public function editOperator(Request $request,$id){
        $operator=DB::table('users')->where('id','=',$id)->get();
        return view('pages.editoperator',compact('operator'));
    }
    public function postEditOperator(Request $request){
        $id=$request->get('id');
        $request->validate([
            'name'=>['required','string','max:50'],
            'email'=>['required','email','string','max:50'],
            'password'=>['required','min:6','string','max:20'],
        ]);
        $password=Hash::make($request->get('password'));
        $operator=DB::table('users')->where('id','=',$id)->update(['name'=>$request->get('name'),'email'=>$request->get('email'),'password'=>$password,'created_by'=>$request->get('created_by')]);
        if ($operator) {
           return redirect()->back()->with("success","operator has been updated successfully");
        }else{
             return redirect()->back()->with("error","There was trouble updating the operator, try again");
        }
    }
    public function deleteOperator(Request $request,$id){
        $user=\App\User::find($id);
        $user->delete();
        return redirect()->back()->with("success","operator deleted successfully");
    }
    public function getPlanEdit(Request $request,$id){
        $plan=DB::table('bundle_plans')->where('id','=',$id)->get();
        return view('pages.editplan',compact('plan'));
    }
    public function postEditPlan(Request $request){
        $id=$request->get('id');
         $request->validate([
            'plantitle'=>['required'],
            'planname'=>['required'],
            'cost'=>['required'],
        ]);
    
        $p=DB::table('bundle_plans')->where('id','=',$id)->update(
            ['plantitle'=>$request->get('plantitle'),'planname'=>$request->get('planname'),'cost'=>$request->get('cost'),'desc'=>$request->get('desc')]
        );
        if ($p) {
            return redirect()->back()->with("success","plan updated successfully");
        }else{
             return redirect()->back()->with("error","plan could not be updated");
        }
    }
    public function deletePlan(Request $request,$id){
        $plan=DB::table('bundle_plans')->where('id','=',$id)->delete();
        if ($plan) {
            return redirect()->back()->with("success","plan deleted successfully");
        }
    }
    public function getCleanStale(){
        return view('pages.cleanstale');
    }
    public function cleanStaleConn(Request $request){
        $username=$request->get('username');
        $staleconn=DB::table('radacct')->where([['username','=',$username],['acctstoptime','=',NULL]])->delete();
        if ($staleconn) {
            echo "success";
        }else{
            echo "failed";
        }
    }
    public function getServiceStatus()
    {
        return view('pages.servicestatus');
    }
    public function saveCustomerChanges(Request $request){
        //dd($request->all());
        $username=$request->get('username');
        $password=Hash::make($request->get('cleartextpassword'));
        $cleartextpassword=$request->get('cleartextpassword');
        $name=$request->get('name');
        $email=$request->get('email');
        $attributes=$request->get('attribute');
        $type=$request->get('type');
        $phone=$request->get('phone');
        $op=$request->get('op');
        $value=$request->get('value');
        $groups=$request->get('groupname');

        //update customer basic info
        $userinfo=DB::table('customers')->updateOrInsert(
            ['username'=>$username],
            ['name'=>$name,'password'=>$password,'phone'=>$phone,'email'=>$email,'cleartextpassword'=>$cleartextpassword]
        );

        //assign user limit attributes 
        if(isset($attributes)){
            for ($i=0; $i < count($attributes); $i++) { 
                if ($type[$i]=='check') {
                    $customercheckattr=DB::table('radcheck')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attributes[$i]],
                        ['op'=>$op[$i],'value'=>$value[$i]]
                    );
                }else{
                     $customerreplyattr=DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$attributes[$i]],
                        ['op'=>$op[$i],'value'=>$value[$i]]
                    );
                }
            }   
        }

        //assign user to groups
         if (isset($groups) && $groups!=" " && count($groups)>0) {
            for ($i=0; $i <count($groups) ; $i++) {
                if ($groups[$i]!=null && $groups[$i]!=" ") {
                    $usergroup=DB::table('radusergroup')->updateOrInsert(
                        ['username'=>$username,'groupname'=>$groups[$i]],
                        ['priority'=>'0']
                    );
                 }                 
            }
        }
        //redirect back

        return redirect()->back()->with("success","Customer details updated successfully");
    }
    public function getUserConnectivity(){
        return view('pages.testconnectivity');
    }
    public function postTestConn(Request $request){
        //radtest testing password localhost 0 testing123
        $cmd="radtest ".escapeshellarg($request->get('username'))." ".escapeshellarg($request->get('password'))." ".escapeshellarg($request->get('server'))." ".escapeshellarg($request->get('nasport'))." ".escapeshellarg($request->get('nassecret'));
        $res=shell_exec($cmd);
        if($res==" " || $res==NULL){
            echo "The command was not executed successfully";

        }else{
            echo $res;
        }
    }
    public function getUserLimits(){
        return view('pages.userlimits');
    }
}
