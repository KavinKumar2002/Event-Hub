<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use App\Models\StudentData;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use Dompdf\Dompdf;
use App\Mail\MailableName;
use App\Mail\RegistrationConfirmation;




class EventController extends Controller
{
    public function Festdata($fest){

        return view('addEvents')->with('fest',$fest);
    }
    public function dashboard() {
        $collegecode = session('collegecode');
        $events = DB::table('fest')->where('collegecode', $collegecode)->count();
        $completed = DB::table('fest')->where('completed', true)->count();
        return view('AssignedFest', ['events' => $events, 'completed' => $completed]);
    }
    public function Assign(Request $req) {
      $req->validate( [
            'fest_name' => 'required|unique:fest',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'image' => 'required|image', // Assuming max file size is 2MB
            'qrcode' => 'required|image', // Assuming max file size is 2MB
            'details' => 'required',
            'pricesilver' => 'nullable|numeric|min:1',
            'siindlimit' => 'nullable|integer|min:1',
            'sigrplimit' => 'nullable|integer|min:1',
            'pricebronze' => 'nullable|numeric|min:1',
            'brindlimit' => 'nullable|integer|min:1',
            'brgrplimit' => 'nullable|integer|min:1',
            'pricegold' => 'nullable|numeric|min:1',
            'goindlimit' => 'nullable|integer|min:1',
            'gogrplimit' => 'nullable|integer|min:1',
            'upi' => 'required',
            'maxteamsize' => 'required|integer|min:1',
        ]);
    
       
    
        $image=$req->file('image');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);

        $image1=$req->file('qrcode');
        $extension1=$image1->getClientOriginalExtension();
        $path1="img/";
        $filename1=time().'.'.$extension1;
        $image1->move($path,$filename1);
        DB::table('fest')->insert([
            'fest_name' => $req->input('fest_name'),
            'start' => $req->input('start'),
            'end' => $req->input('end'),
            'collegecode' => $req->input('collegecode'),
            'image'=> $path.$filename,
            'details'=>$req->input('details'),
            'pricesilver'=>$req->input('pricesilver'),
            'siindlimit'=>$req->input('siindlimit'),
            'sigrplimit'=>$req->input('sigrplimit'),
            'pricebronze'=>$req->input('pricebronze'),
            'brindlimit'=>$req->input('brindlimit'),
            'brgrplimit'=>$req->input('brgrplimit'),
            'pricegold'=>$req->input('pricegold'),
            'goindlimit'=>$req->input('goindlimit'),
            'gogrplimit'=>$req->input('gogrplimit'),
            'upi'=>$req->input('upi'),
            'qrcode'=> $path.$filename1,
            'maxteamsize'=>$req->input('maxteamsize'),

            'completed' => 0,


        ]);
    
