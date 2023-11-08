<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentAgreementController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormViewController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RoleController;
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

Route::get('/', function () {
    return view('auth.signup');
});

Route::get('/errors/401', function () {
    return view("errors.401");
})->name('errors.401');

Route::get('/som', function () {
    return view("test");
});

Route::get('/profile', function () {
    return view("profile");
})->name('profile');

Route::get('/dashboard', function () {
    return view("dashboard");
})->name('dashboard');

Route::middleware(['web'])->group(function () {
    // Vos routes API ici
});

//Controllers endpoints
Route::get('/auth/register', [AuthController::class, "register"])->name('auth.register');

Route::post('/auth/handle/register', [AuthController::class, "handleregister"])->name('auth.handle.register');

Route::get('/auth/login', [AuthController::class, "login"])->name('auth.login');

Route::post('/auth/handle/login', [AuthController::class, "handlelogin"])->name('auth.handle.login');


//PersonController


Route::get('/user/create', [PersonController::class, "create"])->name('user.create');

Route::post('/person/search', [PersonController::class, "search"])->name('person.search');

Route::post('/user/create', [PersonController::class, "handlecreate"])->name('user.handle.create');

Route::post('/user/delete', [PersonController::class, "delete"])->name('user.delete');

Route::get('/user/edit/{personId}', [PersonController::class, "edit"])->name('user.edit');

Route::put('/user/update/{personId}', [PersonController::class, "update"])->name('user.update');

Route::get('/user/index/{page}', [PersonController::class, "index"])->name('user.index');


//AuthController
Route::get('/signature/save', [AuthController::class, "save"])->name('signature.save');

Route::get('/recuperer-signature', [AuthController::class, 'recupererSignature'])->name('signature.recup');
// Route::get('/recuperer-signature', 'SignatureController@recupererSignature')->name('recuperer-signature');





Route::get('/auth/reset', [AuthController::class, "reset"])->name('auth.reset');

Route::get('/auth/profile', [AuthController::class, "profile"])->name('auth.profile');

Route::post('signaturepad', [AuthController::class, "upload"])->name('signature.upload');

//Authentication
//Route::get('/auth/code/{email}', [AuthController::class, "code"])->name('auth.code');

Route::post('/auth/code', [AuthController::class, "handlecode"])->name('auth.handle.code');

Route::post('/auth/reset', [AuthController::class, "handlereset"])->name('auth.handle.reset');

//Route::get('/auth/password', [AuthController::class, "password"])->name('auth.password');

Route::post('/auth/password', [AuthController::class, "handlepassword"])->name('auth.handle.password');

Route::get('/auth/logout', [AuthController::class, "logout"])->name('auth.logout');

//EnterpriseController
Route::get('/enterprise/index', [EnterpriseController::class, "index"])->name('enterprise.index');

Route::get('/pdf/{enterprise}', [EnterpriseController::class, "pdf"])->name('enterprise.pdf');

Route::put('/enterprise/update', [EnterpriseController::class, "update"])->name('enterprise.update');


//FirmController
Route::get('/firm/index/{page}', [FirmController::class, "index"])->name('firm.index');

Route::get('/firm/create', [FirmController::class, "create"])->name('firm.create');

Route::post('/firm/create', [FirmController::class, "store"])->name('firm.store');

Route::post('/firm/update', [FirmController::class, "update"])->name('firm.update');

Route::get('/firm/edit/{firmId}', [FirmController::class, "edit"])->name('firm.edit');


//RoleController
Route::get('/role/index', [RoleController::class, "index"])->name('role.index');

Route::post('/role/create', [RoleController::class, "create"])->name('role.create');

Route::get('/role/delete/{roleId}', [RoleController::class, "delete"])->name('role.delete');

Route::put('/role/update', [RoleController::class, "update"])->name('role.update');

Route::get('/role/{roleId}', [RoleController::class, "showRoleRights"])->name('role.show');


//FunctionController
Route::get('/function/index/{page}', [FunctionController::class, "index"])->name('function.index');

Route::get('/function/list/', [FunctionController::class, "list"])->name('function.list');

Route::put('/function/update', [FunctionController::class, "update"])->name('function.edit');

Route::post('/function/create', [FunctionController::class, "create"])->name('function.create');

