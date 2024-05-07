<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <script>
    // Get the current system date
var currentDate = new Date();

// Format the date as desired (e.g., "YYYY-MM-DD HH:MM:SS")
var formattedDate = currentDate.toISOString().slice(0, 19).replace('T', ' ');

// Set the formatted date as the value of the hidden input field
document.getElementById('systemDate').value = formattedDate;
</script>   
</head>
<body style="margin-top:60px">
    @include('sidebar')
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <h6 class="text-primary fw-bold m-0">{{$event}}</h6>
    <form method="post" action="/generateCertificate">
    @csrf
    
    <input type="hidden" name="eventname" value="{{$event}}">

        <button class="btn btn-bold btn-primary" type="submit">Generate Certificate</button>
    
</form>
</div>
    <div class="card-body">
    @foreach($topThree as $index => $item)
    <h4 class="small fw-bold">{{$item->name}}<span class="float-end">{{$item->mark}}</span></h4>
    <div class="progress mb-4">
        <?php
        // Normalize the mark to a percentage out of 100
        $percentage = ($item->mark / 100) * 100;
        ?>
        <div class="progress-bar bg-{{ $index === 0 ? 'success' : ($index === 1 ? 'warning' : 'primary')}}" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;">
            <span class="visually-hidden">{{$percentage}}%</span>
        </div>
    </div>
@endforeach
@foreach($next as $index => $item)
    <h4 class="small fw-bold">{{$item->name}}<span class="float-end">{{$item->mark}}</span></h4>
    <div class="progress mb-4">
        <?php
        // Normalize the mark to a percentage out of 100
        $percentage = ($item->mark / 100) * 100;
        ?>
        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;">
            <span class="visually-hidden">{{$percentage}}%</span>
        </div>
    </div>
@endforeach

    </div>
</div>
</body>
</html>
