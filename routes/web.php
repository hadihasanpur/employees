<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\City\CityIndex;
use App\Http\Livewire\Users\UserIndex;
use App\Http\Livewire\State\StateIndex;
use App\Http\Livewire\Country\CountryIndex;
use App\Http\Livewire\Department\DepartmentIndex;
use App\Http\Livewire\Employee\EmployeeIndex;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::view('/dashboard','dashboard')->name('dashboard'); 
        Route::get('/users',UserIndex::class)->name('users.index'); 
        Route::get('/states',StateIndex::class)->name('state.index');
        Route::get('/cities', CityIndex::class)->name('city.index');
        Route::get('/countries',CountryIndex::class)->name('country.index');
        Route::get('/departments', DepartmentIndex::class)->name('department.index');
        Route::get('/employees', EmployeeIndex::class)->name('employee.index');



});
