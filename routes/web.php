<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

use App\Http\Controllers\studentcontroller;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|ph
*/

Route::view('/welcome','welcome');
Route::get('/', function () {
    if (session('name1')) {
        echo '<script>window.location.href = "/AssignedFest";</script>';
    } else {
        echo '<script>window.location.href = "/welcome";</script>';}
});
Route::view('/SLogin','slogin');
Route::post('slogged',[studentcontroller::class,'login']);
Route::view('/SRegister','sreg');
Route::post('stRegister',[studentcontroller::class,'register']);
Route::get('sprofile',[studentcontroller::class,'profile']);
Route::get('/sDashboard',[studentcontroller::class,'sDashboard']);
Route::get('sReg/{regno}',[studentcontroller::class,'sReg']);
Route::get('/UserRegister', function () {
    if (session('name1')) {
        return redirect('AssignedFest');
    } else {
        return view('userRegister');
    }
});
Route::get('/UserLogin', function () {
    if (session('name1')) {
        echo '<script>window.location.href = "/AssignedFest";</script>';
    } else {
        return view('userLogin');
    }
});
Route::get('/Logout',function(){
    Session::pull('role');
    Session::pull('collegecode');
    Session::pull('name1');
    return redirect('UserLogin');
});
Route::view('sidebar','sidebar');
Route::post('/URegister',[AuthController::class,'UserRegister']);
Route::post('/ULogin',[AuthController::class,'UserLogin']);
Route::get('/Dashboard', function () {
    if (session('name1')) {
        $eventController = new EventController();
        return $eventController->dashboard();
    } else {
        return view('userLogin');
    }
});



Route::view('/Sidebar','sidebar');
Route::get('/CompletedFest',[EventController::class,'completed']);

Route::get('CreateFest', function() {
    $role = session('role');

if ($role == 'Admin') {
    
    return view('createFest');
} else {
    return view('401');
}

});
Route::view('/ssidebar','studbar');
Route::get('/slogout', function(){
    Session::pull('email');
    Session::pull('collegecode');
    Session::pull('department');
    Session::pull('regno');
    Session::pull('name');
  
    return view('SLogin');
});

Route::post('AssignFest',[EventController::class,'Assign']);
Route::get('/AssignedFest',[EventController::class,'Assigned']);
Route::get('/Edit/Event/{fest}/{name}', [EventController::class, 'EditEvent']);
Route::get('/Delete/Event/{fest}/{id}/{name}',[EventController::class,'DeleteEvent']);
Route::get('/View/{fest}',[EventController::class,'Viewfest']);
Route::get('/duplicateView/{fest}',[EventController::class,'duplicateViewfest']);
Route::get('/fest/Event/{fest}',[EventController::class,'Festdata']);
Route::get('/certificate/{fest}', [EventController::class, 'download'])->name('certificate.download');

Route::post('/events',[EventController::class,'events']);
Route::post('/eventsedit',[EventController::class,'EventsEdit']);
Route::get('/fest/StudentGet/{fest}',[EventController::class,'StudentFest']);
Route::post('/fest/StudentPost',[EventController::class,'StudentFestPost']);
Route::get('/Mark/{fest}/{event}',[EventController::class,'Allocate']);
Route::view('404','404');
Route::get('/Result/Event/{fest}/{name}',[EventController::class,'result']);
Route::post('/allocatemarks',[EventController::class,'allocatemarks']);
Route::get('/complete/{fest}',[studentcontroller::class,'festcomplete']);

//student side
Route::get('/sfest/details/{fest}/{department}',[studentcontroller::class,'festdetails']);
Route::get('/eventregister/{fest}/{department}',[studentcontroller::class,'geteventregister']);
Route::post('/registrations',[studentcontroller::class,'registrations']);
Route::get('/indreg/{fest}/{name}',[studentcontroller::class,'indreg']);
Route::post('/individualregistration',[studentcontroller::class,'individualregistration']);
Route::get('/grpreg/{fest}/{name}',[studentcontroller::class,'grpreg']);
Route::post('/group',[studentcontroller::class,'teams']);
Route::post('/teamupdate',[studentcontroller::class,'teamsupdate']);
Route::post('/groupregistration',[studentcontroller::class,'groupregistration']);
Route::get('/checkmarks',[EventController::class,'checkmarks'] );

Route::post('/generateCertificate',[EventController::class,'generateCertificate']);
Route::get('/plans/{fest}',[studentController::class,'plans']);
Route::post('/payverify/{fest}',[studentController::class,'pay']);
Route::get('/verify/{fest}', function($fest) {
    $role = session('role');

    if ($role == 'Admin') {
        $eventController = new App\Http\Controllers\EventController();
        return $eventController->verify($fest);
    } else {
        return view('401');
    }
});


Route::post('/verifyupdate/{fest}/{regno}/{package}',[EventController::class,'verifyupdate']);
Route::get('/indsearch',[EventController::class,'indsearch']);
Route::get('/duplicateindsearch',[EventController::class,'duplicateindsearch']);
Route::get('/teamsearch',[EventController::class,'teamsearch']);
Route::get('/duplicateteamsearch',[EventController::class,'duplicateteamsearch']);
Route::get('/viewfull',[EventController::class,'viewfull']);
Route::get('/duplicateviewfull',[EventController::class,'duplicateviewfull']);
Route::post('/addexieve',[EventController::class,'addexieve']);
Route::post('/removeexieve',[EventController::class,'removeexieve']);
Route::post('/addexiteameve',[EventController::class,'addexiteameve']);
Route::post('/removeexiteameve',[EventController::class,'removeexiteameve']);

Route::post('/removeupdate/{fest}/{regno}/{package}',[EventController::class,'removeupdate']);
Route::get('/getstatus/{fest}/{rollno}', [EventController::class,'getStatus']);
Route::get('/checkRegistrationStatus', [EventController::class, 'checkRegistrationStatus']);
Route::post('storeTeamManager',[studentController::class,'storeTeamManager']);
Route::post('/check-status', [studentController::class, 'checkStatus']);
Route::post('/getTeamSize', [EventController::class, 'getTeamSize']);

// Route for storing team details
Route::post('/check-team-name', [studentController::class, 'checkTeamName'])->name('check.team.name');

// Route for updating team details
Route::post('/check-registration-number', [studentControllers::class, 'checkRegistrationNumber'])->name('check.registration.number');
Route::post('/fest/getTableValue', [studentController::class, 'getTableValue'])->name('getTableValue');
