<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/jobs',[JobsController::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobsController::class,'detail'])->name('jobDetail');
Route::post('/apply-job',[JobsController::class,'applyJob'])->name('applyJob');
Route::post('save-job', [JobsController::class, 'saveJob'])->name('saveJob'); // Only if you want to restrict it to authenticated users


Route::group(['prefix' => 'admin', 'middleware' => 'checkRole'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('admin.users.destory');
    Route::get('/jobs', [JobController::class, 'index'])->name('admin.jobs');
    Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('admin.jobs.update');
    Route::delete('/jobs', [JobController::class, 'destroy'])->name('admin.jobs.destroy');
    Route::get('/job-application', [JobApplicationController::class, 'index'])->name('admin.jobApplications');
    Route::delete('/job-application', [JobApplicationController::class, 'destroy'])->name('admin.jobApplications.destroy');

});


Route::group(['account'], function(){

    // Guest Route
    Route::group(['middlewae' => 'guest'], function(){
        Route::get('/register',[AccountController::class,'registration'])->name('account.registration');
        Route::post('/proces-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/login',[AccountController::class,'login'])->name('account.login');
        Route::post('/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
    });

    // Authenticated Routes -> If user tries to access the profile page or guest routes without login directly then it will redirect user to the login page
    Route::group(['middlewae' => 'auth'], function(){
        Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
        Route::put('/update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::get('/logout',[AccountController::class,'logout'])->name('account.logout'); 
        Route::post('/update-profile-pic',[AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');   
        Route::get('/create-job',[AccountController::class,'createJob'])->name('account.createJob');    
        Route::post('/save-job',[AccountController::class,'saveJob'])->name('account.saveJob');    
        Route::get('/my-jobs',[AccountController::class,'myJobs'])->name('account.myJobs');    
        Route::get('/my-jobs/edit/{jobId}',[AccountController::class,'editJob'])->name('account.editJob');    
        Route::post('/update-job/{jobId}',[AccountController::class,'updateJob'])->name('account.updateJob');    
        Route::post('/delete-job',[AccountController::class,'deleteJob'])->name('account.deleteJob');    
        Route::get('/my-job-applications',[AccountController::class,'myJobApplications'])->name('account.myJobApplications');    

        Route::post('/remove-job-application',[AccountController::class,'removeJobs'])->name('account.removeJobs');    

        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');


    });
});