Route::post('/function/delete', [FunctionController::class, "delete"])->name('function.delete');

Route::get('/function/update/{functionId}', [FunctionController::class, "update"])->name('function.update');

//DocumentController
Route::get('/document/create/{formId}', [DocumentController::class, "create"])->name('document.create');

Route::post('/document/handle/create', [App\Http\Controllers\DocumentController::class, "handlecreate"])->name('document.handle.create');

Route::get('/document/new', [DocumentController::class, "new"])->name('document.new');

Route::post('/document/initiate', [DocumentController::class, "initiate"])->name('document.initiate');

Route::get('/document/created/{page}', [DocumentController::class, "created"])->name('document.created');

Route::get('/document/initiated/{page}', [DocumentController::class, "initiated"])->name('document.initiated');

Route::get('/document/rejected/{page}', [DocumentController::class, "rejected"])->name('document.rejected');

Route::get('/document/validated/{page}', [DocumentController::class, "validated"])->name('document.validated');

Route::get('/document/display/{documentId}', [DocumentController::class, "display"])->name('document.display');

Route::get('/document/preview/{documentId}', [DocumentController::class, "preview"])->name('document.preview');

Route::post('/document/delete', [DocumentController::class, "delete"])->name('document.delete');

Route::get('/document/edit/{documentId}', [DocumentController::class, "edit"])->name('document.edit');

Route::get('/document/enhance/{documentId}', [DocumentController::class, "enhance"])->name('document.enhance');

Route::post('/document/update', [DocumentController::class, "update"])->name('document.update');

Route::post('/document/search', [DocumentController::class, "search"])->name('document.search');

Route::post('/document/search1', [DocumentController::class, "search1"])->name('document.search1');

Route::post('/document/search2', [DocumentController::class, "search2"])->name('document.search2');

Route::post('/document/search3', [DocumentController::class, "search3"])->name('document.search3');

Route::post('/try', [App\Http\Controllers\DocumentController::class, "try"])->name('document.try');


//FormViewController
Route::get('/form/models/{page}', [FormViewController::class, "models"])->name('form.models');

Route::post('/form/search', [FormViewController::class, "search"])->name('form.search');

//FormController
Route::get('/form/myforms/{page}', [FormController::class, "myforms"])->name('form.myforms');

Route::get('/form/create', [FormController::class, "create"])->name('form.create');

Route::get('/form/ignacio', [FormController::class, "ignacio"])->name('form.ignacio');

Route::post('/form/delete', [FormController::class, "delete"])->name('form.delete');

Route::post('/form/update', [FormController::class, "update"])->name('form.update');

Route::get('/form/edit/{formId}', [FormController::class, "edit"])->name('form.edit');

Route::post('/form/search2', [FormController::class, "search"])->name('form.search');

Route::post('/handle/some', [App\Http\Controllers\FormController::class, "handlecreate"])->name('handle.some');

//DocumentAgremmentController
Route::get('/approval/pending/{page}', [DocumentAgreementController::class, "pending"])->name('approval.pending');

Route::get('/approval/rejected/{page}', [DocumentAgreementController::class, "rejected"])->name('approval.rejected');

Route::post('/approval/rejected', [DocumentAgreementController::class, "reject"])->name('approval.reject');

Route::post('/approval/validated', [DocumentAgreementController::class, "valid"])->name('approval.valid');

Route::post('/approval/signed', [DocumentAgreementController::class, "sign"])->name('approval.sign');

Route::get('/approval/overview/{documentId}', [DocumentAgreementController::class, "overview"])->name('approval.overview');

Route::get('/approval/approved/{page}', [DocumentAgreementController::class, "approved"])->name('approval.approved');

Route::get('/approval/persons/{formId}/{level}', [DocumentAgreementController::class, "persons"])->name('approval.persons');

Route::post('/approval/search', [DocumentAgreementController::class, "search"])->name('approval.search');

Route::post('/approval/search1', [DocumentAgreementController::class, "search1"])->name('approval.search1');

Route::post('/approval/search2', [DocumentAgreementController::class, "search2"])->name('approval.search2');

Route::get('/pdfDocument/{document}', [DocumentController::class, "pdfDocument"])->name('documents.pdf');
