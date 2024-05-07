<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Event add..</title>
<link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
<link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/js/bs-init.js"></script>
<script src="/bootstrap/js/theme.js"></script>
</head>
<body>

@include('sidebar')

<div class="padding">
    <div class="row justify-content-center " style="">
        <div class="col-md-9 col-lg-4 w-75 h-50 ">
            <form action="/events" method="post" style="padding: 60px;" enctype="multipart/form-data">
                @csrf
                <h5 class="h3 mb-0 text-gray-800" >Assign Events</h5>
                <div class="card-body mb-30 h-70" style="margin-bottom:20px;">
                    <div class="form-group h-40" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Event Name</label>
                            <input class="form-control" name="eventname" id="eventNameInput" type="text" placeholder="Event name" required>
                            <div id="eventNameError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Image</label>
                            <input class="form-control" type="file" name="image"/>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Category</label>
                            <select class="form-select form-select-lg mb-3" style="border-radius:160px" name="eventid">
                                <optgroup label="eventid">
                                    <option value="">Select event</option>
                                    <option value="Technical" >Technical</option>
                                    <option value="Non Technical" >Non Technical</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label>Participant Type</label>
                            <select class="form-select form-select-lg mb-3" style="border-radius:160px" name="type" id="participantType" required>
                                <optgroup label="eventid">
                                    <option value="">Select Type</option>
                                    <option value="Individual">Individual</option>
                                    <option value="Group">Group</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Team Size</label>
                        <input class="form-control" name="teamsize" id="teamSizeInput" type="number" placeholder="Team size" required min="1">
                        <div id="teamSizeError" class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Event Type</label>
                            <select class="form-select form-select-lg mb-3" style="border-radius:160px" name="eventtype">
                                <optgroup label="eventid">
                                    <option value="">Select Type</option>
                                    <option value="Open" >Open</option>
                                    <option value="Closed" >Closed</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Department</label>
                            <select class="form-select form-select-lg mb-3" style="border-radius:160px" name="department">
                                <optgroup label="department">
                                    <option value="">Select department</option>
                                    <option value="CSE" >CSE</option>
                                    <option value="ECE" >ECE</option>
                                    <option value="EEE" >EEE</option>
                                    <option value="IT" >IT</option>
                                    <option value="MECH" >MECH</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                        <div class="col-md-12">
                            <label class="labels">Payment</label>
                            <select class="form-select form-select-lg mb-3" style="border-radius: 160px" name="payment" id="paymentSelect">
                                <optgroup label="Payment">
                                    <option value="">Select Payment</option>
                                    <option value="Paid" >Paid</option>
                                    <option value="Free" >Free</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <label class="labels" style="margin-top: 10px; margin-bottom: 10px;">Details</label>
                    <textarea name="details" id="editor" cols="30" rows="10" class="form-control" ></textarea>
                    <label class="labels" style="margin-top: 10px; margin-bottom: 10px;">Rules</label>
                    <textarea name="rules" id="editor1" cols="30" rows="10" class="form-control" ></textarea>
                    <input type="hidden" name="fest" value="{{ $fest }}">
                    <button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var eventNameInput = document.getElementById('eventNameInput');
        var eventNameError = document.getElementById('eventNameError');
        var participantTypeSelect = document.getElementById('participantType');
        var teamSizeInput = document.getElementById('teamSizeInput');
        var teamSizeError = document.getElementById('teamSizeError');

        // Function to validate event name input
        function validateEventNameInput() {
            if (/[^a-zA-Z\s]/.test(eventNameInput.value)) {
                eventNameError.textContent = 'Event name should not contain special characters or digits';
            } else {
                eventNameError.textContent = '';
            }
        }

        // Event listener for event name input
        eventNameInput.addEventListener('input', validateEventNameInput);

        // Function to validate team size input
        function validateTeamSizeInput() {
            if (participantTypeSelect.value === 'Group') {
                if (teamSizeInput.value < 1) {
                    teamSizeError.textContent = 'Team size must be at least 1';
                } else {
                    teamSizeError.textContent = '';
                }
            }
        }

        // Event listener for team size input
        teamSizeInput.addEventListener('input', validateTeamSizeInput);

        // Event listener for participant type select
        participantTypeSelect.addEventListener('input', function() {
            if (participantTypeSelect.value === 'Group') {
                teamSizeInput.required = true;
                teamSizeInput.disabled = false;
                validateTeamSizeInput();
            } else {
                teamSizeInput.required = false;
                teamSizeInput.disabled = true;
                teamSizeInput.value = ''; // Clear the value when disabled
                teamSizeError.textContent = '';
            }
        });
    });
</script>

@if(session('success'))
    
<div id="notification" style="width: 300px; height: auto; background-color: #1cc88a; color: black; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
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
<div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
    <div style="flex:top;">
        <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
        <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
    </div> 
    <div class="ss" style="flex-bottom; text-size: 10px;">
        <ul>
           {{session('error')}}
        </ul>
    </div>
</div>
@endif


@if ($errors->any())
<div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
    <div style="flex:top;">
        <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
        <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
    </div> 
    <div class="ss" style="flex-bottom; text-size: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<script>
    setTimeout(function() {
        document.getElementById('notification').style.display = 'none';
    }, 5000); 
</script>

</body>
</html>
