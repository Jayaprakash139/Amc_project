<?php

use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\Admin\AmcStatusAllocController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::get('/get-email/{userId}', [UsersController::class, 'getEmail'])->name('get-email');
    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // School
    Route::delete('schools/destroy', 'SchoolController@massDestroy')->name('schools.massDestroy');
    Route::post('schools/media', 'SchoolController@storeMedia')->name('schools.storeMedia');
    Route::post('schools/ckmedia', 'SchoolController@storeCKEditorImages')->name('schools.storeCKEditorImages');
    Route::post('schools/parse-csv-import', 'SchoolController@parseCsvImport')->name('schools.parseCsvImport');
    Route::post('schools/process-csv-import', 'SchoolController@processCsvImport')->name('schools.processCsvImport');
    Route::resource('schools', 'SchoolController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoryController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoryController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::post('categories/parse-csv-import', 'CategoryController@parseCsvImport')->name('categories.parseCsvImport');
    Route::post('categories/process-csv-import', 'CategoryController@processCsvImport')->name('categories.processCsvImport');
    Route::resource('categories', 'CategoryController');

    // Location
    Route::delete('locations/destroy', 'LocationController@massDestroy')->name('locations.massDestroy');
    Route::resource('locations', 'LocationController');
    Route::get('/get-location/{userId}', [LocationController::class, 'getLocation'])->name('get-location');
   
    // Status
    Route::delete('statuses/destroy', 'StatusController@massDestroy')->name('statuses.massDestroy');
    Route::post('statuses/parse-csv-import', 'StatusController@parseCsvImport')->name('statuses.parseCsvImport');
    Route::post('statuses/process-csv-import', 'StatusController@processCsvImport')->name('statuses.processCsvImport');
    Route::resource('statuses', 'StatusController');

    // Allocation
    Route::delete('allocations/destroy', 'AllocationController@massDestroy')->name('allocations.massDestroy');
    Route::post('allocations/media', 'AllocationController@storeMedia')->name('allocations.storeMedia');
    Route::post('allocations/ckmedia', 'AllocationController@storeCKEditorImages')->name('allocations.storeCKEditorImages');
    Route::post('allocations/parse-csv-import', 'AllocationController@parseCsvImport')->name('allocations.parseCsvImport');
    Route::post('allocations/process-csv-import', 'AllocationController@processCsvImport')->name('allocations.processCsvImport');
    Route::resource('allocations', 'AllocationController');

    // Department
    Route::delete('departments/destroy', 'DepartmentController@massDestroy')->name('departments.massDestroy');
    Route::post('departments/parse-csv-import', 'DepartmentController@parseCsvImport')->name('departments.parseCsvImport');
    Route::post('departments/process-csv-import', 'DepartmentController@processCsvImport')->name('departments.processCsvImport');
    Route::resource('departments', 'DepartmentController');


      // Amc Status
    Route::delete('amc-statuses/destroy', 'AmcStatusController@massDestroy')->name('amc-statuses.massDestroy');
    Route::post('amc-statuses/parse-csv-import', 'AmcStatusController@parseCsvImport')->name('amc-statuses.parseCsvImport');
    Route::post('amc-statuses/process-csv-import', 'AmcStatusController@processCsvImport')->name('amc-statuses.processCsvImport');
    Route::resource('amc-statuses', 'AmcStatusController');

    Route::put('allocations/{allocation}/amc-status', [AllocationController::class, 'updateAmcStatus'])->name('allocations.updateAmcStatus');

    Route::get('get-asset-details', [AmcStatusAllocController::class, 'getAssetDetails'])->name('get-asset-details');

    Route::delete('amc-image-gallery/{id}', [AmcStatusAllocController::class, 'deleteGalleryImage'])
    ->name('multi-image.destroy');


      Route::get('ams_status_dash', [AmcStatusAllocController::class, 'amsStatusDash'])
    ->name('ams_status_dash.index');


    Route::get('/get-sublocations/{location}', [AllocationController::class, 'getSublocations']);


      // Amc Status Alloc
    Route::delete('amc-status-allocs/destroy', 'AmcStatusAllocController@massDestroy')->name('amc-status-allocs.massDestroy');
    Route::post('amc-status-allocs/parse-csv-import', 'AmcStatusAllocController@parseCsvImport')->name('amc-status-allocs.parseCsvImport');
    Route::post('amc-status-allocs/process-csv-import', 'AmcStatusAllocController@processCsvImport')->name('amc-status-allocs.processCsvImport');
    Route::resource('amc-status-allocs', 'AmcStatusAllocController');


    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeeController@storeMedia')->name('employees.storeMedia');
    Route::post('employees/ckmedia', 'EmployeeController@storeCKEditorImages')->name('employees.storeCKEditorImages');
    Route::post('employees/parse-csv-import', 'EmployeeController@parseCsvImport')->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', 'EmployeeController@processCsvImport')->name('employees.processCsvImport');
    Route::resource('employees', 'EmployeeController');

    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');


    // new routes
    
      Route::get('AllocationQRCodeReport','ReportController@assetAllotQRCodeReport')->name('reports.QRCodeAllocationReport');
    
      Route::post('qr-report/download', [ReportController::class, 'downloadQRCodePdf'])->name('qr-report.download');

     Route::post('AllocationQRCodeReport', [ReportController::class, 'filterQRcodes'])->name('allocationQRCode.filter');

    // new routes

    Route::get('AllocationReport','ReportController@assetAllotReport')->name('reports.AllocationReport');
    Route::resource('reports', 'ReportController');
    Route::post('AllocationReport', [ReportController::class, 'filter'])->name('allocation.filter');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // School
    Route::delete('schools/destroy', 'SchoolController@massDestroy')->name('schools.massDestroy');
    Route::post('schools/media', 'SchoolController@storeMedia')->name('schools.storeMedia');
    Route::post('schools/ckmedia', 'SchoolController@storeCKEditorImages')->name('schools.storeCKEditorImages');
    Route::resource('schools', 'SchoolController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoryController@storeMedia')->name('categories.storeMedia');
    Route::post('categories/ckmedia', 'CategoryController@storeCKEditorImages')->name('categories.storeCKEditorImages');
    Route::resource('categories', 'CategoryController');

    // Location
    Route::delete('locations/destroy', 'LocationController@massDestroy')->name('locations.massDestroy');
    Route::resource('locations', 'LocationController');
    Route::get('/get-location/{userId}', [LocationController::class, 'getLocation'])->name('get-location');
   
    // Status
    Route::delete('statuses/destroy', 'StatusController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusController');

    // Allocation
    Route::delete('allocations/destroy', 'AllocationController@massDestroy')->name('allocations.massDestroy');
    Route::post('allocations/media', 'AllocationController@storeMedia')->name('allocations.storeMedia');
    Route::post('allocations/ckmedia', 'AllocationController@storeCKEditorImages')->name('allocations.storeCKEditorImages');
    Route::resource('allocations', 'AllocationController');

    // Department
    Route::delete('departments/destroy', 'DepartmentController@massDestroy')->name('departments.massDestroy');
    Route::resource('departments', 'DepartmentController');

    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeeController@storeMedia')->name('employees.storeMedia');
    Route::post('employees/ckmedia', 'EmployeeController@storeCKEditorImages')->name('employees.storeCKEditorImages');
    Route::resource('employees', 'EmployeeController');

    Route::get('AllocationsReport','ReportController@assetAllotReport')->name('reports.AllocationsReport');
    Route::resource('reports', 'ReportController');
    Route::post('AllocationsReport', 'ReportController@filtered')->name('allocations.filtered');


    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
