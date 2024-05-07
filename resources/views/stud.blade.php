<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="/">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                <div class="sidebar-brand-text mx-3"><span>EventHub</span></div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                  
                    <li class="nav-item"><a class="nav-link" href="/sDashboard"><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="/sReg/{{session('regno')}}"><span>Registered</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="/sprofile"><span>Profile</span></a></li>
                    <li class="nav-item"> <div class="text-center d-none d-md-inline nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        style="cursor:pointer;">
                        <button class="btn rounded-circle border-0" id="sidebarToggle" type="button">Logout</button>
                    </div></li>
                </ul>
            </div>
        </div>
    </nav>

    <header>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to Logout</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="/slogout"><button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Yes</button></a>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>



