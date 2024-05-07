<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>

    @include('sidebar')

    <div class="container-fluid" style="margin-top: 80px;">
    <div class="container-fluid" style="margin-top:20px !important">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row" style="overflow: hidden;">
                    <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                        <p class="text-primary m-0 fw-bold mk">Individual Registration</p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"
                            style="margin-right:20px">
                            <div>
                                <p> <strong><bold>Count:  {{$indcount }}</bold></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-outline mb-4" data-mdb-input-init>
                    <input type="search" placeholder="search" class="form-control" id="datatable-search-input">
                    
                </div>
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Register No</th>
                                <th>Department</th>
                                <th>Registered Event</th>
                                <th>Email</th>
                               
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indreg as $ind)
                            <tr>
                                <td>{{$ind->name}}</td>
                                <td>{{$ind->regno}}</td>
                                <td>{{$ind->dept}}</td>
                               
                                <td>{{$ind->registered_event}}</td>
                                <td>{{$ind->email}}</td>
                              
                                
    
                               

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#datatable-search-input').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                $('#dataTable tbody tr').each(function () {
                    var lineStr = $(this).text().toLowerCase();
                    if (lineStr.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>

</html>
