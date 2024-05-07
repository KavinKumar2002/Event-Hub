<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">

    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>

</head>

<body>
    @include('stud')
    <div class="page-content page-container mt-20" id="page-content" style="margin-top:70px">
    <div class="padding">
        <div class="row justify-content-center"> <!-- Center-aligning the row -->
            <div class="col-md-6 col-lg-4 w-75 h-50 mt-20">
                <form class="card" action="/fest/StudentPost" method="post">
                    @csrf
                    <h5 class="h3 mb-0 text-gray-800" style="margin:30px !important">Student Details</h5>
                    <div class="card-body mb-30 h-70" style="margin-bottom:20px;">
                        <div class="form-group h-40" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-md-12" id="col-md-12">
                                <label class="labels">Details Name</label>
                                <input class="form-control" name="data[]" type="text" placeholder="Enter the data should be get" required>
                                <input type="hidden" name="fest" value="{{$fest}}" placeholder="data">
                            </div>
                        </div>
                        <button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;">Submit</button>
                        <a class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;" id="addButton">Add</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    @if ($errors->any())
    <div id="notification"
        style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div>
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if(session('success'))

    <div id="notification"
        style="width: 300px; height: auto; background-color: #1cc88a; color: black; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
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
    @if(session('error1'))

    <div id="notification"
        style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 10px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div>
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                {{ session('error1') }}
            </ul>
        </div>
    </div>
    @endif

    <script>
        document.getElementById("addButton").addEventListener("click", function () {
            var inputFieldsContainer = document.getElementById("col-md-12");
            var inputField = document.createElement("input");
            inputField.type = "text";
            inputField.name = "data[]";
            inputField.className = "form-control mt-3";
            inputFieldsContainer.appendChild(inputField);
            inputField.placeholder = "Enter the data should be get";
        });
    </script>



    <script>
        setTimeout(function () {
            document.getElementById('notification').style.display = 'none';
        }, 2000); 
    </script>
</body>

</html>