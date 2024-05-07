<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>view fest</title>
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
    </style>
</head>

<body>

    @include('sidebar')
@php
DB::table('regevent')->where('registered_event', '=', '')->delete();
DB::table('grpreg')->where('registered_event', '=', '')->delete();
@endphp
    <div class="page-content page-container mt-20" id="page-content" style="margin-top:60px !important;">
        <div class="container-fluid" style="margin: bottom 20px; ">

            <div class="card shadow">
                <div class="card-header py-3">
                    <div class="row" style="overflow: hidden;">
                        <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                            <p class="text-primary m-0 fw-bold">Events</p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end dataTables_filter" id="dataTable_filter"
                                style="margin-right:20px">
                                <div><a href="/viewfull"><button
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px">Search</button></a> 
                            
                                <a href="/fest/Event/{{$fest}}"><button
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px">Add Events</button></a> {{$eventcount }}</div>
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
                                    <th>Event Name</th>
                                    <th>Category</th>
                                    <th>Payment Type</th>
                                    <th>Mark</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            @php $count = 0; @endphp 
                                @foreach($event as $events)
                                
                                @if($count < 5)
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
                                    <td><a href="/Mark/{{$events->fest}}/{{$events->name}}"><img width="20px"
                                                height="20px" src="{{ asset('/img/assign.png') }}" alt="assign"></a><a
                                            href="/Result/Event/{{$events->fest}}/{{$events->name}}"><img
                                                width="20px" height="20px"
                                                src="{{ asset('/img/results.png') }}" alt="Edit"></a></td>
                                    <td><a href="/Edit/Event/{{$events->fest}}/{{$events->name}}"><img width="20px"
                                                height="20px" src="{{ asset('/img/Edit.png') }}" alt="Edit"></a><a
                                            href="/Delete/Event/{{$events->fest}}/{{$events->id}}/{{$events->name}}"><img
                                                width="20px" height="20px"
                                                src="{{ asset('/img/delete.png') }}" alt="Delete"></a></td>
                                </tr>
                                @php $count++; @endphp <!-- Increment the counter -->
                @else
                    @break <!-- Exit the loop once 5 rows are displayed -->
                @endif

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

        <div class="container-fluid" style="margin-top:20px !important">

            <div class="card shadow">
                <div class="card-header py-3">

                    <div class="row" style="overflow: hidden;">
                        <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                            <p class="text-primary m-0 fw-bold mk">Student Individual Registration</p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end dataTables_filter" id="dataTable_filter"
                                style="margin-right:20px">

                               
                    
                                <div>
                           
                          
                                    
                                

                          
                                <a href="/indsearch"><button
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px">Search</button></a> {{$indcount }}</div>
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
                                    <th>Type</th>
                                    <th>Department</th>
                                    <th>Event Department</th>
                                    <th>Registered Event</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $count1 = 0; @endphp 
                                @foreach($indreg as $ind)
                                @if($ind->fest === $fest)
                                @if($count1 < 5)
                                <tr>

                                    <td>{{$ind->name}}</td>
                                    <td>{{$ind->type}}</td>
                                    <td>{{$ind->dept}}</td>
                                    <td>{{$ind->eventdept}}</td>
                                    <td>{{$ind->registered_event}}</td>
                                </tr>

                                @php $count1++; @endphp <!-- Increment the counter -->
                @else
                    @break <!-- Exit the loop once 5 rows are displayed -->
                @endif
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid" style="margin-top:20px !important">

            <div class="card shadow">
                <div class="card-header py-3">

                    <div class="row" style="overflow: hidden;">
                        <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                            <p class="text-primary m-0 fw-bold mk">Team Registration</p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end dataTables_filter" id="dataTable_filter"
                                style="margin-right:20px">
                                
                            <div>
                
                            
                                <a href="/teamsearch"><button
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px">Search</button></a> {{$grpcount }}</div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="card-body">

                    <div class="table-responsive table mt-2" id="dataTable-1" role="grid"
                        aria-describedby="dataTable_info">
                        <table class="table my-0 " id="dataTable">
                            <thead>
                                <tr>
                                    
                                    <th>Team Name</th>
                                    <th>Leader Name</th>
                                    <th>College Name</th>
                                    <th>Mobile No.</th>
                                  <th>Registered Events</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php $count2 = 0; @endphp
                                @foreach($grpreg as $grp)
                                @if($grp->fest === $fest)
                                @if($count2 < 5)
                                <tr>
                                <td data-bs-toggle="modal" data-bs-target="#exampleModal0"
                                        style="cursor:pointer;">{{$grp->team_name}}<img width="15px" height="15px"
                                            src="{{ asset('/img/about.png') }}" alt="Delete"></td>
                                
                                   
                                    <td>{{$grp->team_leader_name}}</td>
                                    <td>{{$grp->college_name}}</td>
                                    <td>{{$grp->mobile_no}}</td>

                                    <td>{{$grp->registered_events}}</td>

                                </tr>
                                @php $count2++; @endphp <!-- Increment the counter -->
                @else
                    @break <!-- Exit the loop once 5 rows are displayed -->
                @endif

   
   

                <!-- Modal -->
                <div class="modal fade" id="exampleModal0" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Team Members</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <ul>
                @for($i = 1; $i <= $maxTeamSize; $i++)
    @foreach ($teamMemberDetails as $columnName => $member)
        @if ($columnName === "team_member_$i" && !is_null($member))
           <p>Team Member {{ $i }}: {{ $member }}</p>
        @endif
    @endforeach
@endfor


                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
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
