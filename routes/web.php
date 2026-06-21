<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Building\BuildingController;
use App\Http\Controllers\Building\BuildingOwnerController;
use App\Http\Controllers\Building\BuildingTypeController;
use App\Http\Controllers\Building\FloorDescriptionController;
use App\Http\Controllers\Building\PreviousOwnerController;
use App\Http\Controllers\Customer\ClientController;
use App\Http\Controllers\Customer\SubscriptionController;
use App\Http\Controllers\CustomerPen\CustomerPenController;
use App\Http\Controllers\CustomerPenTreatment\CustomerPenTreatmentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Economical\EconomicalController;
use App\Http\Controllers\LicensForm\LicenseFormController;
use App\Http\Controllers\ProofOfCase\ProofOfCaseController;
use App\Http\Controllers\RegulatoryDisclosureReport\RegulatoryDisclosureReportController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\Street\StreetController;
use App\Http\Controllers\Treatment\TreatmentController;
use App\Http\Controllers\Unit\UnitController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Zone\SubZoneController;
use App\Http\Controllers\Zone\ZoneController;
use Illuminate\Support\Facades\Route;

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

Route::get('artisan_db', function () {
    \Artisan::call('optimize:clear');
    dd("done");
});

Route::get('list',[DashboardController::class,'list']);
Route::get('crafts',[DashboardController::class,'crafts']);
Route::post('crafts',[DashboardController::class,'craftsStore']);

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/',         'index');
    });

    Route::controller(LoginController::class)->prefix('auth')->group(function () {
        Route::get('login',         'index')->name('auth.login');
        Route::post('login',        'authenticate')->name('auth.authenticate');
        Route::get('logout',        'logout')->name('auth.logout');
    });

    Route::group(['prefix' => 'home'], function () {

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/',         'index')->name('dashboard.index');
        });

        Route::controller(StreetController::class)->group(function () {
            Route::put('streets/update',        'update')->name('streets.update_data');
        });

        Route::controller(ZoneController::class)->group(function () {
            Route::put('zones/update',        'update')->name('zones.update_data');
        });

        Route::controller(SubZoneController::class)->group(function () {
            Route::put('sub-zones/update',        'update')->name('sub-zones.update_data');
        });
        Route::controller(BuildingOwnerController::class)->group(function () {
            Route::put('building-owners',        'update')->name('building-owners.update_data');
            Route::post('building-owners/storeOwnerNew',        'storeOwnerNew')->name('building-owners.storeOwnerNew');
        });
        Route::controller(PreviousOwnerController::class)->group(function () {
            Route::get('building/previous-owners/{id}',        'getPreviousOwnerForBuilding')->name('previous-owners.getPreviousOwnerForBuilding');
        });


        Route::controller(BuildingController::class)->group(function () {
            Route::get('buildings/get-owner-for-building/{id}',         'getOwnerForBuilding')->name('building_owner.all');
            Route::get('buildings/get-unit-for-building/{id}',          'getUnitForBuilding')->name('building_unit.all');
            Route::get('buildings/get-floor-for-building/{id}',         'getFloorForBuilding')->name('building_floor.all');
            Route::get('buildings/get-craft-for-building/{id}',         'getCraftForBuilding')->name('building_craft.all');
            Route::get('buildings/get-subscription-for-building/{id}',  'getSubscriptionForBuilding')->name('building_subscription.all');
            Route::get('buildings/get-proof-for-building/{id}',         'getproofForBuilding')->name('building_proof.all');
            Route::get('buildings/export-excel',                        'exportExcel')->name('buildings.exportExcel');
            Route::post('buildings/upload-attchment',            'uploadAttchment')->name('buildings.uploadAttchment');

            Route::post('buildings/fetch-subzones',            'fetchSubZone')->name('buildings.fetchSubZone');
            Route::post('buildings/changeImage',            'changeImage')->name('building.changeImage');

        });

        Route::controller(BuildingTypeController::class)->group(function () {
            Route::put('building-types/update',        'update')->name('building-types.update_data');
        });

        Route::controller(FloorDescriptionController::class)->group(function () {
            Route::put('building-floor/update',        'update')->name('floor-descriptions.update_data');
        });

        Route::controller(UnitController::class)->group(function () {
            Route::put('units/update',        'update')->name('units.update_data');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::put('roles/update',        'update')->name('roles.update_data');
        });

        Route::controller(UserController::class)->group(function () {
            Route::put('users/update',        'update')->name('users.update_data');
            Route::get('user/profile',        'getProfile')->name('users.getProfile');
            Route::put('user/profile',        'updateProfile')->name('users.updateProfile');
        });
        Route::controller(ProofOfCaseController::class)->group(function () {
            Route::put('proof/update',        'update')->name('proof-of-cases.update_data');
            Route::put('proof/confirm',        'confirm')->name('proof-of-cases.confirm');
            Route::post('proof/UploadAttachment',        'UploadAttachment')->name('proof-of-cases.UploadAttachment');
        });
        Route::controller(RegulatoryDisclosureReportController::class)->group(function () {
            Route::put('regulatory-disclosure-reports/update',        'update')->name('regulatory-disclosure-reports.update_data');
            Route::put('regulatory-disclosure-reports/confirm_data',        'confirm_data')->name('regulatory-disclosure-reports.confirm_data');
        });

        Route::controller(CustomerPenController::class)->group(function () {
            Route::put('customer-pens/update',        'update')->name('customer-pens.update_data');
        });
        Route::controller(TreatmentController::class)->group(function () {
            Route::put('treatments/update',        'update')->name('treatments.update_data');
            Route::get('treatments/getOpenTreatmentForClient',        'getOpenTreatmentForClient')->name('treatments.getOpenTreatmentForClient');

        });

        Route::controller(DepartmentController::class)->group(function () {
            Route::put('departments/update',        'update')->name('departments.update_data');
        });
        Route::controller(LicenseFormController::class)->group(function () {
            Route::post('license_forms/storeOwnerNew',        'storeOwnerNew')->name('license_forms.storeOwnerNew');
            Route::get('license_forms/get-floor-for-license/{id}',         'getFloorForlicense')->name('licenseFloor.all');
            Route::get('license_forms/print/{id}',         'print')->name('license_forms.print');
            Route::get('license_forms/printRegulatory/{id}',         'printRegulatory')->name('license_forms.printRegulatory');
            Route::get('license_forms/printFania/{id}',         'printFania')->name('license_forms.printFania');

            Route::get('license_forms/printOpin/{id}',         'printOpin')->name('license_forms.printOpin');
            Route::get('license_forms/printFloor/{id}',         'printFloor')->name('license_forms.printFloor');

            //upload file
            Route::post('license_forms/title_deedUpload',                   'title_deedUpload')->name('license_forms.title_deedUpload');
            Route::post('license_forms/generalSitePlanUpload',              'generalSitePlanUpload')->name('license_forms.generalSitePlanUpload');
            Route::post('license_forms/constructionMapUpload',              'constructionMapUpload')->name('license_forms.constructionMapUpload');
            Route::post('license_forms/undertakingSuperviseUpload',         'undertakingSuperviseUpload')->name('license_forms.undertakingSuperviseUpload');
            Route::post('license_forms/aprobacionesTercerosUpload',         'aprobacionesTercerosUpload')->name('license_forms.aprobacionesTercerosUpload');
            
            Route::post('license_forms/attachmentOneUpload',         'attachmentOneUpload')->name('license_forms.attachmentOneUpload');

            //End Upload

            Route::get('license_forms/certified/{id}',         'certified')->name('license_forms.certified');
        });

        Route::controller(CustomerPenTreatmentController::class)->group(function () {
            Route::post('customer-pen-treatments/search-Id-Num',        'searchIdNum')->name('search_Id_Num');
        });

        Route::controller(EconomicalController::class)->group(function () {
            Route::get('economical/new',         'new')->name('economical.new');

            Route::put('economical/update',        'update')->name('economical.update_data');
            Route::post('economical/printFrom',        'printFrom')->name('economical.printFrom');

            Route::get('economical/getTypes/{id}',        'getTypes')->name('economical.getTypes');

            Route::get('fetchBuilding/{street}/{building}',        'fetchBuilding')->name('economical.fetchBuilding');

        });
        Route::controller(\App\Http\Controllers\Treatment\TreatmentUserController::class)->group(function () {
            Route::put('treatment-users/update',        'update')->name('treatment-users.update_data');
        });
        Route::put('roles/{role}/permissions',          [RolePermissionController::class, 'update'])->name('RolePermission.update');


        Route::controller(SubscriptionController::class)->group(function () {
            Route::put('subscriptions/update',        'update')->name('subscriptions.update_data');
        });

        Route::resources([
            'streets'               => StreetController::class,
            'zones'                 => ZoneController::class,
            'sub-zones'             => SubZoneController::class,
            'subscriptions'         => SubscriptionController::class,
            'clients'               => ClientController::class,
            'buildings'             => BuildingController::class,
            'building-types'        => BuildingTypeController::class,
            'building-owners'       => BuildingOwnerController::class,
            'floor-descriptions'    => FloorDescriptionController::class,
            'units'                 => UnitController::class,
            'regulatory-disclosure-reports'         => RegulatoryDisclosureReportController::class,
            'license_forms'             => LicenseFormController::class,
            'roles'                     => RoleController::class,
            'users'                     => UserController::class,
            'proof-of-cases'            => ProofOfCaseController::class,
            'economical'                => EconomicalController::class,
            'treatments'                => TreatmentController::class,
            'departments'               => DepartmentController::class,
            'customer-pens'             => CustomerPenController::class,
            'customer-pen-treatments'   => CustomerPenTreatmentController::class,
            'treatment-users'   => \App\Http\Controllers\Treatment\TreatmentUserController::class,

        ]);
    });
});
