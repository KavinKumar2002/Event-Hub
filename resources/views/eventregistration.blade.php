<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Registration</title><link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
  
<style>
    .row{
        margin:20px;

    }
</style>

</head>
<body>
<div class="flex-container">
@include('stud')
           
        <div class="page-content page-container mt-20" id="page-content">
    <div class="padding">
        <div class="row justify-content-center " style="padding-top: 60px; margin:20px">
<div class="col-md-6 col-lg-4 w-75 h-50 mt-20">
            <form class="card" action="/registrations" method="post" style="padding: 60px;">
            @csrf
              <h5 class="h3 mb-0 text-gray-800" >Events Registration</h5>
<span style="padding-top:20px">Please check the box to indicate your participation in the event.</span>
              <div class="card-body mb-30 h-70" style="margin-bottom:20px;">

              <div class="form-group h-40" style="margin-top: 10px; margin-bottom: 10px;">
              @foreach($data as $events)
<div class="col-md-12">
    <input class="form-check-input" type="checkbox" name="data[]" value="{{$events->name}}" id="flexCheck{{$events->name}}">
    <label class="form-check-label" for="flexCheck{{$events->name}}">
    <h3 style="font-size: 20px; font-weight: bolder; color: black;">{{$events->name}}(
    {{$events->event_id}})</h3>

    </label>
    <div class="modal-body" Style="padding-left:30px">
        <strong>Department :</strong> 
        @if($events->department == 'ALL')
            All Department Student can Participate
        @else
            {{$events->department}}
        @endif
        <hr>
        <p>Details: {!! $events->details !!}</p>
        <hr>
        <p>Rules: {!! $events->rules !!}</p>
    </div>
</div>
@endforeach


</div>




<input type="hidden" name="fest" value="{{$fest }}">
<input type="hidden" name="email" value="{{session('email') }}">
<input type="hidden" name="regno" value="{{session('regno')}}">
  <input type="hidden" name="name" value="{{session('name')}}">
  <input type="hidden" name="department" value="{{ session('department') }}">
                <button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;">Submit</button>
              </div>
            </form>
          </div>
           </div>
            </div>
             </div>


        















   @if (session()->has('error'))
    <div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex: top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                <li>{{ session('error') }}</li>
            </ul>
        </div>
    </div>
@endif









   @if ($errors->any())
    <div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 10px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
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
      
   </div>


</div>  

</script>
</body>
</html>
