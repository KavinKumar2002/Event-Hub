<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Goup</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
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

<div class="container-fluid" style="margin-top: 80px;">
    <div class="container-fluid" style="margin: bottom 20px; ">
        <div class="container-fluid" style="margin-top:20px !important">
            <div class="card shadow">
                <div class="card-header py-3">
                    <div class="row" style="overflow: hidden;">
                        <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                            <p class="text-primary m-0 fw-bold mk">Group Registration</p>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end dataTables_filter" id="dataTable_filter" style="margin-right:20px">
                                <div>
                                    <p> <strong>Count: {{$grpcount }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-outline mb-4" data-mdb-input-init>
                        <input type="search" placeholder="search" class="form-control" id="datatable-search-input">
                    </div>
                    <div class="table-responsive table mt-2" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
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
                                @foreach($grpreg as $grp)
                                @if($grp->fest === $fest)
                                <tr>
                                    <td data-bs-toggle="modal" data-bs-target="#exampleModal{{$grp->id}}" style="cursor:pointer;">
                                        {{$grp->team_name}}<img width="15px" height="15px" src="{{ asset('/img/about.png') }}" alt="Delete">
                                    </td>
                                    <td>{{$grp->team_leader_name}}</td>
                                    <td>{{$grp->college_name}}</td>
                                    <td>{{$grp->mobile_no}}</td>
                                    <td>{{$grp->registered_events}}</td>
                                    
                                    <div class="modal fade" id="exampleModal{{$grp->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$grp->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel{{$grp->id}}">Team Members</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
    <ul>
        @if($grp->fest === $fest && $grp->team_name === $grp->team_name)
            @foreach ($teamMemberDetails as $team)
                @if ($team->team_name === $grp->team_name)
                    @for($i = 1; $i <= $maxTeamSize-1; $i++)
                        @php $columnName = "team_member_$i"; @endphp
                        @if (!is_null($team->$columnName))
                            <li>Team Member {{ $i }}: {{ $team->$columnName }}</li>
                    
                        @endif
                    @endfor
                @endif
            @endforeach
        @endif
    </ul>
</div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                                <!--modal-->
                                <div class="modal fade" id="removeevent_{{ $grp->id }}" tabindex="-1" role="dialog" aria-labelledby="addeventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addeventLabel">Select Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="/removeexiteameve">
            @csrf
      
          <div class="form-group mb-3">
            <label for="eventname">Event Name</label>
            <select class="form-control" name="eventname" id="eventname" required>
              <option value="">Select Event</option>

              @foreach($event as $grps)
    @php
        $eventName = $grps->name;
        $registeredEvents = $grp->registered_events;
    @endphp
    @if(strpos($registeredEvents, $eventName) !== false)
        <option value="{{ $eventName }}">{{ $eventName }}</option>
    @endif
@endforeach



            </select>
          </div>
        
          <input name="userreg" value="{{ $grp->userreg }}" hidden>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="nextButton">Delete</button>
      </div>
      </form>
   
    </div>
  </div>
</div>

<!-- demo -->







                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>









    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

</body>

</html>
