<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <title>price</title>

  <style>
.readon {
    position: relative;
    display: inline-block !important;
    background: #1b4aef;
    padding: 14px 30px;
    line-height: normal;
    color: #ffffff !important;
    transition: all 0.3s ease 0s;
    border-radius: 30px;
    text-transform: capitalize !important;
    cursor: pointer;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    -ms-box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
}
.readon:hover,
.readon:focus {
    background: #242526;
}

.inner{
    width:100%;
    float:left;
    position:relative;
}

.pricingTable{
  margin:200px auto 0px auto;
}

.pricingTable .holder{
    background: #fff;
    box-shadow: 1px 20px 12px -15px rgba(0,0,0,0.2);
    padding: 40px 15px;
    text-align: center;
    border: 1px solid rgba(0,0,0,0.05);
    transition:0.5s ease;
}

.pricingTable .holder:hover{
    transform:translateY(-5px);
    
}



.pricingTable .holder .hdng p{
    font-size:28px;
    font-weight:bold;
    color:#242526;
}

.pricingTable .holder .img img{
    width:70%;
}

.pricingTable .holder .price p{
    color:#1b4aef;
    margin-bottom:25px;    
}

.pricingTable .holder .price p b{
    font-size:40px;
    font-weight:bold;
}

.pricingTable .holder .price p span{
    font-size:18px;
}

.pricingTable .holder .info p{
    margin-bottom:15px;
    color:#242526;
    font-weight:14px;
}

.pricingTable .holder.active{
    background:#1b4aef;
}

.pricingTable .holder.active .hdng p,
.pricingTable .holder.active .price p,
.pricingTable .holder.active .info p{
    color:#fff;
}

.pricingTable .holder.active .readon{
    background:#fff;
    color:#1b4aef!important;
}

.pricingTable .holder.active .readon:hover{
    background:#242526;
    color:#fff!important;
}

.pricingTable .tabsBtnHolder ul{
    float:left;
    display:block;
    width:100%;
    max-width:326px;   
    border-radius:1.6666666667rem;
    margin:0px auto;
    margin-bottom:40px; 
    background:#1b4aef;
    text-align:center;
    position:relative;
}

.pricingTable .tabsBtnHolder ul li{
    float:left;
    width:calc(100% / 2);
    display:inline-block;
    transition:0.4s ease;
}

.pricingTable .tabsBtnHolder ul li p{
    color:#fff;
    padding:10px 15px;
    z-index:10;
    position:relative;
    cursor:pointer;
}

.pricingTable .tabsBtnHolder ul li p.active{
    color:#1b4aef;
}

.pricingTable .tabsBtnHolder ul li.indicator{
    position: absolute;
    top: 50%;
    left: 2px; /*163px*/
    background: #fff;
    height: calc(100% - 4px);
    transform: translateY(-50%);
    border-radius: 1.5333333333rem;
    width: 161px;
    z-index:9
}






    .card1:hover {
      background:#00ffb6;
      border:1px solid #00ffb6;
    }

    .card1:hover .list-group-item{
      background:#00ffb6 !important
    }

    .md-3 >a{
      display:flex;
      align-items:center;
      justify-content:center;

    }
a>img{
width:250px;
height:auto;
margin:0px auto 0px auto;
}
    


    .card2:hover {
      background:#00C9FF;
      border:1px solid #00C9FF;
    }

    .card2:hover .list-group-item{
      background:#00C9FF !important
    }


    .card3:hover {
      background:#ff95e9;
      border:1px solid #ff95e9;
    }

    .card3:hover .list-group-item{
      background:#ff95e9 !important
    }


    .card:hover .btn-outline-dark{
      color:white;
      background:#212529;
    }

  </style>

</head>
<body>
@include('stud')

