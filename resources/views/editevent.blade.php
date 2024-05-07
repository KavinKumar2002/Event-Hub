<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Edit Event</title>
<link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
<link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/js/bs-init.js"></script>
<script src="/bootstrap/js/theme.js"></script>
</head>
<body>
<div class="flex-container">
@include('sidebar')
<div class="page-content page-container mt-20" id="page-content">
<div class="padding">
<div class="row justify-content-center " style="padding-top: 60px; margin:20px">
<div class="col-md-6 col-lg-4 w-75 h-50 mt-20">
<form class="card" action="/eventsedit" method="post" style="padding: 60px;">
@csrf
<h5 class="h3 mb-0 text-gray-800" >Assign Events</h5>
<div class="card-body mb-30 h-70" style="margin-bottom:20px;">
<div class="form-group h-40" style="margin-top: 10px; margin-bottom: 10px;">
<div class="col-md-12">
<label class="labels">Event Name</label>
<input class="form-control" name="eventname" type="text" placeholder="Event name" required value="{{$event->name}}">
</div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
<div class="col-md-12">
<label class="labels">Category</label>
<select class="form-select form-select-lg mb-3"style="border-radius:160px" name="eventid">
<optgroup label="eventid">
<option value="">Select event</option>
<option value="Technical" {{ $event->event_id == 'Technical' ? 'selected' : '' }}>Technical</option>
<option value="Non Technical" {{ $event->event_id == 'Non Technical' ? 'selected' : '' }}>Non Technical</option>
</optgroup>
</select>
</div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
<div class="col-md-12">
<label class="labels">Participant Type</label>
<select class="form-select form-select-lg mb-3"style="border-radius:160px" name="type" id="participantType">
<optgroup label="type">
<option value="">Select Type</option>
<option value="Individual" {{ $event->type == 'Individual' ? 'selected' : '' }}>Individual</option>
<option value="Group" {{ $event->type == 'Group' ? 'selected' : '' }}>Group</option>
</optgroup>
</select>
</div>
</div>
<div class="col-md-12">
<label>Team Size *</label>
<input class="form-control" name="teamsize" type="number" placeholder="Team size" required min="1" {{ $event->type == 'Individual' ? 'disabled' : '' }}>
<div class="invalid-feedback"></div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
<div class="col-md-12">
<label class="labels">Event Type</label>
<select class="form-select form-select-lg mb-3"style="border-radius:160px" name="eventtype">
<optgroup label="eventtype">
<option value="">Select Type</option>
<option value="Open" {{ $event->eventtype == 'Open' ? 'selected' : '' }}>Open</option>
<option value="Closed" {{ $event->eventtype == 'Closed' ? 'selected' : '' }}>Closed</option>
</optgroup>
</select>
</div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
<div class="col-md-12">
<label class="labels">Department</label>
<select class="form-select form-select-lg mb-3"style="border-radius:160px" name="department">
<optgroup label="department">
<option value="">Select department</option>
<option value="CSE" {{ $event->department == 'CSE' ? 'selected' : '' }}>CSE</option>
<option value="ECE" {{ $event->department == 'ECE' ? 'selected' : '' }}>ECE</option>
<option value="IT" {{ $event->department == 'IT' ? 'selected' : '' }}>IT</option>
<option value="EEE" {{ $event->department == 'EEE' ? 'selected' : '' }}>EEE</option>
<option value="MECH" {{ $event->department == 'MECH' ? 'selected' : '' }}>MECH</option>
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
<option value="Paid" {{ $event->payment == 'Paid' ? 'selected' : '' }}>Paid</option>
<option value="Free" {{ $event->payment == 'Free' ? 'selected' : '' }}>Free</option>
</optgroup>
</select>
</div>
</div>
<label class="labels" style="margin-top: 10px; margin-bottom: 10px;">Details</label>
<textarea name="details" id="editor" cols="30" rows="10" class="form-control" >{{$event->details}}</textarea>
<label class="labels" style="margin-top: 10px; margin-bottom: 10px;">Rules</label>
<textarea name="rules" id="editor1" cols="30" rows="10" class="form-control" >{{$event->rules}}</textarea>
<input type="hidden" name="id" value="{{ $event->id }}">
<input type="hidden" name="fest" value="{{ $event->fest }}">
<button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
var inputs = document.querySelectorAll('input, select, textarea');

inputs.forEach(function(input) {
input.addEventListener('input', function() {
validateInput(input);
});
});

var participantTypeSelect = document.getElementById('participantType');
var teamSizeInput = document.querySelector('input[name="teamsize"]');

participantTypeSelect.addEventListener('change', function() {
if (participantTypeSelect.value === 'Group') {
teamSizeInput.required = true;
teamSizeInput.disabled = false;
} else {
teamSizeInput.required = false;
teamSizeInput.disabled = true;
teamSizeInput.value = ''; // Clear the value when disabled
validateInput(teamSizeInput); // Re-validate the Team Size input
}
});
});

function validateInput(input) {
var isValid = true;
var errorMessage = '';

if (input.hasAttribute('required') && input.value.trim() === '') {
isValid = false;
errorMessage = 'This field is required';
}

if (input.getAttribute('name') === 'eventname' && !/^[a-zA-Z\s]*$/.test(input.value.trim())) {
isValid = false;
errorMessage = 'Only alphabets and spaces are allowed';
}

if (input.getAttribute('name') === 'teamsize' && input.value.trim() !== '' && isNaN(input.value)) {
isValid = false;
errorMessage = 'Team Size must be a number';
}

if (!isValid) {
input.classList.add('is-invalid');
input.nextElementSibling.textContent = errorMessage;
} else {
input.classList.remove('is-invalid');
input.nextElementSibling.textContent = '';
}
}
</script>
<script>
     ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('#editor1'))
        .catch(error => {
            console.error(error);
        });
</script>

</body>
</html>
