<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        setTimeout(function () {
            document.getElementById('notification').style.display = 'none';
        }, 2000); 
    </script>
    <style>
        body {
            margin-top: 80px;
            font-family: Arial, sans-serif;
            /* Added a generic font-family */
        }

        .cards-container {
            width: 80%;
            height: auto;
            display: flex;
            flex-wrap: wrap;
            margin:auto;
            /* Added flex-wrap to allow cards to wrap to new line */
            gap: 20px;
            /* Added gap between cards */
        }

        .cards-body {  
 
             
            width: 300px;
            height: 430px;

            display: flex;
            flex-direction: column;
            /* Added flex-direction to stack content */
        }

        .img-cont { height: 60%;
    position: relative;
    overflow: hidden;
    margin-left: 15px;
    margin-right: 15px;
    margin-top: -30px;
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.63);}


        .img-cont img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Ensures the image covers the container */
        }

        .content-body {
            padding: 10px;
            /* Increased padding */
            overflow: hidden;
        }

        .cont-title {
            color: #223352;
            font-size: 24px;
            /* Changed font-size to a reasonable value */
            font-weight: bold;
            /* Used 'bold' instead of 'semibold' */
            margin-bottom: 10px;
            /* Added margin for spacing */
        }

        .text{
            height:120px;
            overflow:hide;
        }
        .notifications {
            margin-top:10px;
            width: 100%;
            padding:1px;
            /* Increased padding */
            display: flex;
            align-items: center;
            /* Align items horizontally */
            justify-content: space-between;
            /* Distribute space evenly */
        }

        .notifications span {
            margin-right: 10px;
            /* Adjusted margin */
        }

        .notifications .button1 {
            padding: 8px;
            width: 130px;
            border: none;
            background-color: #007bff;
            /* Added background color */
            color: #fff;
            /* Added text color */
            cursor: pointer;
            border-radius: 5px;
            text-align:center;
            &:hover{
                text-decoration:none;
            }
        }
.constaints{ box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}
       
    </style>

</head>

<body> @include('stud')
    <div class="flex-container">
       



        @if(session('success'))
        <div id="notification"
            style="width: auto; height:64px; background-color: #1cc88a; color: white; position: fixed; bottom: 10px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
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
                        <a href="/Logout"><button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Yes</button></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <h3 style="margin:20px">Ongoing Fest</h3>


    <div class="cards-container"> 
        @foreach($events as $event)
        <div class="cards-body constaints" style="margin: 40px 0px 10px 0px;padding:5px">
            <div class="img-cont">
                <img src="{{ asset($event->image) }}" alt="">
            </div>
            <div class="content-body">
                <div class="cont-title"style="font-size:20px;
  color:#223342;
  font-weight:700;text-transform:uppercase;">{{$event->fest_name}}</div>
                <div class="text">{!! $event->details !!}</div>
            </div>
            <div class="notifications">
                <span>From {{ $event->start }}</span>
                <?php $userExists = false; ?>
                @foreach($check as $ch)
                @if($ch->rollno == session('regno') && $ch->fest == $event->fest_name)
                <?php $userExists = true; ?>
                @if($ch->status == "verified")
                <a href="/sfest/details/{{$event->fest_name}}/{{session('department')}}" class="button1"
                    id="statusButton">View</a>
                @elseif($ch->status == "pending")
                <button id="pendingButton" class="button1" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Pending...
                </button>
                @endif
                @break
                @endif
                @endforeach

                @if(!$userExists)
                <a href="/plans/{{$event->fest_name}}" class="button1">Register Now</a>
                @endif

                <script>
                    function checkUserStatus() {
                        // Send AJAX request to check user status
                        $.ajax({
                            type: 'POST',
                            url: '/check-status', // Endpoint to check user status
                            data: {
                                rollno: '{{ session('regno') }}',
                                fest_name: '{{ $event->fest_name }}'
                            },
                            success: function (response) {
                                // Update buttons based on user status
                                if (response.status === 'verified') {
                                    $('#statusButton').show();
                                    $('#pendingButton').hide();
                                } else if (response.status === 'pending') {
                                    $('#statusButton').hide();
                                    $('#pendingButton').show();
                                } else {
                                    $('#statusButton').hide();
                                    $('#pendingButton').hide();
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error checking user status:', error);
                            }
                        });
                    }

                    // Check user status initially
                    checkUserStatus();

                    // Periodically check user status every 5 seconds
                    setInterval(checkUserStatus, 5000); // Adjust interval as needed
                </script>


            </div>


                </div>

            @endforeach
        </div>



        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>