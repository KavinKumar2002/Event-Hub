<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
                                   
                                    <th>Remove Events</th>
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
                                    <!-- <td><button type="button" class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-right:20px" data-toggle="modal" data-target="#teamMemberModal_{{ $grp->id }}">Add Event</button></td> -->
                                    <!-- Modal for displaying team members -->
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
                                    <td><button type="button" class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-right:20px" data-toggle="modal" data-target="#removeevent_{{ $grp->id }}">Remove Event</button></td>
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


<!-- First Modal -->
<div class="modal fade" id="teamMemberModal_{{ $grp->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Select Team Members</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="teamMemberForm_{{ $grp->id }}" >
                    @csrf
                    <div class="form-group">
                        <label for="eventNameSelect">Event Name:</label>
                        <select class="form-control" id="eventNameSelect_{{ $grp->id }}" name="Eventname">
                            <!-- Added name attribute -->
                            @foreach($event as $grps)
                            @php
                            $eventName = $grps->name;
                            $registeredEvents = $grp->registered_events;
                            @endphp
                            @if(strpos($registeredEvents, $eventName) === false)
                            <option value="{{ $eventName }}">{{ $eventName }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                <!-- Modal footer content goes here -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="teamMemberForm_{{ $grp->id }}" class="btn btn-primary">Save changes</button>
            </div>
                    <!-- Other form fields can be added here -->
                </form>
            </div>
           
        </div>
    </div>
</div>

<!-- Second Modal -->
<div class="modal fade" id="secondModal_{{ $grp->id }}" tabindex="-1" role="dialog" aria-labelledby="secondModalLabel_{{ $grp->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="secondModalLabel_{{ $grp->id }}">Display Selected Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="secondModalForm_{{ $grp->id }}" action="/storeTeamManager" method="POST">
                    @csrf
                    <!-- Other form fields can be added here -->
                    
                    @php
                    $teamSize=DB::table('fest')->where('fest_name',session('festname'))->value('maxteamsize');
                    $teammx=DB::table('eventdetail')->where('name',$eventName)->value('teamsize');
                    $pay=DB::table('eventdetail')->where('name',$eventName)->value('payment');
                    @endphp

                    <input type="hidden" name="eventname" id="secondModalEventname_{{ $grp->id }}" value="{{ $eventName }}">
                    <input type="hidden" name="team_name" value="{{ $grp->team_name }}">
                    <input type="hidden" name="fest" value="{{ $grp->fest }}">
                    <input type="hidden" name="maxteam" value="{{ $teamSize }}">
                    <input type="hidden" name="teammax" value="{{ $teammx }}">
                    <input type="hidden" name="userreg" value="{{ $grp->userreg }}">
                    <input type="hidden" name="type" value="{{ $grp->type }}">
                    <input type="hidden" name="team_leader_name" value="{{ $grp->team_leader_name }}">
                    <input type="hidden" name="team_leader_regno" value="{{ $grp->team_leader_regno }}">
                    <input type="hidden" name="team_leader_email" value="{{ $grp->team_leader_email }}">
                    <input type="hidden" name="payment" value="{{ $pay }}">
                    <div class="row">
                        <div class="col-md-12">
                            @for ($i = 1; $i <= $teamSize; $i++)
                            @php
                            $memberNameColumn = 'team_member_' . $i;
                            $memberRegnoColumn = 'team_member_' . $i . '_regno'; // Corrected variable name
                            $memberEmailColumn = 'team_member_' . $i . '_email'; // Corrected variable name
                            @endphp
                            @if (!empty($team->$memberNameColumn))
                            <div class="form-check">
                                <input class="form-check-input team-member-checkbox" type="checkbox" id="team_member_{{ $i }}" name="team_members[]" value="{{ $team->$memberNameColumn }}|{{ $team->$memberRegnoColumn }}|{{ $team->$memberEmailColumn }}" />
                                <label class="form-check-label" for="team_member_{{ $i }}">Team Member {{ $i }}: {{ $team->$memberNameColumn }}</label>
                            </div>
                            @endif
                            @endfor
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="secondModalForm_{{ $grp->id }}" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Listen for the first modal to be hidden
        $('[id^=teamMemberModal]').on('hidden.bs.modal', function () {
            var modalId = $(this).attr('id');
            var groupId = modalId.split('_')[1];
            $('#secondModal_' + groupId).modal('show'); // Show the second modal
        });

        // Handle submission of the first modal form
        $('[id^=teamMemberForm]').submit(function(event) {
             // Prevent default form submission
            var form = $(this);
            var modalId = form.closest('.modal').attr('id');

            // Get form data
            var teamName = form.find('input[name="team_name"]').val();
            var fest = form.find('input[name="fest"]').val();
            var eventname = form.find('#secondModalEventname_' + modalId).val(); // Get selected event name
            var maxteam = form.find('input[name="maxteam"]').val();
            var userreg = form.find('input[name="userreg"]').val();
            var type = form.find('input[name="type"]').val();
            var leadername = form.find('input[name="team_leader_name"]').val();
            var leaderreg = form.find('input[name="team_leader_regno"]').val();
            var leaderemail = form.find('input[name="team_leader_email"]').val();
            var selectedMembers = [];

            // Get selected team members
            form.find('input[name="team_members[]"]:checked').each(function() {
                var memberData = $(this).val().split('|');
                selectedMembers.push({
                    name: memberData[0],
                    regno: memberData[1],
                    email: memberData[2]
                });
            });

            // AJAX request to store selected team members
            $.ajax({
                url: '/storeTeamManager',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    team_name: teamName,
                    fest: fest,
                    eventname: eventname,
                    maxteam: maxteam,
                    userreg: userreg,
                    type: type,
                    team_leader_name: leadername,
                    team_leader_regno: leaderreg,
                    team_leader_email: leaderemail,
                    team_members: selectedMembers
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });

        // Add event listener to each checkbox
        $('[id^=teamMemberModal]').on('change', '.team-member-checkbox', function() {
            var modalId = $(this).closest('.modal').attr('id');
            // Get the number of checked checkboxes
            var checkedCount = $('#' + modalId + ' .team-member-checkbox:checked').length;
            // Get the maximum team size from the hidden input field
            var maxTeamSize = parseInt($('#' + modalId + ' input[name="teammax"]').val());
            // Loop through each checkbox and disable it if the maximum team size is reached
            $('#' + modalId + ' .team-member-checkbox').each(function() {
                if (checkedCount >= maxTeamSize && !$(this).prop('checked')) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });
    });
</script>




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
