<?php

use App\Http\Controllers\Admin\QuizRecapController;
use App\Http\Controllers\User\QuizWorkController;
use App\Livewire\User\{
  Home,
  Login,
  Profile,
  Quiz,
  QuizHistory,
};

use Illuminate\Support\Facades\Route;

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

Route::get('login', Login\Index::class)->name('login')->middleware(['studentguest']);
Route::middleware(['student'])->group(function () {
  Route::get('/', Home\Index::class)->name('home');
  Route::get('profile', Profile\Index::class)->name('profile');
  Route::prefix('quiz')->name('quiz.')->group(function () {
    Route::get('', Quiz\Index::class)->name('index');
    Route::get('history', QuizHistory\Index::class)->name('history');
    Route::get('done', Quiz\Done::class)->name('done');
    Route::get('{quiz}', Quiz\Show::class)->name('show');
    Route::get('{quiz}/work', Quiz\Work::class)->name('work');
  });
});
Route::get('admin/quiz/{quiz}/print', [QuizRecapController::class, 'print'])->name('admin.quiz.recap');
Route::post('student/online', [QuizWorkController::class, 'updateOnlineStatus'])->name('student.online');
