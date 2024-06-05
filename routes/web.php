<?php

use App\Http\Controllers\AgendaInstructor;
use App\Http\Controllers\AgendainstructorController;
use App\Http\Controllers\BuypackageController;
use App\Http\Controllers\InstructeursController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacancyOverviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\InstructorCheck;

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

Route::get('/', function () {
    return view('welcome');
});




// Route::resource('/instructeurs', InstructeursController::class)->name('', 'instructeurs');
//Route::get('/instructeurs', 'InstructeursController')->name('instructeurs');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //  Route::resource('/instructeurs', InstructeursController::class);
    //  Route::resource('/packages', PackagesController::class);
    //  Route::get('/agendainstructor', [AgendainstructorController::class, 'index'])->name('agendainstructor');
     Route::get('/Buy-Package', [BuypackageController::class, 'index'])->name('Buy-Package');
     Route::post('selectedPackage',[BuypackageController::class, 'selectedPackage'])->name('selectedPackage');
     Route::get('/my-packages', [BuypackageController::class, 'myPackages'])->name('my-packages');
     Route::get('/vacancy-overview', [VacancyOverviewController::class, 'userPackages'])->name('my-vacancy-overview');

    //  Route::get('/agenda-overview', [AgendainstructorController::class, 'overview'])->name('agenda.overview');

    // Route::get('/cancel-lesson/{date}', [AgendaInstructor::class, 'cancelLesson'])->name('agenda.overview');
   // Route::get('/cancel-lesson/{date}', [StudentsController::class, 'cancelLessonStudent'])->name('agendaview');

    // Route::post('/agendainstructor', [AgendainstructorController::class,'createPlan'])->name('agenda.instructor');
    // Route::delete('/cancel-lesson/{date}', [AgendaInstructor::class, 'cancelLesson'])->name('cancel.lesson');

    Route::get('/agenda', [StudentsController::class, 'showAgendaView'])->name('agendaview');
    Route::post('/agenda', [StudentsController::class, 'createPlanStudent'])->name('agenda.student');
    Route::get('/cancel-lessonStudent/{date}', [StudentsController::class, 'cancelLessonStudent'])->name('cancel.lessonStudent');
    Route::delete('/cancel-lessonStudent/{date}', [StudentsController::class, 'cancelLessonStudent'])->name('cancel.lessonStudent');





});


Route::group(['middleware' => AdminCheck::class], function () {
    Route::resource('/instructeurs', InstructeursController::class);
    Route::resource('/packages', PackagesController::class);
    Route::resource('/instructeurs', InstructeursController::class)->name('', 'instructeurs');


});

Route::group(['middleware' => InstructorCheck::class], function () {
    Route::get('/agendainstructor', [AgendainstructorController::class, 'index'])->name('agendainstructor');

    Route::get('/agenda-overview', [AgendainstructorController::class, 'overview'])->name('agenda.overview');

    Route::get('/cancel-lesson/{date}', [AgendaInstructor::class, 'cancelLesson'])->name('agenda.overview');

    Route::post('/agendainstructor', [AgendainstructorController::class,'createPlan'])->name('agenda.instructor');
    Route::delete('/cancel-lesson/{date}', [AgendaInstructor::class, 'cancelLesson'])->name('cancel.lesson');

});

require __DIR__.'/auth.php';
