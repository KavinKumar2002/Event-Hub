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
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
</head>
<body>

@include('stud')

<div class="padding">
    <div class="row justify-content-center" style="padding-top: 60px; margin:20px">
        @foreach($events as $event)
        <div class="col-md-6 col-lg-4 w-75 h-50 mt-20">
            <div class="card" style="padding: 20px;">
                <h5 class="h3 mb-0 text-gray-800">{{ $event->name }}</h5>
                <div class="card-body">
                
                    
                    
                    <p><strong>Participant Type:</strong> {{ $event->type }}</p>
                    <p><strong>Department:</strong> {{ $event->department }}</p>
                    <p><strong>Cost:</strong> ₹ {{ $event->cost }}</p>
                    <p><strong>Event Details:</strong>{!! $event->details !!}</p>
                    <p><strong>Event Rules:</strong>{!! $event->rules !!}</p>
                    <form name="indreg" action="/individualregistration" method="post">
                    @csrf
<input type="hidden" name="eventname" value="{{$event->name}}">
<input type="hidden" name="type" value="{{$event->type}}">
<input type="hidden" name="eventdept" value="{{$event->department}}">
  <input type="hidden" name="name" value="{{session('name')}}">

  <input type="hidden" name="department" value="{{ session('department') }}">
  <input type="hidden" name="regno" value="{{ session('regno') }}">
  <input type="hidden" name="fest" value="{{$event->fest}}">
                    <button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;" type="submit">register</button>
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
