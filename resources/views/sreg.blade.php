<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Registration</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm").value;

            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</head>


<body class="bg-gradient-primary">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0" style="padding-top:60px">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background-image: url(bootstrap/img/dogs/bg.jpg);"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Create an Account!</h4>
                            </div>
                            <form class="user" action="/stRegister" method="post" onsubmit="return validateForm()"enctype="multipart/form-data">
                                @csrf    <div class="row mb-3">
                                   
                                <div class="mb-3"><label class="labels">Name</label><input class="form-control form-control-user" type="text" id="exampleFirstName" name="name" placeholder="Name" required value="{{ old('name') }}"></div>

                                <div class="mb-3"><label class="labels">College Official Email ID</label><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" name="email" placeholder="Email" value="{{ old('email') }}" required></div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><label class="labels">Password</label><input class="form-control form-control-user" type="password"  id="password" name="password" placeholder="Password" required></div>
                                    <div class="col-sm-6"><label class="labels">Confirm Password</label><input class="form-control form-control-user" type="password" id="confirm"name="confirmpass" placeholder="Confirm Password" required></div>

                                 </div>
                                 <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><label class="labels">University Register Number</label><input class="form-control form-control-user" type="text" id="exampleFirstName" name="regno" placeholder="register number" value="{{ old('regno') }}" required></div>
                                    <div class="col-sm-6"><label class="labels">Department</label><select class="form-select form-select-lg mb-3"style="border-radius:160px" name="department">
                                        <optgroup label="Department">
                                            <option value="">Select Department</option>
        <option value="CSE" {{ old('department') == 'CSE' ? 'selected' : '' }}>CSE</option>
        <option value="ECE" {{ old('department') == 'ECE' ? 'selected' : '' }}>ECE</option>
        <option value="EEE" {{ old('department') == 'EEE' ? 'selected' : '' }}>EEE</option>
        <option value="IT" {{ old('department') == 'IT' ? 'selected' : '' }}>IT</option>
        <option value="MECH" {{ old('department') == 'MECH' ? 'selected' : '' }}>MECH</option>
                                        </optgroup>
                                    </select></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><label class="labels">Mobile Number</label><input class="form-control form-control-user" type="tel" id="exampleFirstName" name="phone" placeholder="number" value="{{ old('phone') }}" required></div>
                                    <div class="col-sm-6"><label class="labels">Current studying Year</label><select class="form-select form-select-lg mb-3"style="border-radius:160px" name="year">
                                        <optgroup label="year">
                                            <option value="">Select Year</option>
        <option value="1st" {{ old('year') == '1st' ? 'selected' : '' }}>1th</option>
        <option value="2nd" {{ old('year') == '2nd' ? 'selected' : '' }}>2nd</option>
        <option value="3rd" {{ old('year') == '3rd' ? 'selected' : '' }}>3rd</option>
        <option value="4th" {{ old('year') == '4th' ? 'selected' : '' }}>4th</option>
                                        </optgroup>
                                    </select></div>
                                    <div class="row mb-3">
                                    <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="mb-3">
        <label class="labels">Profile Image</label>
        <input class="form-control" type="file" name="image" placeholder="Image"/>

    </div></div>
                                    <div class="mb-3"><label class="labels">College Code</label><input class="form-control form-control-user" type="tel" id="exampleFirstName" name="collegecode" placeholder="college code" value="{{ old('collegecode') }}" required></div>
                                </div>
                                    <button class="btn btn-primary d-block btn-user w-100" type="submit">Register Account</button>
                                 <hr>
                            </form>
                            <div class="text-center"><a class="small" href="forgot-password.html">Forgot Password?</a></div>
                            <div class="text-center"><a class="small" href="/SLogin">Already have an account? Login!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if ($errors->any())
    <div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 10px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
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
<script>
    setTimeout(function() {
        document.getElementById('notification').style.display = 'none';
    }, 5000);
</script>
</html>
