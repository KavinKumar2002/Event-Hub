<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mark allocate</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">

    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        
        .my-custom-scrollbar {
position: relative;
height: 200px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}
img{
    margin-right:20px;
    cursor:pointer;
}
    </style>
</head>

<body>
  
    @include('sidebar')

       
          
            <div class="container-fluid" style="margin-top:20px !important">

                <div class="card shadow">
                    <div class="card-header py-3">

                        <div class="row" style="overflow: hidden;">
                            <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                                <p class="text-primary m-0 fw-bold mk">Individual Event </p>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end dataTables_filter" id="dataTable_filter"
                                    style="margin-right:20px">
                                    
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="table-responsive table mt-2" id="dataTable-1" role="grid"
                            aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                <tr>
    <th>Name</th>
    <th>Fest</th>
    <th>Event</th>
    <th colspan="2">Reg No</th>
    <th >Mark</th>

</tr>

                                </thead>
                                <tbody>
                                   
                                @foreach($sep as $seps)
    <tr>    
        <td>{{$seps->name}}</td>
        <td>{{$seps->fest}}</td>
        <td>{{$seps->event}}</td>
        <td>{{$seps->regno}}</td>
        <td><div class="input-group input-group-sm mb-3">
        <form method="post" action="/allocatemarks">
    @csrf
    <div class="input-group-append">
    <input type="hidden" name="name" value="{{$seps->name}}">
    <input type="hidden" name="fest" value="{{$seps->fest}}">
    <input type="hidden" name="event" value="{{$seps->event}}">
    <input type="hidden" name="regno" value="{{$seps->regno}}">
    <td>
    @if ($seps->mark)
        <button class="btn btn-outline-secondary" type="button" disabled>Marks Assigned</button>
    @else
   
    <input type="text" class="form-control" name="mark" placeholder="Enter Marks"  aria-describedby="basic-addon2"></td>
    <td>   <button class="btn btn-outline-secondary" type="submit">submit</button>
    @endif</td>
 
</div>

    </div>
</form>


    </tr>
    <!-- Modal -->
<div class="modal fade" id="exampleModalCenter_{{ $seps->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="text" class="form-control" name="mark" placeholder="Enter Marks"  aria-describedby="basic-addon2">
        
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-outline-secondary" type="submit">submit</button>
      </div>
      </div>
      
    </div>
  </div>
</div>
@endforeach



                                </tbody>
                               
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
         
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
 

    
</body>

</html>