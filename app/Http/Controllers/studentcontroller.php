<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\MailableName;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Database\Schema\Blueprint;

class studentcontroller extends Controller
{
    //
    public function login(Request $req){
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $email = $req->input('email');
        $password = $req->input('password');
    
        $user = DB::table('studentprofile')->where('email', $email)->first();
    
        if ($user) {
            if (Hash::check($password, $user->password)) {
                Session::put('email', $email);
                Session::put('collegecode', $user->collegecode);
                Session::put('department', $user->department);
                Session::put('regno', $user->regno);
                Session::put('name', $user->name);
              
                return redirect('sDashboard')->with([ 'success' => 'Login successful. Welcome, ' . session('email') . '!']);
            }else {
                return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
            }
        } else {
            return redirect('SRegister')->with('error', 'User not found. Please try again.');
        }
    }
    
    public function register(Request $req){
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|ends_with:karpagamtech.ac.in|unique:studentprofile,email',
            'password' => 'required|string|min:8',
            'name'=>'required|string',
            'regno'=>'required|digits:12',
            'phone'=>'required|digits:10',
            'collegecode'=>'required',
            'year'=>'required',
            'department'=>'required',
            'image' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($req->hasFile('image')) { 
            $image = $req->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = "img/";
            $image->move($path, $filename);
            $imagePath = $path . $filename;
        } else {
            $imagePath = null; 
        }
    
        DB::table('studentprofile')->insert([
            'email' => $req->input('email'),
            'password' => bcrypt($req->input('password')),
            'name'=> $req->input('name'),
            'regno'=> $req->input('regno'),
            'phone'=> $req->input('phone'),
            'collegecode'=> $req->input('collegecode'),
            'year'=> $req->input('year'),
            'department'=> $req->input('department'),
            'image'=> $imagePath, // Use $imagePath variable here
        ]);
    
        return redirect('SLogin')->with('success', 'User created successfully.');
    }
    public function sReg($reg){
        $det = DB::table('regevent')->where('regno', $reg)->get();
    
        // Check if the registration number is present in any JSON array in the team_members column
        $teamMemberData = DB::table('team_manager')
            ->orwhere('userreg', $reg)
            ->orwhereRaw('JSON_CONTAINS(team_members, ?)', [$reg]) // Condition to check if $reg is present in any JSON array in the column
            ->get();
        
        $event = DB::table('eventdetail')->get();
        
        return view('registered')->with(['teamMemberData' => $teamMemberData, 'det' => $det, 'event' => $event]);
    }
    
    
    
    public function profile(){
$profile=DB::table('studentprofile')->where('email',session('email'))->first();

return view('stprofile')->with(['profile'=>$profile]);
    }
    public function sDashboard(){
        $check=DB::table('payverify')->where('rollno',session('regno'))->get();
        $prof=DB::table('studentprofile')->where('regno',session('regno'))->get();
        $events = DB::table('fest')->where('completed',0)->get();

        return view('sDashboard')->with(['events'=>$events,'check'=>$check,'prof'=>$prof]);

    }
    public function festdetails(Request $request,  $fest, $department) {

      

      


        Session::put('festname', $fest);
        $regno = session('regno');
    $check = DB::table('payverify')
        ->where('rollno', $regno)
        ->first();

 

        
        // Retrieve events for the specified festival and department
        $data = DB::table('eventdetail')
                    ->where('fest', $fest)
                    ->where('department', $department)
                    ->where('eventtype', 'Closed')
                    ->get();
     
    
        // Retrieve all open events for the festival
        $all = DB::table('eventdetail')
                    ->where('fest', $fest)
                    ->where('eventtype', 'Open')
                    ->get();
        $price = DB::table('fest')
                  ->where('fest_name',$fest)
                  ->get();
                     
        // Retrieve registered events for the current user
        $reg = DB::table('regevent')
                                ->where('regno', session('regno'))
                                ->first(['registered_event']); // Fetch only the registered_event column
    
        // Pass the retrieved data and registered events status to the view
        return view('festdetails')->with([
            'data' => $data,
            'all' => $all,
            'fest' => $fest,
            'department' => $department,
            'reg' => $reg,
            'price'=>$price
        ]);
    
    }
   



