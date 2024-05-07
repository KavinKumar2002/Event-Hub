<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
</head>
<body>

@include('stud')

<div class="container">
    <div class="row justify-content-center" style="padding-top: 60px;">
        @foreach($events as $event)
        <div class="col-md-10 col-lg-10 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->name }}</h5>
                   
                    <form name="grpreg" action="/groupregistration" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Team Name</label>
                            <input class="form-control" name="team_name" type="text" placeholder="Team Name" required value="{{ old('team_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Name</label>
                            <input class="form-control" name="team_leader_name" type="text" placeholder="Team Leader Name" required value="{{ old('team_leader_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Email</label>
                            <input class="form-control" name="team_leader_email" type="text" placeholder="Team Leader Email" required value="{{ old('team_leader_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Reg No</label>
                            <input class="form-control" name="team_leader_regno" type="text" placeholder="Team Leader Reg Nos" required value="{{ old('team_leader_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>College Name</label>
                            <input class="form-control" name="college_name" type="text" placeholder="College Name" required value="{{ old('college_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Mobile No</label>
                            <input class="form-control" name="mobile_no" type="text" placeholder="Mobile No" required value="{{ old('mobile_no') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 1</label>
                            <input class="form-control" name="team_member_1" type="text" placeholder="Team Member 1" value="{{ old('team_member_1') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 1 Reg No</label>
                            <input class="form-control" name="team_member_1_regno" type="text" placeholder="Team Member 1 Reg no" value="{{ old('team_member_1') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 2</label>
                            <input class="form-control" name="team_member_2" type="text" placeholder="Team Member 2" value="{{ old('team_member_2') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 2 Reg No</label>
                            <input class="form-control" name="team_member_2_regno" type="text" placeholder="Team Member 2 Reg no" value="{{ old('team_member_1') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 3</label>
                            <input class="form-control" name="team_member_3" type="text" placeholder="Team Member 3" value="{{ old('team_member_3') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 3 Reg No</label>
                            <input class="form-control" name="team_member_3_regno" type="text" placeholder="Team Member 3 Reg no" value="{{ old('team_member_1') }}">
                        </div>
                        <input type="hidden" name="type" value="{{$event->type}}">
                        <input type="hidden" name="eventname" value="{{ $event->name }}">
                        <input type="hidden" name="fest" value="{{ $event->fest }}">
                        
                        <button class="btn btn-primary btn-block" type="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
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


<script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/js/bs-init.js"></script>
<script src="/bootstrap/js/theme.js"></script>

</body>
</html>
