<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fest</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin-top: 70px;
        }
        .register {

            display: flex;
            align-items: center;
            justify-content: center;
            float: right;
            border-radius: 30px 8px 30px 30px;
            background-color: rgb(0, 96, 99);
            box-shadow: none;
            color: rgb(255, 255, 255);
            z-index: 2147483647;
            cursor: pointer;
            top: 70px;
            right: 20px;
            position: fixed;
            padding: 8px;
            margin-right: 20px;
            transition: all 0.1s ease-out 0s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .cards-1 {
            padding-top: 3.25rem;
            padding-bottom: 3rem;
            text-align: center;
        }
        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
            .h2-heading {
                width: 90%;
                margin-right: auto;
                margin-left: auto;
            }
        }
        h2 {
            color: #333;
            font: 700 2rem / 2.625rem "Open Sans", sans-serif;
            letter-spacing: -0.2px;
        }
        .card {
            display: inline-block;
            width: 17rem;
            max-width: 100%;
            margin-right: 1rem;
            margin-left: 1rem;
            vertical-align: top;
            max-width: 21rem;
            margin-right: auto;
            margin-bottom: 3.5rem;
            margin-left: auto;
            padding: 0;
            border: none;
        }

    </style>
</head>
<body>
@include('stud')

@php
    $isteam = DB::table('teams')
        ->where('userreg', session('regno'))
        ->where('fest',session('festname'))
        ->first();
@endphp


<div class="d-flex justify-content-center align-items-center mb-3">

    <div class="mr-2">
        <label>Add Team Details For Group Registration</label>
        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal1" {{ $isteam ? 'disabled' : '' }}>
            Team Details
        </button>
    </div>
    <!-- <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal12">
            Edit Team Details
        </button>
    </div> -->
</div>

  <!-- Modal 1 -->
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Team Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="grpreg" action="/group" method="post">
                    @csrf
                    <div class="form-group mb-3">
    <label>Team Leader Details:</label>
    <ul>
        <li>Name: {{ session("name") }}</li>
        <li>Reg no: {{ session("regno") }}</li>
        <li>Email: {{ session("email") }}</li>
    </ul>
</div>
                    <div class="form-group mb-3">
                        <label>Team Name</label>
                        <input class="form-control" name="team_name" type="text" placeholder="Team Name" required>
                        <div class="invalid-feedback team-name-error">Please enter a valid team name.</div>
                    </div>

                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Department</label>
                            <select class="form-select form-select-lg mb-3" style="border-radius:160px" name="teamdepartment">
                                <optgroup label="department">
                                    <option value="">Select department</option>
                                    <option value="CSE">CSE</option>
                                    <option value="ECE">ECE</option>
                                    <option value="EEE">EEE</option>
                                    <option value="IT">IT</option>
                                    <option value="MECH">MECH</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>College Name</label>
                        <input class="form-control" name="college_name" type="text" placeholder="College Name" required>
                        <div class="invalid-feedback college-name-error">Please enter a valid college name.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Mobile No</label>
                        <input class="form-control" name="mobile_no" type="text" placeholder="Mobile No" required>
                        <div class="invalid-feedback mobile-no-error">Please enter a valid mobile number.</div>
                    </div>
                    @php
                    $festMaxTeamSize = DB::table('fest')
                    ->where('fest_name', session('festname'))
                    ->value('maxteamsize');
                    @endphp

                    <input type="hidden" id="max-team-size" value="{{ $festMaxTeamSize }}">

                    <!-- Team member input boxes will be dynamically generated here -->
                    <div id="team-member-inputs"></div>

                    <input type="hidden" name="team_leader_name" value="{{ session('name') }}">
                    <input type="hidden" name="team_leader_email" value="{{ session('email') }}">
                    <input type="hidden" name="team_leader_regno" value="{{ session('regno') }}">

                    <input type="hidden" name="fest" value="{{ session('festname') }}">
                    <input type="hidden" name="regno" value="{{ session('regno') }}">
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
            </div>
                </form>
            </div>
          
        </div>
    </div>
</div>