        return redirect('AssignedFest');
    }
    
    public function Viewfest($fest){

        $eve=DB::table('eventdetail')->where('fest',$fest)->get();
        $eventcount=DB::table('eventdetail')->where('fest',$fest)->count();
        $indcount=DB::table('regevent')->where('type','Individual')->count();
        $grpcount=DB::table('teams')->where('fest',$fest)->count();
        
        $event=DB::table('eventdetail')->where('fest',$fest)->get();
       
        $indreg=DB::table('regevent')->where('type','Individual')->get();
        $grpreg=DB::table('teams')->where('fest',$fest)->get();
        session()->put('festname', $fest);
        $teamMemberDetails=DB::table('teams')->where('fest',$fest)->first();

        $maxTeamSize = DB::table('fest')->where('fest_name', $fest)->value('maxteamsize');
   

        
        return view('Viewfest')->with(['maxTeamSize'=>$maxTeamSize,'teamMemberDetails'=>$teamMemberDetails,'eve'=>$eve,'indcount'=>$indcount,'grpcount'=>$grpcount,'indreg'=>$indreg,'grpreg'=>$grpreg,'event'=>$event,'fest'=>$fest,'eventcount'=>$eventcount]);


    }

    public function duplicateViewfest($fest){

        $eve=DB::table('eventdetail')->where('fest',$fest)->get();
        $eventcount=DB::table('eventdetail')->where('fest',$fest)->count();
        $indcount=DB::table('regevent')->where('type','Individual')->count();
        $grpcount=DB::table('teams')->where('fest',$fest)->count();
        
        $event=DB::table('eventdetail')->where('fest',$fest)->get();
       
        $indreg=DB::table('regevent')->where('type','Individual')->get();
        $grpreg=DB::table('teams')->where('fest',$fest)->get();
        session()->put('festname', $fest);
        $teamMemberDetails=DB::table('teams')->where('fest',$fest)->first();

        $maxTeamSize = DB::table('fest')->where('fest_name', $fest)->value('maxteamsize');
   

        
        return view('duplicateviewfest')->with(['maxTeamSize'=>$maxTeamSize,'teamMemberDetails'=>$teamMemberDetails,'eve'=>$eve,'indcount'=>$indcount,'grpcount'=>$grpcount,'indreg'=>$indreg,'grpreg'=>$grpreg,'event'=>$event,'fest'=>$fest,'eventcount'=>$eventcount]);


    }
    public function Assigned(){
        $fest = DB::table('fest')
                    ->where('collegecode', session('collegecode'))
                    ->where('completed',0)
                    ->get();
                    
        return view('assignedFest')->with('fest', $fest);
    }

    public function events(Request $request){
        $validator = Validator::make($request->all(), [
            'eventname' => 'required|string',
            'image' => 'required|image',
            'eventid' => 'required|string|in:Technical,Non Technical',
            'type' => 'required|string|in:Individual,Group',
            'teamsize' => $request->type == 'Group' ? 'required|integer|min:1' : '', // Only required if type is Group
            'eventtype' => 'required|string|in:Open,Closed',
            'department' => 'required|string|in:CSE,ECE,EEE,IT,MECH',
            'payment' => 'required|string|in:Paid,Free',
            'details' => 'required|string',
            'rules' => 'required|string',
            'fest' => 'required|string',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $existingEvent = DB::table('eventdetail')
            ->where('name', $request->input('eventname'))
            ->where('fest', $request->input('fest'))
            ->first();
    
        if ($existingEvent) {
            return redirect()->back()->with('error', 'Event already exists!');
        }
    
        $image=$request->file('image');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);


        if($request->input('type') === 'Group'){
            if ($request->input('payment') === 'Paid') {   
      
                DB::table('eventdetail')->insert([
                    'name' => $request->input('eventname'),
                    'cost' => $request->input('eventcost'), 
                    'fest' => $request->input('fest'), 
                    'event_id' => $request->input('eventid'),
                    'rules'=>$request->input('rules'),
                    'details'=>$request->input('details'),
                    'department'=>$request->input('department'),
                    'type'=>$request->input('type'),
                    'image'=> $path.$filename,
                    'eventtype'=>$request->input('eventtype'),
                    'payment'=>$request->input('payment'),
                    'teamsize'=>$request->input('teamsize'),
                ]);
            }
            elseif($request->input('payment') === 'Free')
            {
                DB::table('eventdetail')->insert([
                    'name' => $request->input('eventname'),
                    'cost' => $request->input('eventcost'), 
                    'fest' => $request->input('fest'), 
                    'event_id' => $request->input('eventid'),
                    'rules'=>$request->input('rules'),
                    'details'=>$request->input('details'),
                    'department'=>$request->input('department'),
                    'type'=>$request->input('type'),
                    'image'=> $path.$filename,
                    'eventtype'=>$request->input('eventtype'),
                    'payment'=>$request->input('payment'),
                    'teamsize'=>$request->input('teamsize'),
                ]); 
            }

        }
        else{
            if ($request->input('payment') === 'Paid') {   
      
                DB::table('eventdetail')->insert([
                    'name' => $request->input('eventname'),
                    'cost' => $request->input('eventcost'), 
                    'fest' => $request->input('fest'), 
                    'event_id' => $request->input('eventid'),
                    'rules'=>$request->input('rules'),
                    'details'=>$request->input('details'),
                    'department'=>$request->input('department'),
                    'type'=>$request->input('type'),
                    'image'=> $path.$filename,
                    'eventtype'=>$request->input('eventtype'),
                    'payment'=>$request->input('payment'),
                  
                ]);
            }
            elseif($request->input('payment') === 'Free')
            {
                DB::table('eventdetail')->insert([
                    'name' => $request->input('eventname'),
                    'cost' => $request->input('eventcost'), 
                    'fest' => $request->input('fest'), 
                    'event_id' => $request->input('eventid'),
                    'rules'=>$request->input('rules'),
                    'details'=>$request->input('details'),
                    'department'=>$request->input('department'),
                    'type'=>$request->input('type'),
                    'image'=> $path.$filename,
                    'eventtype'=>$request->input('eventtype'),
                    'payment'=>$request->input('payment'),
                
                ]); 
            }

        }
      
   



        return redirect()->back()->with('success', 'Event added successfully!');
    }
    
    
public function completed(){
    
    $completed = DB::table('fest')->where('completed', 1)->get();
    return view('completed', [ 'completed' => $completed]);
}
public function EventsEdit(Request $request){
  
    if ($request->input('payment') === 'Paid') {   
        DB::table('eventdetail')
        ->where('id', $request->input('id'))
        ->update([
            'name' => $request->input('eventname'),
            'cost' => $request->input('eventcost'), 
            'fest' => $request->input('fest'), 
            'event_id' => $request->input('eventid'),
            'rules'=>$request->input('rules'),
            'details'=>$request->input('details'),
            'department'=>$request->input('department'),
            'type'=>$request->input('type'),
         
            'eventtype'=>$request->input('eventtype'),
            'payment'=>$request->input('payment'),
        ]);
    
    }
    elseif($request->input('payment') === 'Free')
    {
        DB::table('eventdetail')
        ->where('id', $request->input('id'))
        ->update([
            'name' => $request->input('eventname'),
            'cost' => $request->input('eventcost'), 
            'fest' => $request->input('fest'), 
            'event_id' => $request->input('eventid'),
            'rules'=>$request->input('rules'),
            'details'=>$request->input('details'),
            'department'=>$request->input('department'),
            'type'=>$request->input('type'),
          
            'eventtype'=>$request->input('eventtype'),
            'payment'=>$request->input('payment'),
        ]);
    
    }

    return redirect("/View/{$request->input('fest')}");
}

public function EditEvent($fest, $name) {
    $event = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('name', $name)
        ->first();
    return view('editevent')->with(['event' => $event]);
}
public function DeleteEvent($fest, $id, $name) {
    // Delete from eventdetail table
    DB::table('eventdetail')
        ->where('id', $id)
        ->delete();
    DB::table('separatereg')
        ->where('fest',$fest)
        ->where('event',$name)
        ->delete();
       
// Remove $name from the registered_event column in the regevent table
DB::table('regevent')
    ->where('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
    ->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
    ->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
    ->orWhere('registered_event', '=', $name) // Check if $name is the only value
    ->update([
        'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
    ]);

    DB::table('grpreg')
    ->where('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
    ->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
    ->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
    ->orWhere('registered_event', '=', $name) // Check if $name is the only value
    ->update([
        'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
    ]);

    return redirect("/View/{$fest}");
}


public function StudentFest($fest){
    $student=DB::table('studentdata')->where('fest',$fest);
    return view('StudentGet')->with(['fest'=>$fest,'student'=>$student]);
}
public function StudentFestPost(Request $request) {
    // Validate request data
    $validatedData = $request->validate([
        'data.*' => 'required',
        'fest' => 'required',
    ]);

    // Access the form data
    $fest = $request->input('fest');
    $data = $request->input('data');

    // Check for duplicates
    $hasDuplicate = DB::table('studentdata')
        ->where('fest', $fest)
        ->whereIn('data', $data)
        ->exists();

    if ($hasDuplicate) {
        return redirect("/fest/StudentGet/$fest")->with('error1', 'Failed to store data. Duplicate found.');
    }

    try {
        // Store data in the database using bulk insert
        $insertData = [];
        foreach ($data as $item) {
            $insertData[] = [
                'fest' => $fest,
                'data' => $item,
            ];
        }

        DB::table('studentdata')->insert($insertData);

        // Redirect with success message
        return redirect("/fest/StudentGet/$fest")->with('success', 'Data successfully stored!');
    } catch (\Exception $e) {
        // Redirect with error message
        return redirect("/fest/StudentGet/$fest")->with('error', 'Failed to store data. Please try again.');
    }
}
public function allocate($fest, $event) {
    // Retrieve registered events from regevent table
    $regevents = DB::table('regevent')->where('fest', $fest)->get();

    // Retrieve registered events from grpreg table
    $grpevents = DB::table('teams')->where('fest', $fest)->get();

// Loop through regevents
foreach ($regevents as $regevent) {
    // Split the registered event string into individual events
    $individualEvents = explode(',', $regevent->registered_event);

    // Loop through each individual event for this user
    foreach ($individualEvents as $individualEvent) {
        // Trim whitespace from each individual event
        $individualEvent = trim($individualEvent);

        // Check if the entry already exists in separatereg table
        $exists = DB::table('separatereg')
            ->where('name', $regevent->name)
            ->where('fest', $fest) // Use $fest variable here
            ->where('event', $individualEvent)
            ->where('regno', $regevent->regno)
            ->where('type', $regevent->type)
            ->exists();

        // If the entry doesn't exist, insert it into separatereg table
        if (!$exists) {
            DB::table('separatereg')->insert([
                'name' => $regevent->name,
                'fest' => $fest, // Use $fest variable here
                'event' => $individualEvent,
                'regno' => $regevent->regno,
                'mark' => $regevent->mark,
                'type' => $regevent->type
            ]);
        }
    }
}


    // Loop through grpevents
    foreach ($grpevents as $grpevent) {
      
        // Split the registered event string into individual events
        $individualEvents = explode(',', $grpevent->registered_events);

        // Loop through each individual event for this user
        foreach ($individualEvents as $individualEvent) {
            // Trim whitespace from each individual event
            $individualEvent = trim($individualEvent);

            // Check if the entry already exists in team_manager table
            $temp = DB::table('team_manager')
                        ->where('fest', $fest)
                        ->where('event', $event)
                        ->where('team_name', $grpevent->team_name)
                        ->first();

            // If the entry exists in team_manager table
            if ($temp) {
                // Check if the user registration exists
                $exists = DB::table('separatereg')
                            ->where('name', $grpevent->team_name)
                            ->where('fest', $fest)
                            ->where('event', $individualEvent)
                            ->where('regno', $temp->userreg)
                            ->where('type', $temp->type)
                            ->exists();

                // If the entry doesn't exist, insert it into separatereg table
                if (!$exists) {
                    DB::table('separatereg')->insert([
                        'name' => $grpevent->team_name,
                        'fest' => $fest,
                        'event' => $individualEvent,
                        'regno' => $temp->userreg,
                        'type' => $temp->type,
                    ]);
                }
            }
        }
    }

    // Retrieve data from the SeparateReg table
    $sep = DB::table('separatereg')
        ->where('fest', $fest)
        ->where('event', $event)
        ->get();

    return view('allocate')->with(['sep' => $sep]);
}


public function allocatemarks(Request $request)
{
    // Retrieve data from the request
    $name = $request->input('name');
    $fest = $request->input('fest');
    $event = $request->input('event');
    $regno = $request->input('regno');
    $newMarks = $request->input('mark');

    // Check if the data exists in the table
    $existingData = DB::table('separatereg')
        ->where('name', $name)
        ->where('fest', $fest)
        ->where('event', $event)
        ->where('regno', $regno)
        ->first(); 

      
            // Update marks
            DB::table('separatereg')
                ->where('name', $name)
                ->where('fest', $fest)
                ->where('event', $event)
                ->where('regno', $regno)
                ->update(['mark' => $newMarks]);
            
            // Redirect back with success message
            return redirect()->back()->with('success', 'Marks updated successfully!');
        
 
}





public function generateCertificate(Request $request)
{
    $eventName = $request->input('eventname');

    // Fetch top three entries from the separatereg table matching the event name and where mark is not null
    $topThree = DB::table('separatereg')
                    ->where('event', $eventName)
                    ->whereNotNull('mark')
                    ->orderBy('mark', 'desc')
                    ->take(3)
                    ->get();

    foreach ($topThree as $index => $entry) {
        $name = $entry->name;
        $regno = $entry->regno;
        $marking = $index + 1; // Assign 1st, 2nd, 3rd based on index

        // Fetch email from studentprofile table using regno
        $student = DB::table('studentprofile')->where('regno', $regno)->first();
        $email = $student ? $student->email : null;

        // If email not found, try fetching from grpreg table using team_leader_regno
        if (!$email) {
            $teamLeader = DB::table('teams')->where('userreg', $regno)->first();
            $email = $teamLeader ? $teamLeader->team_leader_email : null;
        }

        // Check if the name is in the team_manager table
        $teamManager = DB::table('team_manager')->where('team_name', $name)->first();
        
        if ($teamManager) {
            // If the name is in the team_manager table, send email to all team members
            $teamMembersJson = $teamManager->team_members;
            $teamMembers = json_decode($teamMembersJson, true);

            if (!empty($teamMembers)) {
                foreach ($teamMembers as $member) {
                    list($memberName, $memberRegno, $memberEmail) = explode('|', $member);
                    
                    // Generate PDF with appropriate marking for top 3
                    $pdf = PDF::loadView('certificate.pdf', ['name' => $memberName, 'event' => $eventName, 'marking' => $marking])->setPaper('a4', 'landscape');
                    
                    // Send email with PDF attachment to each team member
                    Mail::send([], [], function ($message) use ($pdf, $memberName, $memberEmail, $eventName, $marking) {
                        $message->to($memberEmail)
                                ->subject('Certificate for Event')
                                ->attachData($pdf->output(), 'certificate.pdf');
                    });
                }
            }
        } else {
            // If the name is not in the team_manager table, send email to individual
            if ($email) {
                // Generate PDF with appropriate marking for top 3
                $pdf = PDF::loadView('certificate.pdf', ['name' => $name, 'event' => $eventName, 'marking' => $marking])->setPaper('a4', 'landscape');
                
                // Send email with PDF attachment
                Mail::send([], [], function ($message) use ($pdf, $name, $email, $eventName, $marking) {
                    $message->to($email)
                            ->subject('Certificate for Event')
                            ->attachData($pdf->output(), 'certificate.pdf');
                });

                // Update the 'certificates' column of the current entry with the generated PDF certificate
                DB::table('separatereg')
                    ->where('name', $name)
                    ->where('event', $eventName)
                    ->update(['certificates' => 'generated']);
            }
        }
    }

    return redirect()->back();
}




public function verify($fest){
    $verificationData = DB::table('payverify')
    ->where('fest', $fest)
    ->get();

    return view('paymentverification')->with(['verificationData'=>$verificationData,'fest'=>$fest]);
    

}
public function verifyupdate($fest, $regno, $package)
{

    // Update the status in the payverify table to 'verified'
    DB::table('payverify')
        ->where('fest', $fest)
        ->where('rollno',$regno)
        ->update(['status' => 'verified']);

    // Retrieve verification data for the view
    $verificationData = DB::table('payverify')
        ->where('fest', $fest)
        ->get();
    DB::table('package_manager')
    ->insert([

'package'=>$package,
'fest'=>$fest,
'regno'=>$regno

    ]);

    // Return the view with the updated data
    return view('paymentverification')->with(['verificationData' => $verificationData, 'fest' => $fest]);
}
public function getStatus($fest, $rollno)
{
    // Retrieve the status from the payverify table based on fest and rollno
    $status = DB::table('payverify')
        ->where('fest', $fest)
        ->where('rollno', $rollno)
        ->value('status');

    // Return the status as JSON response
    return response()->json(['status' => $status]);
}
public function indsearch(){
    $event=DB::table('eventdetail')->where('fest',session('festname'))
    ->where('type','Individual')
    ->get();
    $indcount=DB::table('regevent')->where('type','Individual')->count();
       
    $indreg=DB::table('regevent')->where('type','Individual')->get();
    return view('indsearch')->with(['event'=>$event,'indreg'=>$indreg,'indcount'=>$indcount]);
}
public function duplicateindsearch(){
    $event=DB::table('eventdetail')->where('fest',session('festname'))
    ->where('type','Individual')
    ->get();
    $indcount=DB::table('regevent')->where('type','Individual')->count();
       
    $indreg=DB::table('regevent')->where('type','Individual')->get();
    return view('duplicateindsearch')->with(['event'=>$event,'indreg'=>$indreg,'indcount'=>$indcount]);
}
public function addexieve(Request $request){
    $fest = DB::table('fest')
            ->where('fest_name', $request->input('fest'))
            ->first();
    
    if ($fest) {
        // Check if the payment is "Paid"
        $payment = DB::table('eventdetail')
        ->where('name',$request->input('eventname'))
        ->where('fest',$request->input('fest'))
        ->value('payment');
    
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
    
            $existingUser = DB::table('regevent')
                ->where('name', $request->input('name'))
                ->where('dept', $request->input('department'))
                ->first();
    
            if ($existingUser) {
                // If the user already exists, check if the event is already registered
                $registeredEvents = explode(',', $existingUser->registered_event);
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
                // If the user does not exist, return an error
                return redirect()->back()->with('error', 'User not found');
            }
        } else {
            // Proceed with registration without checking the package manager
            $existingUser = DB::table('regevent')
                ->where('name', $request->input('name'))
                ->where('dept', $request->input('department'))
                ->first();
                if ($existingUser) {
                    // If the user already exists, check if the event is already registered
                    $registeredEvents = explode(',', $existingUser->registered_event);
                    $newEvent = $request->input('eventname');
        
                    if (!in_array($newEvent, $registeredEvents)) {
                        // Check if the user has already registered the maximum allowed events
                       
                            // If the event is not registered and the user has less than the maximum allowed events, proceed with registration
                            $this->updateRegisteredEvents($existingUser, $newEvent, $request);
                            return redirect()->back()->with('success', 'Registration successful!');
                        
                    } else {
                        // If the event is already registered for the user, return an error
                        return redirect()->back()->with('error', 'You are already registered for this event!');
                    }
                } else {
                    // If the user does not exist, return an error
                    return redirect()->back()->with('error', 'User not found');
                }
         
        }
    } else {
        // If the festival details are not found, handle the error accordingly
        return redirect()->back()->with('error', 'Festival details not found.');
    }
}

private function updateRegisteredEvents($existingUser, $newEvent, $request)
    {
        // Append the new event to the existing registered events
        $updatedEvents = $existingUser->registered_event ? trim($existingUser->registered_event . ',' . $newEvent, ', ') : $newEvent;
    $eventtyp=$request->input('eventtype');
     $ch=DB::table('regevent')
       ->where('regno',$request->input('regno'))
       ->first();
        // Update the registered_event column
        if($eventtyp == 'Open'){
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
        elseif($eventtyp =='Closed' && $ch->eventdept == $request->input('department') ){
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
        else{
            return redirect()->back()->with('error','It is a closed Event');
        }
    }

    public function removeexieve(Request $request){
        $name=$request->input('eventname');
        DB::table('regevent')
        ->where('regno',$request->input('regno'))
    ->orwhere('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
    ->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
    ->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
    ->orWhere('registered_event', '=', $name) // Check if $name is the only value
    ->update([
        'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
    ]);
    DB::table('separatereg')
    ->where('regno', $request->input('regno')) // Corrected arrow usage
    ->where('event', $request->input('eventname'))
    ->where('fest', session('festname'))
    ->delete();

    return redirect()->back()->with('success','Deleted Successfully');

    }
    public function teamsearch(){
  
   
        $grpcount=DB::table('teams')->where('fest',session('festname'))->count();
    
        $event=DB::table('eventdetail')->where('fest',session('festname'))
        ->where('type','Group')
        ->get();
        $fest=DB::table('eventdetail')->where('fest',session('festname'))->value('fest');
           
        $grpreg=DB::table('teams')->where('fest',session('festname'))->get();
        $maxTeamSize = DB::table('fest')->where('fest_name', $fest)->value('maxteamsize');
        $teamMemberDetails=DB::table('teams')->where('fest',$fest)->get();
        
        
        return view('groupsearch')->with(['teamMemberDetails'=>$teamMemberDetails,'maxTeamSize'=>$maxTeamSize,'event'=>$event,'grpcount'=>$grpcount,'event'=>$event,'grpreg'=>$grpreg,'fest'=>$fest]);
    }
public function duplicateteamsearch(){
  
   
    $grpcount=DB::table('teams')->where('fest',session('festname'))->count();

    $event=DB::table('eventdetail')->where('fest',session('festname'))
    ->where('type','Group')
    ->get();
    $fest=DB::table('eventdetail')->where('fest',session('festname'))->value('fest');
       
    $grpreg=DB::table('teams')->where('fest',session('festname'))->get();
    $maxTeamSize = DB::table('fest')->where('fest_name', $fest)->value('maxteamsize');
    $teamMemberDetails=DB::table('teams')->where('fest',$fest)->get();
    
    
    return view('duplicategroupsearch')->with(['teamMemberDetails'=>$teamMemberDetails,'maxTeamSize'=>$maxTeamSize,'event'=>$event,'grpcount'=>$grpcount,'event'=>$event,'grpreg'=>$grpreg,'fest'=>$fest]);
}
public function addexiteameve(Request $request)
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
            // Check if the payment is "Paid"
            if ($payment === "Paid") {
                // Fetch user's plan
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
                    if (!$existingTeam || count(explode(', ', $existingTeam->registered_events)) < $limit) {
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

public function result($fest, $event){
    $topThree = DB::table('separatereg')
        ->where('fest', $fest)
        ->where('event', $event)
        ->orderBy('mark', 'desc')
        
        ->limit(3)  
        ->get();
    
        $next = DB::table('separatereg')
        ->where('fest', $fest)
        ->where('event', $event)
        ->orderBy('mark', 'desc')
        ->skip(3)
        ->limit(PHP_INT_MAX) 
        ->get();
      
    return view('eventresult')->with(['topThree' => $topThree, 'next' => $next,'event'=>$event]);
    
    }



public function removeexiteameve(Request $request){
    $name=$request->input('eventname');
    DB::table('teams')
    ->where('userreg',$request->input('userreg'))
->orwhere('registered_events', 'like', "%,$name,%") // Check for comma before and after $name
->orWhere('registered_events', 'like', "%,$name") // Check for comma before $name
->orWhere('registered_events', 'like', "$name,%") // Check for comma after $name
->orWhere('registered_events', '=', $name) // Check if $name is the only value
->update([
    'registered_events' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_events, ','), ',$name,', ','))")
]);
DB::table('team_manager')
->where('userreg',$request->input('userreg'))
->where('event',$name)
->delete();
DB::table('separatereg')
    ->where('regno', $request->input('userreg')) // Corrected arrow usage
    ->where('event', $request->input('eventname'))
    ->where('fest', session('festname'))
    ->delete();
return redirect()->back()->with('success','Deleted Successfully');

}
public function viewfull(){
    $eve=DB::table('eventdetail')->where('fest',session('festname'))->get();
    $eventcount=DB::table('eventdetail')->where('fest',session('festname'))->count();
    $event=DB::table('eventdetail')->where('fest',session('festname'))->get();
    $fest=DB::table('eventdetail')->where('fest',session('festname'))->value('fest');
   return view('viewfull')->with(['eve'=>$eve,'eventcount'=>$eventcount,'event'=>$event,'fest'=>$fest]);

}
public function duplicateviewfull(){
    $eve=DB::table('eventdetail')->where('fest',session('festname'))->get();
    $eventcount=DB::table('eventdetail')->where('fest',session('festname'))->count();
    $event=DB::table('eventdetail')->where('fest',session('festname'))->get();
    $fest=DB::table('eventdetail')->where('fest',session('festname'))->value('fest');
   return view('duplicateviewfull')->with(['eve'=>$eve,'eventcount'=>$eventcount,'event'=>$event,'fest'=>$fest]);

}
public function checkmarks(Request $request)
    {
        // Retrieve regno from the request
        $regno = $request->input('regno');

        // Check if marks are assigned for the given regno
        $marksAssigned =DB::table('separatereg')->where('regno', $regno)->exists();

        // Return response as JSON
        return response()->json(['marksAssigned' => $marksAssigned]);
    }

    public function removeupdate($fest, $regno, $package)
    {
       
    
        // Update the status in the payverify table to 'verified'
        DB::table('payverify')
            ->where('fest', $fest)
            ->where('rollno',$regno)
           
            ->update(['status' => 'pending']);
    
        // Retrieve verification data for the view
        $verificationData = DB::table('payverify')
            ->where('fest', $fest)
            ->get();

            DB::table('package_manager')
            ->where('fest', $fest)
            ->where('regno', $regno)
            ->delete();
    
        // Return the view with the updated data
        return view('paymentverification')->with(['verificationData' => $verificationData, 'fest' => $fest]);
    }
    public function checkRegistrationStatus(Request $request)
    {
        // Retrieve fest name and roll number from the request
        $fest = $request->input('fest');
        $rollno = $request->input('rollno');
    
        // Query the database to check if the user is registered for the fest
        $registration = DB::table('payverify')
                        ->where('fest', $fest)
                        ->where('rollno', $rollno)
                        ->first();
    
        // If registration record exists
        if ($registration) {
            // Return the status
            return response()->json(['status' => $registration->status]);
        } else {
            // If no registration record found, return status as 'not_registered'
            return response()->json(['status' => 'not_registered']);
        }
    }
    public function getTeamSize(Request $request)
    {
        $eventName = $request->input('eventName');
        
        // Retrieve the team size column from the EventDetail table based on the event name
        $eventDetail = DB::table('eventdetail')
                        ->where('event_name', $eventName)
                        ->where('fest', session('festname')) // Assuming 'fest' is the session variable storing the festival name
                        ->first();
    
        if ($eventDetail) {
            $teamSize = $eventDetail->team_size;
            return response()->json(['teamSize' => $teamSize]);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }
    
    

}

