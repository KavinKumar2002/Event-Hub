<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registered</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <style>
        body {
            margin-top: 70px;
        }
        .register {

            display: flex;
            align-items: center;
            justify-content: center;
            float: right;
            border-radius: 30px 8px 30px 30px;
            background-color: rgb(0, 96, 99);
            box-shadow: none;
            color: rgb(255, 255, 255);
            z-index: 2147483647;
            cursor: pointer;
            top: 70px;
            right: 20px;
            position: fixed;
            padding: 8px;
            margin-right: 20px;
            transition: all 0.1s ease-out 0s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .cards-1 {
            padding-top: 3.25rem;
            padding-bottom: 3rem;
            text-align: center;
        }
        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
            .h2-heading {
                width: 90%;
                margin-right: auto;
                margin-left: auto;
            }
        }
        h2 {
            color: #333;
            font: 700 2rem / 2.625rem "Open Sans", sans-serif;
            letter-spacing: -0.2px;
        }
        .card {
            display: inline-block;
            width: 17rem;
            max-width: 100%;
            margin-right: 1rem;
            margin-left: 1rem;
            vertical-align: top;
            max-width: 21rem;
            margin-right: auto;
            margin-bottom: 3.5rem;
            margin-left: auto;
            padding: 0;
            border: none;
        }
    </style>
</head>
<body>

@include('stud')


@include('stud')


<div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading" style="font-size:20px;font-weight:bold;">Events</div>
                <h2 class="h2-heading">Individual Events</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Loop through each registered event and display corresponding event details -->
                @foreach($det as $detEvent)
                    @if(strpos($detEvent->registered_event, ',') !== false)
                        @foreach(explode(',', $detEvent->registered_event) as $registeredEvent)
                            @foreach($event as $eventDetail)
                                @if($registeredEvent == $eventDetail->name)
                                    <div class="card">
                                        <div class="card-image">
                                            <img class="img-fluid" src="{{ asset($eventDetail->image) }}" alt="alternative">
                                        </div>
                                        <div class="card-body">
                                            <a class="btn btn-primary" disabled>Registered</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        @foreach($event as $eventDetail)
                            @if($detEvent->registered_event == $eventDetail->name)
                                <div class="card">
                                    <div class="card-image">
                                        <img class="img-fluid" src="{{ asset($eventDetail->image) }}" alt="alternative">
                                    </div>
                                    <div class="card-body">
                                        <a class="btn btn-primary" disabled>Registered</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading" style="font-size:20px;font-weight:bold;">Events</div>
                <h2 class="h2-heading"> Group Events</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Loop through each registered event and display corresponding event details -->
                @foreach($teamMemberData as $datas)
                  
                        @foreach($event as $eventDetail)
                            @if($datas->event == $eventDetail->name)
                                <div class="card">
                                    <div class="card-image">
                                        <img class="img-fluid" src="{{ asset($eventDetail->image) }}" alt="alternative">
                                    </div>
                                    <div class="card-body">
                                        <a class="btn btn-primary" disabled>Registered</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    
                @endforeach
            </div>
        </div>
    </div>
</div>



</body>
</html>
