<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Fest</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <style>
        body {
            margin-top: 150px;
        }

        .card-containers {
            width: 310px;
            margin: 100px;
            height: auto;
        }

        .carsd-left {
            display: inline;
            float: left;
            width: 310px;
            height: auto;
            margin: 20px;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 2px;
        }

        .card img {
            display: inline;
            float: left;
            height: auto;
            width: 300px;
        }

        .content-right {
            width: 70%;
        }

        .contentsscontentss {
            display: flex;
            position: relative;
            padding: 10px;
            text-align: center;
            background-color: #1b4aef;
            width: fit-content;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            font-weight: 700;
            margin-top: 20px;
        }

        .card-title {
            font-size: 25px;
            color: #223342;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 20px;
        }

        .contentss {
            font-size: 20px;
            color: #223342;
            font-weight: 400;
        }
    </style>
</head>
<body>
    @include('sidebar')
    
    <div class="card-containers">
        @foreach($completed as $comp)
        <div class="carsd-left">
            <div class="card" style="width: 100%;">
                <img src="{{ asset($comp->image) }}" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">{{ $comp->fest_name }}</h5>
                   
                    <a href="/duplicateView/{{$comp->fest_name}}" class="btn btn-primary btn-sm">Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