    public function plans($fest){
        $fe=DB::table('fest')
        ->where('fest_name',$fest)
        ->get();
        return view('priceplan')->with(['fe'=>$fe]);
    }
    
    
    public function geteventregister($fest, $department){
        $data = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('department', $department)
        ->orWhere('department', 'ALL')
                    ->get();
        $boolean=DB::table('festfeed')->where('email',session('email'))->where('fest', $fest)->get('registered');
                    return view('eventregistration')->with(['data'=>$data,'fest'=>$fest,'registered'=>$boolean]);
    }
   
   public function registrations(Request $request) {
        // Validate the request data
        $request->validate([
            'data' => 'required|array', // Check if data array exists and is not empty
            'fest' => 'required|string',
            'email' => 'required|email',
            'regno' => 'required|string',
            'name' => 'required|string',
            'department' => 'required|string'
        ]);

        // Extract the input data
        $fest = $request->fest;
        $email = $request->email;
        $regno = $request->regno;
        $name = $request->name;
        $department = $request->department;
        $events = $request->data;

        foreach ($events as $eventName) {
        $existingRegistrations = DB::table('allocatemark')
            ->where('fest', $fest)
            ->where('email', $email)
            ->where('event',$eventName)
            ->count();

        if ($existingRegistrations > 0) {
            // If email already exists for the fest, handle accordingly
            return redirect()->back()->with('error', 'You have already registered for events in this fest.');
        }}

        // Store registration data for each selected event
        foreach ($events as $eventName) {
            DB::table('allocatemark')->insert([
                'name' => $name,
                'regno' => $regno,
                'email' => $email,
                'department' => $department,
                'fest' => $fest,
                'event' => $eventName,
               
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

DB::table('festfeed')->insert([
    'fest' => $fest,'email' => $email,'registered'=>True,
]);
        return redirect("/sfest/details/$fest/$department");
    }
    public function indreg($fest,$name){
        $events = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('name',$name)
        
                    ->get();
        return view('indreg')->with(['events'=>$events,'fest'=>$fest,'name'=>$name]);
    }
    public function grpreg($fest,$name){
        $events = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('name',$name)
        
                    ->get();
        return view('grpreg')->with(['events'=>$events,'fest'=>$fest,'name'=>$name]);
    }
    public function individualregistration(Request $request)
    {
        // Retrieve festival details based on the festival name
        $fest = DB::table('fest')
            ->where('fest_name', $request->input('fest'))
            ->first();
    
        if ($fest) {
            // Check if the payment is "Paid"
            $payment = $request->input('payment');
    
            // Check if the user exists
            $existingUser = DB::table('regevent')
                ->where('name', $request->input('name'))
                ->where('dept', $request->input('department'))
                ->first();
    
            if (!$existingUser) {
                // If the user does not exist, insert a new record
                $this->insertNewUser($request);
               
            }
    
            // If the payment is "Paid", further check the user's plan
            if ($payment === "Paid") {
                // Retrieve the user's plan associated with the festival
                $userPlan = DB::table('package_manager')
                    ->where('fest', $request->input('fest'))
                    ->where('regno', session('regno'))
                    ->value('package');
    
                if ($userPlan === "Bronze") {
                    $limit = $fest->brindlimit;
                } elseif ($userPlan === "Silver") {
                    $limit = $fest->siindlimit;
                } else {
                    $limit = $fest->goindlimit;
                }
    
                // Continue with the registration process
                if ($existingUser) {
                    if ($existingUser->registered_event) {
                        $registeredEvents = explode(',', $existingUser->registered_event);
                    } else {
                        $registeredEvents = [];
                    }
                } else {
                    // Handle the case where $existingUser is null
                    $registeredEvents = [];
                }
                
                $newEvent = $request->input('eventname');
    
                if (!in_array($newEvent, $registeredEvents)) {
                    // Check if the user has already registered the maximum allowed events
                    if (count($registeredEvents) <= $limit) {
                        // If the event is not registered and the user has less than the maximum allowed events, proceed with registration
                        $this->updateRegisteredEvents($existingUser, $newEvent, $request);
                        return redirect()->back()->with('success', 'Registration successful!');
                    } else {
                        // If the user has already registered the maximum allowed events, return an error
                        return redirect()->back()->with('error', "You can only register for up to $limit events with the current plan.");
                    }
                } else {
                    // If the event is already registered for the user, return an error
                    return redirect()->back()->with('error', 'You are already registered for this event!');
                }
            } else {
                // Proceed with registration without checking the package manager
                // Continue with the registration process
                if ($existingUser->registered_event) {
                    $registeredEvents = explode(',', $existingUser->registered_event);
                } else {
                    $registeredEvents = [];
                }
                $newEvent = $request->input('eventname');
    
                if (!in_array($newEvent, $registeredEvents)) {
                    // If the event is not registered, proceed with registration
                    $this->updateRegisteredEvents($existingUser, $newEvent, $request);
                    return redirect()->back()->with('success', 'Registration successful!');
                } else {
                    // If the event is already registered for the user, return an error
                    return redirect()->back()->with('error', 'You are already registered for this event!');
                }
            }
        } else {
            // If the festival details are not found, handle the error accordingly
            return redirect()->back()->with('error', 'Festival details not found.');
        }
    }
    
    
    
    
    
    // Function to update registered events
    private function updateRegisteredEvents($existingUser, $newEvent, $request)
    {
        // Append the new event to the existing registered events
        $updatedEvents = null;

        // Check if $existingUser is not null before accessing its properties
        if ($existingUser) {
            $existingEvents = $existingUser->registered_event;
        
            // Concatenate existing events with the new event
            $updatedEvents = $existingEvents ? trim($existingEvents . ',' . $newEvent, ', ') : $newEvent;
        } else {
            // If $existingUser is null, set $updatedEvents to just the new event
            $updatedEvents = $newEvent;
        }
        
    
        // Update the registered_event column
        DB::table('regevent')
            ->where('name', $request->input('name'))
            ->where('dept', $request->input('department'))
            ->update(['registered_event' => $updatedEvents]);
    
            $data = [
                'name' => $request->input('name'), // Assuming the name is stored in the request
                'eventname' => $request->input('eventname') // Assuming the event name is stored in the request
            ];
            // Send email notification since a new event was added for a new user
            $userEmail = $request->session()->get('email'); // Assuming email is stored in session
            Mail::to($userEmail)->send(new MailableName($data));
    }
    
    // Function to insert new user
    private function insertNewUser($request)
    {
        // Insert a new record for the user
        DB::table('regevent')->insert([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'dept' => $request->input('department'),
            'eventdept' => $request->input('eventdept'),
            'registered_event' => $request->input('eventname'), // Insert the event directly
            'regno' => $request->input('regno'),
            'fest' => $request->input('fest'),
            'eventtype'=>$request->input('eventtype'),
            'email'=>$request->input('email'),
            'payment'=>$request->input('payment'),
        ]);
        $data = [
            'name' => $request->input('name'), // Assuming the name is stored in the request
            'eventname' => $request->input('eventname') // Assuming the event name is stored in the request
        ];
        // Send email notification since a new event was added for a new user
        $userEmail = $request->session()->get('email'); // Assuming email is stored in session
        Mail::to($userEmail)->send(new MailableName($data));
        
    }
    
    
    
  

   


    public function teams(Request $request)
    {
        $validator  = $request->validate([
            'team_name' => 'required|string',
            'teamdepartment' => 'required|string',
            'college_name' => 'required|string',
            'mobile_no' => 'required|digits:10',
            'team_leader_email' => 'required|email',
            'team_leader_regno' => 'required|digits:12',
            // Adjusted validation for team members dynamically
            'team_member_*' => 'required|string', // Assuming team member names are required strings
            'team_member_*_email' => 'required|email',
            'team_member_*_regno' => 'required|digits:12',
        ]);
        $fe=$request->input('fest');
     
        if ($this->teamExistsForFest($request->team_name, $fe)) {
            return redirect()->back()->with('error', 'A team with the same name already exists for the current festival.');
        }
        // Get the maximum team size
        $maxTeamSize = DB::table('fest')->where('fest_name', $request->input('fest'))->value('maxteamsize');
       // $teamMemberRegNos = $this->getTeamMemberRegNos($request,$maxTeamSize);
        // foreach ($teamMemberRegNos as $regNo) {
        //     if ($this->registrationNumberExistsForFest($regNo, $fe)) {
        //         return redirect()->back()->with('error', 'One or more team member registration numbers are already associated with another team for the same festival.');
        //     }
        // }
        // Initialize an array to hold team member details
        $teamMemberDetails = [];
    
        // Loop through each team member input field
        for ($i = 1; $i <= $maxTeamSize - 1; $i++) {
            // Check if the input fields for team member $i are set
            if ($request->has('team_member_'.$i) && 
                $request->has('team_member_'.$i.'_regno') && 
                $request->has('team_member_'.$i.'_email')) {
                // Add team member details to the array
                $teamMemberDetails['team_member_'.$i] = $request->input('team_member_'.$i);
                $teamMemberDetails['team_member_'.$i.'_regno'] = $request->input('team_member_'.$i.'_regno');
                $teamMemberDetails['team_member_'.$i.'_email'] = $request->input('team_member_'.$i.'_email');
            }
        }
    
        // Check if the columns already exist in the table
        $existingColumns = Schema::getColumnListing('teams');
    
        // Build the array for column addition
        $addColumnArray = [];
        for ($i = 1; $i <= $maxTeamSize - 1; $i++) {
            $memberColumn = 'team_member_'.$i;
            $memberRegNoColumn = 'team_member_'.$i.'_regno';
            $memberEmailColumn = 'team_member_'.$i.'_email';
    
            // Check if the columns already exist
            if (!in_array($memberColumn, $existingColumns)) {
                $addColumnArray[$memberColumn] = 'string';
            }
            if (!in_array($memberRegNoColumn, $existingColumns)) {
                $addColumnArray[$memberRegNoColumn] = 'string';
            }
            if (!in_array($memberEmailColumn, $existingColumns)) {
                $addColumnArray[$memberEmailColumn] = 'string';
            }
        }
    
        // Add dynamic columns to the table
        if (!empty($addColumnArray)) {
            Schema::table('teams', function ($table) use ($addColumnArray) {
                foreach ($addColumnArray as $columnName => $columnType) {
                    $table->$columnType($columnName)->nullable();
                }
            });
        }
    
        // Insert team details into the database
        $insertData = [
            'team_name' => $request->input('team_name'),
            'team_leader_name' => $request->input('team_leader_name'),
            'team_leader_regno' => $request->input('team_leader_regno'),
            'team_leader_email' => $request->input('team_leader_email'),
            'college_name' => $request->input('college_name'),
            'mobile_no' => $request->input('mobile_no'),
            'fest' => $request->input('fest'),
            'userreg' => $request->input('regno'),
            'dept' => $request->input('teamdepartment'),
            'type' =>'Group',
        ];
  
        // Merge team member details with insert data
        $insertData = array_merge($insertData, $teamMemberDetails);
    
        // Insert into the database
        DB::table('teams')->insert($insertData);
    
        return redirect()->back()->with('success', 'Registration successful!');
    }

    private function getTeamMemberRegNos(Request $request,$maxTeamSize)
    {
        $regNos = [];
        for ($i = 1; $i <= $maxTeamSize; $i++) {
            $regNo = $request->input("team_member_${i}_regno");
            if ($regNo) {
                $regNos[] = $regNo;
            }
        }
        return $regNos;
    }
    
    private function registrationNumberExistsForFest($regNo, $fe)
    {
        $maxTeamSize = DB::table('fest')->where('fest_name', $fe)->value('maxteamsize');
    
        // Check if the registration number exists in the users table
        if (DB::table('teams')->where('userreg', $regNo)->exists()) {
            return true;
        }
    
        // Check if the registration number exists in any of the team member regno columns
        for ($i = 1; $i <= $maxTeamSize; $i++) {
            if (DB::table('teams')->where('team_member_' . $i . '_regno', $regNo)->where('fest', $fe)->exists()) {
                return true;
            }
        }
    
        return false;
    }

    
    
    private function teamExistsForFest($teamName, $fe)
    {
        return DB::table('teams')
            ->where('team_name', $teamName)
            ->where('fest', $fe)
            ->exists();
    }
    
    public function teamsupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|string',
            'teamdepartment' => 'required|string',
            'college_name' => 'required|string',
            'mobile_no' => 'required|digits:10',
            'team_leader_email' => 'required|email',
            'team_leader_regno' => 'required|digits:12',
            // Adjusted validation for team members dynamically
            'team_member_*' => 'required|string', // Assuming team member names are required strings
            'team_member_*_email' => 'required|email',
            'team_member_*_regno' => 'required|digits:12',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
                
        }
        $fe=$request->input('fest');
        
        // Retrieve the existing record for the current user and provided details
        $festMaxTeamSize = DB::table('fest')->where('fest_name', $request->input('fest'))->value('maxteamsize');
        $teamMemberRegNos = $this->getTeamMemberReg($request,$festMaxTeamSize);
        foreach ($teamMemberRegNos as $regNo) {
            if ($this->registrationNumberExistsFor($regNo, $fe)) {
                return redirect()->back()->with('error', 'One or more team member registration numbers are already associated with another team for the same festival.');
            }
        }
        $existingRecord = DB::table('teams')
            ->where('userreg', session('regno'))
            ->where('team_leader_name', $request->input('team_leader_name'))
            ->where('team_leader_regno', $request->input('team_leader_regno'))
            ->where('team_leader_email', $request->input('team_leader_email'))
            ->first();
    
        // If the record exists, update it with the current values; otherwise, return with an error message
        if ($existingRecord) {
            // Construct an array with all the fields to update
            $updateData = [
                'team_name' => $request->input('team_name'),
                'college_name' => $request->input('college_name'),
                'mobile_no' => $request->input('mobile_no'),
                'fest' => $request->input('fest'),
                'dept' => $request->input('teamdepartment'),
                'type' =>'Group',
            ];
    
            // Loop through each team member input field and add to the update data array
            for ($i = 1; $i <= $festMaxTeamSize - 1; $i++) {
                $teamMember = 'team_member_'.$i;
                $teamMemberRegNo = 'team_member_'.$i.'_regno';
                $teamMemberEmail = 'team_member_'.$i.'_email';
    
                // Check if the input fields for team member $i are set
                if ($request->has($teamMember) && $request->has($teamMemberRegNo) && $request->has($teamMemberEmail)) {
                    $updateData[$teamMember] = $request->input($teamMember);
                    $updateData[$teamMemberRegNo] = $request->input($teamMemberRegNo);
                    $updateData[$teamMemberEmail] = $request->input($teamMemberEmail);
                }
            }
    
            // Update the existing record with the constructed update data array
            DB::table('teams')
                ->where('userreg', session('regno'))
                ->where('team_leader_name', $request->input('team_leader_name'))
                ->where('team_leader_regno', $request->input('team_leader_regno'))
                ->where('team_leader_email', $request->input('team_leader_email'))
                ->update($updateData);
    
            return redirect()->back()->with('success', 'Registration updated successfully!');
        } else {
            return redirect()->back()->with('error', 'No existing record found for the current user with provided details.');
        }
    }
    private function getTeamMemberReg(Request $request,$maxTeamSize)
    {
        $regNos = [];
        for ($i = 1; $i <= $maxTeamSize; $i++) {
            $regNo = $request->input("team_member_${i}_regno");
            if ($regNo) {
                $regNos[] = $regNo;
            }
        }
        return $regNos;
    }
    
    private function registrationNumberExistsFor($regNo, $fe)
    {
        $maxTeamSize = DB::table('fest')->where('fest_name', $fe)->value('maxteamsize');
    
        // Check if the registration number exists in the users table
        if (DB::table('teams')->where('userreg', $regNo)->exists()) {
            return true;
        }
    
        // Check if the registration number exists in any of the team member regno columns
        for ($i = 1; $i <= $maxTeamSize; $i++) {
            if (DB::table('teams')->where('team_member_' . $i . '_regno', $regNo)->where('fest', $fe)->exists()) {
                return true;
            }
        }
    
        return false;
    }

    
    
    private function teamExistsFor($teamName, $fe)
    {
        return DB::table('teams')
            ->where('team_name', $teamName)
            ->where('fest', $fe)
            ->exists();
    }
    
    
    
    

    
    
   

    public function pay(Request $request,$fest){
        $department = $request->session()->get('department');
     if($request->input('planname') == 'Bronze'){
        $image=$request->file('TIM');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
      DB::table('payverify')->insert([


        'username'=>$request->input('name'),
        'rollno'=>$request->input('rollno'),
        'package'=>$request->input('planname'),
        'transactionid'=>$request->input('TID'),
        'fest'=>$fest,
        'screenshot'=>$path.$filename,
        'status'=>'pending',
            
      ]);

     }
     elseif($request->input('planname')=='Silver'){
        $image=$request->file('TIM');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
        DB::table('payverify')->insert([

            'username'=>$request->input('name'),
            'rollno'=>$request->input('rollno'),
            'package'=>$request->input('planname'),
            'transactionid'=>$request->input('TID'),
            'fest'=>$fest,
            'screenshot'=>$path.$filename,
            'status'=>'pending',


        ]);
     }
     else{
        $image=$request->file('TIM');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
        DB::table('payverify')->insert([

            'username'=>$request->input('name'),
            'rollno'=>$request->input('rollno'),
            'package'=>$request->input('planname'),
            'transactionid'=>$request->input('TID'),
            'fest'=>$fest,
            'screenshot'=>$path.$filename,
            'status'=>'pending',
            
        ]);
     }
     

     return redirect()->action([studentcontroller::class, 'sDashboard']);



    }

    public function storeTeamManager(Request $request)
    {
        // Retrieve form data
        $teamName = $request->input('team_name');
        $fest1 = $request->input('fest');
        $event = $request->input('eventname');
        $selectedMembers = $request->input('team_members');
        $userreg = $request->input('userreg');
        $type = $request->input('type');
        $leadername = $request->input('team_leader_name');
        $leaderregno = $request->input('team_leader_regno');
        $leaderemail = $request->input('team_leader_email');
        $payment = $request->input('payment');
    
        // Fetch festival details
        $fest = DB::table('fest')->where('fest_name', $fest1)->first();
    
        // Check if the festival details are found
        if ($fest) {
            // Fetch user's plan if payment is "Paid"
            if ($payment === "Paid") {
                $userPlan = DB::table('package_manager')
                    ->where('fest', $fest1)
                    ->where('regno', $userreg)
                    ->value('package');
    
                // Determine the limit based on the user's plan
                if ($userPlan === "Bronze") {
                    $limit = $fest->brgrplimit;
                } elseif ($userPlan === "Silver") {
                    $limit = $fest->sigrplimit;
                } else {
                    $limit = $fest->gogrplimit;
                }
    
                // Check if the team already exists
                $existingTeam = DB::table('teams')
                    ->where('team_name', $teamName)
                    ->where('userreg', $userreg)
                    ->first();
    
                // If the team does not exist, or if it does but the event is not registered, proceed with registration
                if (!$existingTeam || !in_array($event, explode(', ', $existingTeam->registered_events))) {
                    // Check if the user has already registered the maximum allowed events
                    if (!$existingTeam || count(explode(', ', $existingTeam->registered_events)) <= $limit) {
                        // Update the registered events
                        $updatedEvents = $existingTeam ? trim($existingTeam->registered_events . ',' . $event, ', ') : $event;
    
                        // Update or insert team data into the database
                        DB::table('teams')
                            ->updateOrInsert(
                                ['team_name' => $teamName, 'userreg' => $userreg],
                                ['registered_events' => $updatedEvents]
                            );
    
                        // Insert the team manager data into the database
                        DB::table('team_manager')->insert([
                            'team_leader_name' => $leadername,
                            'team_leader_regno' => $leaderregno,
                            'team_leader_email' => $leaderemail,
                            'team_name' => $teamName,
                            'fest' => $fest1,
                            'event' => $event,
                            'userreg' => $userreg,
                            'type' => $type,
                            'team_members' => json_encode($selectedMembers)
                        ]);
                        $name = $leadername;
    
                        // Send email to team leader
                        Mail::to($leaderemail)->send(new RegistrationConfirmation($name, $teamName, $event));
    
                        // Send email to team members if they are present
                        if (!empty($selectedMembers)) {
                            foreach ($selectedMembers as $member) {
                                $memberEmail = explode('|', $member)[2];
                                Mail::to($memberEmail)->send(new RegistrationConfirmation($name, $teamName, $event));
                            }
                        }
    
                        return redirect()->back()->with(['success' => true, 'message' => 'Team data stored successfully']);
                    } else {
                        // If the user has already registered the maximum allowed events, return an error
                        return redirect()->back()->with(['error' => "You can only register for up to $limit events with the current plan."]);
                    }
                } else {
                    // If the event is already registered for the user, return an error
                    return redirect()->back()->with(['error' => 'You are already registered for this event!']);
                }
            } else {
                // If the payment is not "Paid", proceed with registration without checking the package manager
                // Check if the team already exists
                $existingTeam = DB::table('teams')
                    ->where('team_name', $teamName)
                    ->where('userreg', $userreg)
                    ->first();
    
                // If the team does not exist, or if it does but the event is not registered, proceed with registration
                if (!$existingTeam || !in_array($event, explode(', ', $existingTeam->registered_events))) {
                    // Update the registered events
                    $updatedEvents = $existingTeam ? trim($existingTeam->registered_events . ',' . $event, ', ') : $event;
    
                    // Update or insert team data into the database
                    DB::table('teams')
                        ->updateOrInsert(
                            ['team_name' => $teamName, 'userreg' => $userreg],
                            ['registered_events' => $updatedEvents]
                        );
    
                    // Insert the team manager data into the database
                    DB::table('team_manager')->insert([
                        'team_leader_name' => $leadername,
                        'team_leader_regno' => $leaderregno,
                        'team_leader_email' => $leaderemail,
                        'team_name' => $teamName,
                        'fest' => $fest1,
                        'event' => $event,
                        'userreg' => $userreg,
                        'type' => $type,
                        'team_members' => json_encode($selectedMembers)
                    ]);
                    $name = $leadername;
    
                    // Send email to team leader
                    Mail::to($leaderemail)->send(new RegistrationConfirmation($name, $teamName, $event));
    
                    // Send email to team members if they are present
                    if (!empty($selectedMembers)) {
                        foreach ($selectedMembers as $member) {
                            $memberEmail = explode('|', $member)[2];
                            Mail::to($memberEmail)->send(new RegistrationConfirmation($name, $teamName, $event));
                        }
                    }
    
                    return redirect()->back()->with(['success' => true, 'message' => 'Team data stored successfully']);
                } else {
                    // If the event is already registered for the user, return an error
                    return redirect()->back()->with(['error' => 'You are already registered for this event!']);
                }
            }
        } else {
            // If the festival details are not found, handle the error accordingly
            return redirect()->back()->with(['error' => 'Festival details not found.']);
        }
    }
    
   

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'team_name' => 'required|string',
            
            // Add more validation rules as needed
        ]);

        // Check if the team name already exists
        $teamNameExists = DB::table('teams')->where('team_name', $request->team_name)->exists();
        if ($teamNameExists) {
            return response()->json(['available' => false]);
        }

        // Process the form submission and save the team details to the database
        // Add your logic here

        return response()->json(['success' => true]);
    }
    public function checkRegistrationNumber(Request $request)
    {
        $regNo = $request->input('reg_no');
    $fe=DB::table('fest')->where('fest_name',session('festname'));
        // Check if the registration number is associated with any team
        $teamExists = DB::table('teams')
            ->orwhere('userreg', $regNo)
            ->orWhere(function ($query) use ($regNo) {
                for ($i = 1; $i <= 10; $i++) { // Adjust the number based on your maximum team size
                    $query->orWhere("team_member_$i", $regNo);
                }
            })
            ->exists();
    
        return response()->json(['available' => !$teamExists]);
    }
    public function checkTeamName(Request $request)
    {
        $teamName = $request->input('team_name');

        // Check if the team name already exists
        $teamExists = Team::where('team_name', $teamName)->exists();

        return response()->json(['available' => !$teamExists]);
    }
    public function getTableValue(Request $request)
    {
        // Retrieve the selected event name from the request
        $selectedEventName = $request->input('selectedEventName');
        
        // Fetch the necessary data from the database
        $eventDetail = DB::table('eventdetail')->where('name', $selectedEventName)->first();

        if ($eventDetail) {
            // Return the data as JSON
            return response()->json([
                'teamSize' => $eventDetail->teamsize,
                // Add other data if needed
            ]);
        } else {
            // Handle the case where the event detail is not found
            return response()->json([
                'error' => 'Event detail not found',
            ], 404);
        }
    }
    

   
    public function festcomplete($fest){
        DB::table('fest')->where('fest_name', $fest)->update([
            'completed' => 1
        ]);
        return redirect()->back();
    }
    
    
    
    

}

    
    

    
    