<div class="container-fluid pricingTable pt-90">
    <div class="container">
        <div class="row monthlyPriceList animated">
        @foreach($fe as $fes)
            <div class="col-md-4">
                <div class="inner holder">
                    <div class="hdng">
                        <p>Bronze Plan</p>
                    </div>
                    <div class="price mt-5">
                        <p><b>₹{{$fes->pricebronze}}</b><span></span></p>
                    </div>
                    <div class="info">
                        <p>Individual Events:{!! $fes->brindlimit !!}</p>
                        <p>Group Events:{!! $fes->brgrplimit !!}</p>
                    </div>
                    <div class="btn" style="border:2px solid black;border: radius 4px;" data-bs-toggle="modal" data-bs-target="#bronzeModal{{$fes->id}}">
                        Buy Now                    </div>
                </div>
            </div>
            <div class="modal fade" id="bronzeModal{{$fes->id}}" tabindex="-1" aria-labelledby="bronzeModalLabel{{$fes->id}}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bronzeModalLabel{{$fes->id}}">Bronze Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionId{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionId{{$fes->id}}"
                            placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUpload{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Bronze">
                    <input type="hidden" name="name" value="{{session('name')}}">
                    <input type="hidden" name="rollno" value="{{session('regno')}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>




<!-- add   <div class="col-md-4"> for prce container -->
              <div class="col-md-4">
                <div class="inner holder">
                    <div class="hdng">
                        <p>Silver Plan</p>
                    </div>
                    <div class="price mt-5">
                        <p><b>₹{{$fes->pricesilver}}</b><span></span></p>
                    </div>
                    <div class="info">
                        <p>Individual Events:{!! $fes->siindlimit !!}</p>
                        <p>Group Events:{!! $fes->sigrplimit !!}</p>
                    </div>
                    <div class="btn" style="border:2px solid black;border: radius 4px;" data-bs-toggle="modal" data-bs-target="#silverModal{{$fes->id}}">
                        Buy Now                    </div>
                </div>
            </div>
            <div class="modal fade" id="silverModal{{$fes->id}}" tabindex="-1" aria-labelledby="silverModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="silverModalLabel{{$fes->id}}">Silver Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                @csrf

                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionIdSilver{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionIdSilver{{$fes->id}}" placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUploadSilver{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Silver">
                    <input type="hidden" name="name" value="{{session('name')}}">
            <input type="hidden" name="rollno" value="{{session('regno')}}">

                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Register</button> 
            </div>
                </form>
            </div>
         
        </div>
    </div>
</div>
<!-- add   <div class="col-md-4"> for prce container -->
              <div class="col-md-4">
                <div class="inner holder">
                    <div class="hdng">
                        <p>Gold Plan</p>
                    </div>
                    <div class="price mt-5">
                        <p><b>₹{{$fes->pricegold}}</b><span></span></p>
                    </div>
                    <div class="info">
                        <p>Individual Events: {!! $fes->goindlimit !!}</p>
                        <p>Group Events:{!! $fes->gogrplimit !!}</p>
                    </div>
                    <div class="btn" style="border:2px solid black;border: radius 4px;"data-bs-toggle="modal" data-bs-target="#goldModal{{$fes->id}}" type="button">
                        Buy Now                    </div>
                </div>
            </div>

            <div class="modal fade" id="goldModal{{$fes->id}}" tabindex="-1" aria-labelledby="goldModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="goldModalLabel{{$fes->id}}">Gold Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionIdGold{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionIdGold{{$fes->id}}" placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUploadGold{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Gold">
                    <input type="hidden" name="name" value="{{session('name')}}">
                    <input type="hidden" name="rollno" value="{{session('regno')}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- add   <div class="col-md-4"> for prce container -->
        </div>
    </div>
</div>






<!--
@foreach($fe as $fes)
<div class="container-fluid">
    <div class="container p-5">
      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card card1 h-100">
            <div class="card-body">
              <h5 class="card-title">Bronze</h5>
              <br><br>
              <span class="h2">₹{{$fes->pricebronze}}</span>
              <br><br>
              <div class="d-grid my-3">
                <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal" data-bs-target="#bronzeModal{{$fes->id}}">Select</button>
              </div>
              <p><span><strong>PERKS:</strong></span></p>
              <p>INDIVIDUAL EVENTS:{!! $fes->brindlimit !!}</p>
              <p>GROUP EVENTS:{!! $fes->brgrplimit !!}</p>
            </div>
          </div>
        </div>

       
        <div class="modal fade" id="bronzeModal{{$fes->id}}" tabindex="-1" aria-labelledby="bronzeModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bronzeModalLabel{{$fes->id}}">Bronze Plan Selection</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
            </div>
            <div class="mb-3">
              <label for="transactionId{{$fes->id}}" class="form-label">Transaction ID</label>
              <input type="text" class="form-control" name="TID" id="transactionId{{$fes->id}}" placeholder="Enter Transaction ID">
            </div>
            <div class="mb-3">
              <label for="imageUpload{{$fes->id}}" class="form-label">Transaction Screenshot</label>
              <input type="file" class="form-control" name="TIM"/>
            </div>
            <input type="hidden" name="planname" value="Bronze">
            <input type="hidden" name="name" value="{{session('name')}}">
            <input type="hidden" name="rollno" value="{{session('regno')}}">
            <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Register</button> 
          
        </div>
          </form>
        </div>
     
      </div>
    </div>
  </div>
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card card2 h-100">
            <div class="card-body">
             
              <h5 class="card-title">Silver</h5>
           
              <br><br>
              <span class="h2">₹{{$fes->pricesilver}}</span>
              <br><br>
              <div class="d-grid my-3">
              <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal" data-bs-target="#silverModal{{$fes->id}}">Select</button>
              </div>
              <p><span><strong>PERKS:</strong></span></p>
              <p>INDIVIDUAL EVENTS:{!! $fes->siindlimit !!}</p>
              <p>GROUP EVENTS:{!! $fes->sigrplimit !!}</p>
            </div>

            
          </div>
       </div>

      
<div class="modal fade" id="silverModal{{$fes->id}}" tabindex="-1" aria-labelledby="silverModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="silverModalLabel{{$fes->id}}">Silver Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                @csrf

                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionIdSilver{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionIdSilver{{$fes->id}}" placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUploadSilver{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Silver">
                    <input type="hidden" name="name" value="{{session('name')}}">
            <input type="hidden" name="rollno" value="{{session('regno')}}">

                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Register</button> 
            </div>
                </form>
            </div>
         
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-12 mb-4">
    <div class="card card3 h-100">
        <div class="card-body">
            <h5 class="card-title">Gold</h5>
            <br><br>
            <span class="h2">₹{{$fes->pricegold}}</span>
            <br><br>
            <div class="d-grid my-3">
                <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal" data-bs-target="#goldModal{{$fes->id}}" type="button">Select</button>
            </div>
            <p><span><strong>PERKS:</strong></span></p>
            <p>INDIVIDUAL EVENTS: {!! $fes->goindlimit !!}</p>
            <p>GROUP EVENTS: {!! $fes->gogrplimit !!}</p>
        </div>
    </div>
</div>

<div class="modal fade" id="goldModal{{$fes->id}}" tabindex="-1" aria-labelledby="goldModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="goldModalLabel{{$fes->id}}">Gold Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionIdGold{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionIdGold{{$fes->id}}" placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUploadGold{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Gold">
                    <input type="hidden" name="name" value="{{session('name')}}">
                    <input type="hidden" name="rollno" value="{{session('regno')}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @endforeach
  -->
  </body>


  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


</body>
</html>