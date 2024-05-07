<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>view</title>
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

    <div class="page-content page-container mt-20" id="page-content" style="margin-top:60px !important;">
        <div class="container-fluid" style="margin: bottom 20px; ">   
    <div class="container-fluid" style="margin-top:20px !important">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row" style="overflow: hidden;">
                    <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                        <p class="text-primary m-0 fw-bold mk">Group Registration</p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"
                            style="margin-right:20px">
                            <div>
                                <p> <strong><bold>Count:  {{$eventcount }}</bold></strong></p>
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
                                    <th>Event Name</th>
                                    <th>Category</th>
                                    <th>Payment Type</th>
                                    <th>Mark</th>
                                 

                                </tr>
                            </thead>
                            <tbody>
                           
                                @foreach($event as $events)
                                
                              
                                <tr>
                                    <td data-bs-toggle="modal" data-bs-target="#exampleModal{{$events->name}}"
                                        style="cursor:pointer;">{{$events->name}}<img width="15px" height="15px"
                                            src="{{ asset('/img/about.png') }}" alt="Delete"></td>
                                    <td>{{$events->event_id}}</td>
                                    @if($events->payment == "Paid")
                                    <td>Paid</td>
                                    @else
                                    <td>Free</td>
                                    @endif
                                    <td><a
                                            href="/Result/Event/{{$events->fest}}/{{$events->name}}"><img
                                                width="20px" height="20px"
                                                src="{{ asset('/img/results.png') }}" alt="Edit"></a></td>
                                  
                                </tr>
                               

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$events->name}}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{$events->name}}
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                          
                                           
                                                <p>Payment : {{$events->payment}}</p>
                                                <hr>
                                                
                                                <p>Participant Type: {!! $events->type !!}</p>
                                                <hr>
                                                <p>Event Type: {!! $events->eventtype !!}</p>
                                                <hr>
                                                <p>Department: {!! $events->department !!}</p>
                                                <hr>
                                                <p>Details: {!! $events->details !!}</p>
                                                <hr>
                                                <p>Rules:{!! $events->rules !!}</p>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>

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

</body>

</html>
