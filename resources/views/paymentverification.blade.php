<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verfication</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 200px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        img {
            margin-right: 20px;
            cursor: pointer;
        }
        .modal-body {
            width:340px;
            height:auto;
            margin:0px auto 0px auto;
        }
        .modal-body > img{
            width:300px;
            height:auto;
        }
    </style>
</head>

<body>

    @include('sidebar')
    <div class="page-content page-container mt-20" id="page-content" style="margin-top:60px !important;">
        <div class="container-fluid" style="margin: bottom 20px; ">
            <div class="card-body">

                <div class="table-responsive table mt-2" id="dataTable-1" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0 " id="dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Rollno</th>
                                <th>Package</th>
                                <th>Transactionid</th>
                                <th>Screenshot</th>
                                <th>Fest</th>
                                <th>Status</th>
                                <th>Verification</th>
                                <th>Remove Verification</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verificationData as $fes)
                            @if($fes->fest === $fest)
                            <tr>
                                <td>{{$fes->username}}</td>
                                <td>{{$fes->rollno}}</td>
                                <td>{{$fes->package}}</td>
                                <td>{{$fes->transactionid}}</td>
                                <td><button data-bs-toggle="modal" data-bs-target="#exampleModal{{$fes->id}}"
                                        class="btn btn-block btn-bold btn-primary justify-content-center"
                                        style="margin-right:20px">View</button></td>
                                <td>{{$fes->fest}}</td>
                                <td id="status{{$fes->id}}">{{$fes->status}}</td>
                                <td>
    <form method="post" action="/verifyupdate/{{$fes->fest}}/{{$fes->rollno}}/{{$fes->package}}">
        @csrf
        
        <button id="verifyButton{{$fes->id}}_{{$fes->rollno}}_{{$fes->fest}}" type="submit"
            class="btn btn-block btn-bold btn-primary justify-content-center"
            style="margin-right:20px"
            @if($fes->status !== "pending") disabled @endif>Verify</button>
    </form>
</td>
<td>
    <form method="post" action="/removeupdate/{{$fes->fest}}/{{$fes->rollno}}/{{$fes->package}}">
        @csrf
        <button id="removeButton{{$fes->id}}_{{$fes->rollno}}_{{$fes->fest}}"
            class="btn btn-block btn-bold btn-primary justify-content-center"
            style="margin-right:20px"
            @if($fes->status !== "verified") disabled @endif>Remove Verification</button>
    </form>
</td>

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$fes->id}}" tabindex="-1"
                                aria-labelledby="exampleModalLabel{{$fes->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$fes->id}}">Payment
                                                Screenshot</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Display the image -->
                                            <img src="{{ asset($fes->screenshot) }}" alt="Payment Screenshot"
                                                class="img-fluid">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

   
    <script>
    $(document).ready(function () {
        // Function to fetch status and enable/disable buttons
        function updateButtons() {
            $('[id^=verifyButton]').each(function () {
                var buttonId = $(this).attr('id');
                var statusId = buttonId.replace('verifyButton', 'status');
                var parts = buttonId.split("_");
                var fest = parts[2];
                var rollno = parts[1];
                $.ajax({
                    url: '/getstatus/' + fest + '/' + rollno,
                    type: 'GET',
                    success: function (data) {
                        var status = data.status;
                        $('#' + statusId).text(status);
                        if (status !== "pending") {
                            $('#' + buttonId).prop('disabled', true);
                        } else {
                            $('#' + buttonId).prop('disabled', false);
                        }
                    }
                });
            });

            $('[id^=removeButton]').each(function () {
                var buttonId = $(this).attr('id');
                var statusId = buttonId.replace('removeButton', 'status');
                var parts = buttonId.split("_");
                var fest = parts[2];
                var rollno = parts[1];
                $.ajax({
                    url: '/getstatus/' + fest + '/' + rollno,
                    type: 'GET',
                    success: function (data) {
                        var status = data.status;
                        $('#' + statusId).text(status);
                        if (status !== "verified") {
                            $('#' + buttonId).prop('disabled', true);
                        } else {
                            $('#' + buttonId).prop('disabled', false);
                        }
                    }
                });
            });
        }

        // Call the function initially
        updateButtons();

        // Optionally, refresh buttons periodically (e.g., every 5 seconds)
        setInterval(updateButtons, 5000);
    });
</script>




</body>

</html>