<!-- Modal 2 -->
<!-- Modal -->
<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Team Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="grpreg" action="/teamupdate" method="post">
                    @csrf
                    @php
                        $team=DB::table('teams')
                        ->where('userreg',session('regno'))
                        ->get();

                        @endphp
                    @foreach($team as $tea)
                    <div class="form-group mb-3">
                       
                        <input class="form-control" name="team_name" type="text" placeholder="Team Name" required value="{{ $tea->team_name }}" hidden>
                        <div class="invalid-feedback team-name-error">Please enter a valid team name.</div>
                    </div>

                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                          
                            <select class="form-select form-select-lg mb-3" style="border-radius:160px" name="teamdepartment" hidden>
                                <optgroup label="department">
                                    <option value="">Select department</option>
                                    <option value="CSE" {{ $tea->dept === 'CSE' ? 'selected' : '' }}>CSE</option>
                                    <option value="ECE" {{ $tea->dept === 'ECE' ? 'selected' : '' }}>ECE</option>
                                    <option value="EEE" {{ $tea->dept === 'EEE' ? 'selected' : '' }}>EEE</option>
                                    <option value="IT" {{ $tea->dept === 'IT' ? 'selected' : '' }}>IT</option>
                                    <option value="MECH" {{ $tea->dept === 'MECH' ? 'selected' : '' }}>MECH</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>College Name</label>
                        <input class="form-control" name="college_name" type="text" placeholder="College Name" required value="{{ $tea->college_name }}">
                        <div class="invalid-feedback college-name-error">Please enter a valid college name.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Mobile No</label>
                        <input class="form-control" name="mobile_no" type="text" placeholder="Mobile No" required value="{{ $tea->mobile_no }}">
                        <div class="invalid-feedback mobile-no-error">Please enter a valid mobile number.</div>
                    </div>
                    <div class="form-group mb-3">
                       
                        <input class="form-control team-leader-email" name="team_leader_email" type="email" placeholder="Team Leader Email" required value="{{ $tea->team_leader_email }}" hidden>

                    </div>

                    <!-- Team member input boxes will be dynamically generated here -->
                    <div id="team-member-inputs">
                        @php
                            $festMaxTeamSize = DB::table('fest')->where('fest_name', session('festname'))->value('maxteamsize');
                        @endphp

                        @for ($i = 1; $i <= $festMaxTeamSize - 1; $i++)
                            <div class="form-group mb-3">
                                <label>Team Member {{ $i }}</label>
                                <input class="form-control team-member-name" name="team_member_{{ $i }}" type="text" placeholder="Team Member {{ $i }}" value="{{ $tea->{'team_member_'.$i} ?? '' }}">
                                <div class="invalid-feedback team-member-name-error">Please enter a valid team member name.</div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Team Member {{ $i }} Email</label>
                                <input class="form-control team-member-email" name="team_member_{{ $i }}_email" type="email" placeholder="Team Member {{ $i }} Email" value="{{ $tea->{'team_member_'.$i.'_email'} ?? '' }}">
                                <div class="invalid-feedback team-member-email-error">Please enter a valid email address for Team Member {{ $i }}.</div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Team Member {{ $i }} Reg No</label>
                                <input class="form-control team-member-regno" name="team_member_{{ $i }}_regno" type="text" placeholder="Team Member {{ $i }} Reg no" value="{{ $tea->{'team_member_'.$i.'_regno'} ?? '' }}">
                                <div class="invalid-feedback team-member-regno-error">Please enter a valid registration number for Team Member {{ $i }}.</div>
                            </div>
                        @endfor
                    </div>

                    <input type="hidden" name="team_leader_name" value="{{ session('name') }}">
                    <input type="hidden" name="team_leader_regno" value="{{ session('regno') }}">

                    <input type="hidden" name="fest" value="{{ session('festname') }}">
                    <input type="hidden" name="regno" value="{{ session('regno') }}">
                    @endforeach

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading"  style="font-size:20px;font-weight:bold;">Events</div>
                <h2 class="h2-heading">Events conducted by the {{session('department')}} department include both technical and non-technical activities.</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card 1 -->@foreach($data as $events)
                <!-- <div class="card" style="width: 18rem;">
                        <img class="img-fluid" src="{{asset($events->image)}}" alt="alternative">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                </div> -->
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{asset($events->image)}}" alt="alternative">
                    </div>
                    <div class="card-body">
                   

                    <p><strong>Event Name:</strong> {{$events->name}}</p>
                    <p><strong>Participant Type:</strong> {{ $events->type }}</p>
                    <p><strong>Department:</strong> {{ $events->department }}</p>
                    @if($events->payment == 'Free')
                    <p><strong>Cost:</strong> Free</p>
                    @else
                    <p><strong>Cost:</strong> Paid</p>
                    @endif
                    <p><strong>Event Details:</strong>{!! $events->details !!}</p>
                    <p><strong>Event Rules:</strong>{!! $events->rules !!}</p>
    
            @if($events->type == 'Individual')
            <form id="registrationForm_{{ $events->id }}" action="/individualregistration" method="POST">
                            @csrf
                            <input type="hidden" name="eventname" value="{{ $events->name }}">
                            <input type="hidden" name="type" value="{{ $events->type }}">
                            <input type="hidden" name="eventdept" value="{{ $events->department }}">
                            <input type="hidden" name="name" value="{{ session('name') }}">
                            <input type="hidden" name="department" value="{{ session('department') }}">
                            <input type="hidden" name="regno" value="{{ session('regno') }}">
                            <input type="hidden" name="fest" value="{{ $events->fest }}">
                            <input type="hidden" name="eventtype" value="{{ $events->eventtype }}">
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <input type="hidden" name="payment" value="{{ $events->payment }}">
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('regevent')
        ->where('regno', session('regno'))
        ->where('dept', session('department'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp

    <button type="submit" class="btn btn-primary individual-register-btn" data-id="{{ $events->id }}" {{ $disabled }}>Individual Registration</button>
                        </form>
                        @elseif($events->type == 'Group')
                        @php

$teamss = DB::table('teams')->where('team_leader_regno', session('regno'))->get();

// Retrieve existing data from the table
$existingData = DB::table('teams')
    ->where('userreg', session('regno'))
    ->where('fest', session('festname'))
    ->first();

// Check if the eventname is present in the registered events
$appendedValueExists = $existingData && strpos($existingData->registered_events, $events->name) !== false;

// Set disabled attribute based on whether the eventname exists in the registered events
$disabled = $appendedValueExists ? 'disabled' : '';

@endphp

                      
<button type="button" class="btn btn-primary" id="groupRegistrationBtn" data-toggle="modal" data-target="#teamMemberModal_{{ $events->id }}" {{ $disabled }} >Group Registration</button>

<div class="modal fade" id="teamMemberModal_{{ $events->id }}" tabindex="-1" role="dialog" aria-labelledby="teamMemberModalLabel_{{ $events->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teamMemberModalLabel">Select Team Members</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="teamMemberForm" action="/storeTeamManager" method="POST">
                    @csrf
      
                    @foreach($teamss as $team)
                        @foreach($price as $pri)
                            @php
                                $teamSize = $pri->maxteamsize;
                            @endphp
                        @endforeach
                        <input type="hidden" name="team_name" value="{{ $team->team_name }}">
                        <input type="hidden" name="fest" value="{{ $events->fest }}">
                        <input type="hidden" name="eventname" value="{{ $events->name }}">
                        <input type="hidden" name="maxteam" value="{{ $teamSize }}">
                        <input type="hidden" name="teammax" value="{{ $events->teamsize}}">
                        <input type="hidden" name="userreg" value="{{ session('regno') }}">
                        <input type="hidden" name="type" value="{{ $events->type }}">
                        <input type="hidden" name="team_leader_name" value="{{ session('name') }}">
                        <input type="hidden" name="team_leader_regno" value="{{ session('regno') }}">
                        <input type="hidden" name="team_leader_email" value="{{ session('email') }}">
                        <input type="hidden" name="payment" value="{{ $events->payment }}">
                        <div class="row">
                            <div class="col-md-12">
                                @for ($i = 1; $i <= $teamSize; $i++)
                                    @php
                                        $memberNameColumn = 'team_member_' . $i;
                                        $memberRegnoColumn = 'team_member_' . $i . '_regno'; // Corrected variable name
                                        $memberEmailColumn = 'team_member_' . $i . '_email'; // Corrected variable name
                                    @endphp
                                    @if (!empty($team->$memberNameColumn))
                                        <div class="form-check">
                                            <input class="form-check-input team-member-checkbox" type="checkbox" id="team_member_{{ $i }}" name="team_members[]" value="{{ $team->$memberNameColumn }}|{{ $team->$memberRegnoColumn }}|{{ $team->$memberEmailColumn }}" />
                                            <label class="form-check-label" for="team_member_{{ $i }}">Team Member {{ $i }}: {{ $team->$memberNameColumn }}</label>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button> <!-- Keep type="submit" for form submission -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('[id^=teamMemberForm]').submit(function(event) {
        // Prevent the default form submission
        
        var form = $(this);
        var modalId = form.closest('.modal').attr('id');

        // Get form data
        var teamName = form.find('input[name="team_name"]').val();
        var fest = form.find('input[name="fest"]').val();
        var eventname = form.find('input[name="eventname"]').val();
        var maxteam = form.find('input[name="maxteam"]').val();
        var userreg = form.find('input[name="userreg"]').val();
        var type = form.find('input[name="type"]').val();
        var leadername = form.find('input[name="team_leader_name"]').val();
        var leaderreg = form.find('input[name="team_leader_regno"]').val();
        var leaderemail = form.find('input[name="team_leader_email"]').val();
        var selectedMembers = [];

        // Get selected team members
        form.find('input[name="team_members[]"]:checked').each(function() {
            var memberData = $(this).val().split('|');
            selectedMembers.push({
                name: memberData[0],
                regno: memberData[1],
                email: memberData[2]
            });
        });

        // AJAX request to store selected team members
        $.ajax({
            url: '/storeTeamManager',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                team_name: teamName,
                fest: fest,
                eventname: eventname,
                maxteam: maxteam,
                userreg: userreg,
                type: type,
                team_leader_name: leadername,
                team_leader_regno: leaderreg,
                team_leader_email: leaderemail, 
                team_members: selectedMembers
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                // Close the modal
                $('#' + modalId).modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });

    // Add event listener to each checkbox
    $('[id^=teamMemberModal]').on('change', '.team-member-checkbox', function() {
        var modalId = $(this).closest('.modal').attr('id');
        // Get the number of checked checkboxes
        var checkedCount = $('#' + modalId + ' .team-member-checkbox:checked').length;
        // Get the maximum team size from the hidden input field
        var maxTeamSize = parseInt($('#' + modalId + ' input[name="teammax"]').val());
        // Loop through each checkbox and disable it if the maximum team size is reached
        $('#' + modalId + ' .team-member-checkbox').each(function() {
            if (checkedCount >= maxTeamSize && !$(this).prop('checked')) {
                $(this).prop('disabled', true);
            } else {
                $(this).prop('disabled', false);
            }
        });
    });
});
</script>



         
           


    @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading" style="font-size:20px;font-weight:bold;">Events</div>
                <h2 class="h2-heading">Students from the {{session('department')}} department and all other departments can participate in the events, which include both technical and non-technical activities.</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card 1 -->@foreach($all as $events)
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{asset($events->image)}}" alt="alternative">
                    </div>
                    <div class="card-body">
                       
                        <p><strong>Event Name:</strong> {{$events->name}}</p>
                    <p><strong>Participant Type:</strong> {{ $events->type }}</p>
                    <p><strong>Department:</strong> {{ $events->department }}</p>
                    @if($events->payment == 'Free')
                    <p><strong>Cost:</strong> Free</p>
                    @else
                    <p><strong>Cost:</strong> Paid</p>
                    @endif
                    <p><strong>Event Details:</strong>{!! $events->details !!}</p>
                    <p><strong>Event Rules:</strong>{!! $events->rules !!}</p>
                        @if($events->type == 'Individual')
                        <form id="registrationForm_{{ $events->id }}" action="/individualregistration" method="POST">
                            @csrf
                            <input type="hidden" name="eventname" value="{{ $events->name }}">
                            <input type="hidden" name="type" value="{{ $events->type }}">
                            <input type="hidden" name="eventdept" value="{{ $events->department }}">
                            <input type="hidden" name="name" value="{{ session('name') }}">
                            <input type="hidden" name="department" value="{{ session('department') }}">
                            <input type="hidden" name="regno" value="{{ session('regno') }}">
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <input type="hidden" name="fest" value="{{ $events->fest }}">
                            <input type="hidden" name="eventtype" value="{{ $events->eventtype }}">
                            <input type="hidden" name="payment" value="{{ $events->payment }}">
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('regevent')
        ->where('regno', session('regno'))
        ->where('dept', session('department'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp
<button type="submit" class="btn btn-primary individual-register-btn" data-id="{{ $events->id }}" {{ $disabled }}>Individual Registration</button>
                        </form>

                        @elseif($events->type == 'Group') 
                        @php

$teamss = DB::table('teams')->where('team_leader_regno', session('regno'))->get();

// Retrieve existing data from the table
$existingData = DB::table('teams')
    ->where('userreg', session('regno'))
    ->where('fest', session('festname'))
    ->first();

// Check if the eventname is present in the registered events
$appendedValueExists = $existingData && strpos($existingData->registered_events, $events->name) !== false;

// Set disabled attribute based on whether the eventname exists in the registered events
$disabled = $appendedValueExists ? 'disabled' : '';

@endphp

<button type="button" class="btn btn-primary" id="groupRegistrationBtn" data-toggle="modal" data-target="#teamMemberModal_{{ $events->id }}" {{ $disabled }}>Group Registration</button>
<div class="modal fade" id="teamMemberModal_{{ $events->id }}" tabindex="-1" role="dialog" aria-labelledby="teamMemberModalLabel_{{ $events->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teamMemberModalLabel">Select Team Members</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="teamMemberForm" action="/storeTeamManager" method="POST">
                    @csrf
      
                    @foreach($teamss as $team)
                        @foreach($price as $pri)
                            @php
                                $teamSize = $pri->maxteamsize;
                            @endphp
                        @endforeach
                        <input type="hidden" name="team_name" value="{{ $team->team_name }}">
                        <input type="hidden" name="fest" value="{{ $events->fest }}">
                        <input type="hidden" name="eventname" value="{{ $events->name }}">
                        <input type="hidden" name="maxteam" value="{{ $teamSize }}">
                        <input type="hidden" name="teammax" value="{{ $events->teamsize}}">
                        <input type="hidden" name="userreg" value="{{ session('regno') }}">
                        <input type="hidden" name="type" value="{{ $events->type }}">
                        <input type="hidden" name="team_leader_name" value="{{ session('name') }}">
                        <input type="hidden" name="team_leader_regno" value="{{ session('regno') }}">
                        <input type="hidden" name="team_leader_email" value="{{ session('email') }}">
                        <input type="hidden" name="payment" value="{{ $events->payment }}">
                        <div class="row">
                            <div class="col-md-12">
                                @for ($i = 1; $i <= $teamSize; $i++)
                                    @php
                                        $memberNameColumn = 'team_member_' . $i;
                                        $memberRegnoColumn = 'team_member_' . $i . '_regno'; // Corrected variable name
                                        $memberEmailColumn = 'team_member_' . $i . '_email'; // Corrected variable name
                                    @endphp
                                    @if (!empty($team->$memberNameColumn))
                                        <div class="form-check">
                                            <input class="form-check-input team-member-checkbox" type="checkbox" id="team_member_{{ $i }}" name="team_members[]" value="{{ $team->$memberNameColumn }}|{{ $team->$memberRegnoColumn }}|{{ $team->$memberEmailColumn }}" />
                                            <label class="form-check-label" for="team_member_{{ $i }}">Team Member {{ $i }}: {{ $team->$memberNameColumn }}</label>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button> <!-- Keep type="submit" for form submission -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('[id^=teamMemberForm]').submit(function(event) {
        // Prevent the default form submission
        
        var form = $(this);
        var modalId = form.closest('.modal').attr('id');

        // Get form data
        var teamName = form.find('input[name="team_name"]').val();
        var fest = form.find('input[name="fest"]').val();
        var eventname = form.find('input[name="eventname"]').val();
        var maxteam = form.find('input[name="maxteam"]').val();
        var userreg = form.find('input[name="userreg"]').val();
        var type = form.find('input[name="type"]').val();
        var leadername = form.find('input[name="team_leader_name"]').val();
        var leaderreg = form.find('input[name="team_leader_regno"]').val();
        var leaderemail = form.find('input[name="team_leader_email"]').val();
        var selectedMembers = [];

        // Get selected team members
        form.find('input[name="team_members[]"]:checked').each(function() {
            var memberData = $(this).val().split('|');
            selectedMembers.push({
                name: memberData[0],
                regno: memberData[1],
                email: memberData[2]
            });
        });

        // AJAX request to store selected team members
        $.ajax({
            url: '/storeTeamManager',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                team_name: teamName,
                fest: fest,
                eventname: eventname,
                maxteam: maxteam,
                userreg: userreg,
                type: type,
                team_leader_name: leadername,
                team_leader_regno: leaderreg,
                team_leader_email: leaderemail, 
                team_members: selectedMembers
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                // Close the modal
                $('#' + modalId).modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });

    // Add event listener to each checkbox
    $('[id^=teamMemberModal]').on('change', '.team-member-checkbox', function() {
        var modalId = $(this).closest('.modal').attr('id');
        // Get the number of checked checkboxes
        var checkedCount = $('#' + modalId + ' .team-member-checkbox:checked').length;
        // Get the maximum team size from the hidden input field
        var maxTeamSize = parseInt($('#' + modalId + ' input[name="teammax"]').val());
        // Loop through each checkbox and disable it if the maximum team size is reached
        $('#' + modalId + ' .team-member-checkbox').each(function() {
            if (checkedCount >= maxTeamSize && !$(this).prop('checked')) {
                $(this).prop('disabled', true);
            } else {
                $(this).prop('disabled', false);
            }
        });
    });
});
</script>









       

              
                        

                



    @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>





<script>
    function showPopupForm() {
        $('#popupForm').modal('show');
    }
</script>
<script>
    $(document).ready(function() {
        $('.individual-register-btn').click(function() {
            var eventId = $(this).data('id');
            var formData = $('#registrationForm_' + eventId).serialize();
            $.ajax({
                url: '/individualregistration', // Updated URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Registration successful!');
                    // Handle success, if needed
                },
                error: function(xhr, status, error) {
                    alert('Registration failed. Please try again later.');
                    // Handle error, if needed
                }
            });
        });

     
    });
</script>

@if(session('success'))
    <div id="notification-success" style="width: 300px; height: auto; background-color: #1cc88a; color: black; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/success.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Success</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                {{ session('success') }}
            </ul>
        </div>
    </div>
@endif

@if (session('error'))
    <div id="notification-error" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                {{ session('error') }}
            </ul>
        </div>
    </div>
@endif

<script>
    // Function to hide the success notification after 10 seconds
    setTimeout(function() {
        document.getElementById('notification-success').style.display = 'none';
    }, 5000);

    // Function to hide the error notification after 10 seconds
    setTimeout(function() {
        document.getElementById('notification-error').style.display = 'none';
    }, 5000);
</script>

<script>
    $(document).ready(function () {
        // Function to generate team member input boxes based on max team size
        function generateTeamMemberInputs(maxTeamSize) {
            var teamMemberInputs = '';
            for (var i = 1; i <= maxTeamSize; i++) {
                teamMemberInputs += `
                    <div class="form-group mb-3">
                        <label>Team Member ${i}</label>
                        <input class="form-control team-member-name" name="team_member_${i}" type="text" placeholder="Team Member ${i}">
                        <div class="invalid-feedback team-member-name-error">Please enter a valid team member name.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Team Member ${i} Email</label>
                        <input class="form-control team-member-email" name="team_member_${i}_email" type="email" placeholder="Team Member ${i} Email">
                        <div class="invalid-feedback team-member-email-error">Please enter a valid email address for Team Member ${i}.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Team Member ${i} Reg No</label>
                        <input class="form-control team-member-regno" name="team_member_${i}_regno" type="text" placeholder="Team Member ${i} Reg no">
                        <div class="invalid-feedback team-member-regno-error">Please enter a valid registration number for Team Member ${i}.</div>
                    </div>
                `;
            }
            $('#team-member-inputs').html(teamMemberInputs);
        }

        // Event listener for team name validation
        $('input[name="team_name"]').on('input', function () {
            var value = $(this).val();
            if (!/^[A-Za-z ]+$/.test(value)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Event listener for college name validation
        $('input[name="college_name"]').on('input', function () {
            var value = $(this).val();
            if (!/^[A-Za-z ]+$/.test(value)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Event listener for team member name validation
        $('#team-member-inputs').on('input', '.team-member-name', function () {
            var value = $(this).val();
            if (!/^[A-Za-z ]+$/.test(value)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Event listener for team member roll number validation
        $('#team-member-inputs').on('input', '.team-member-regno', function () {
            var value = $(this).val();
            if (!/^\d+$/.test(value)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Event listener for mobile number validation
        $('input[name="mobile_no"]').on('input', function () {
            var value = $(this).val();
            if (!/^\d{10}$/.test(value)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Generate team member inputs based on max team size
        var maxTeamSize = $('#max-team-size').val();
        generateTeamMemberInputs(maxTeamSize);
    });
</script>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
