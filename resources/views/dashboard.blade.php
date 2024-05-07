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
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <script>
    setTimeout(function() {
        document.getElementById('notification').style.display = 'none';
    }, 2000); 
</script>
   
</head>
<body>
<div class="flex-container">
@include('sidebar')
    
    
       
        @if(session('success'))
    <div id="notification" style="width: auto; height:64px; background-color: #1cc88a; color: white; position: fixed; bottom: 10px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/success.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
           
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;padding-top:3px">
            <strong>
            {{session('success')}}
</strong>
        </div>
    </div>
    
    
    @endif
    

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        
        
        <p>Are you sure to Logout</p>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="/Logout"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yes</button></a>
      </div>
    </div>
  </div>
</div>
    
</div>   

    
  
</body>
</html>
