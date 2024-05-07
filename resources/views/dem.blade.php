<!-- Button trigger modal -->
@php
    // Retrieve existing data from the table
    $existingData = DB::table('grpreg')
        ->where('userreg', session('regno'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#grpreg" {{ disabled }}>
  Group Registration
</button>

<!-- Modal -->
<div class="modal fade" id="grpreg" tabindex="-1" role="dialog" aria-labelledby="grpregTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="grpregTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form  action="/groupregistration" method="POST">
                            @csrf
                            @php
$team=DB::table('teams')
->where('userreg',session('regno'))
->get();
                            @endphp
                           <p>Are you sure do you want to register for this event</p>
                            @foreach($team as $tea)
                            <input type="hidden" name="team_name" value="{{ $tea->team_name }}">
    <input type="hidden" name="team_leader_name" value="{{ $tea->team_leader_name }}">
    <input type="hidden" name="team_leader_email" value="{{ $tea->team_leader_email }}">
    <input type="hidden" name="team_leader_regno" value="{{ $tea->team_leader_regno }}">
    <input type="hidden" name="college_name" value="{{ $tea->college_name }}">
    <input type="hidden" name="mobile_no" value="{{ $tea->mobile_no }}">
    <input type="hidden" name="team_member_1" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_1_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_2" value="{{ $tea->team_member_2 }}">
    <input type="hidden" name="team_member_2_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_3" value="{{ $tea->team_member_3 }}">
    <input type="hidden" name="team_member_3_regno" value="{{ $tea->team_member_1 }}">
    
    @foreach($all as $events)
    <input type="hidden" name="type" value="{{$events->type}}">
                        <input type="hidden" name="eventname" value="{{ $events->name }}">
                        <input type="hidden" name="fest" value="{{ $events->fest }}">
                        @endforeach
                        <input type="hidden" name="userreg" value="{{ session('regno') }}">
                        
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('grpreg')
        ->where('userreg', session('regno'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Yes</button>
      </div>
    
    @endforeach                       
</form>
      </div>
    
    </div>
  </div>
</div>