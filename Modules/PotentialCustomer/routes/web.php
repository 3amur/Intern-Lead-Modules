<?php

use Illuminate\Support\Facades\Route;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\ImportedCustomerDataController;
use Modules\PotentialCustomer\app\Http\Controllers\HomeController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\CityController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\LinkController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\TeamController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\StateController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\BrokerController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\CountryController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\LeadTypeController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\LeadValueController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\BrokerTypeController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\DepartmentController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\LeadSourceController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\LeadStatusController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\SalesAgentController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\TargetTypeController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\LeadAccountController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\SalesTargetController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\TargetLayerController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\FamilyMemberController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\SalesCommissionController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\BrokerCommissionController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\PotentialAccountController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\CollectedCustomerDataController;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\PotentialAccountDetailsController;




// Form  of collect Data Route
Route::get('/potential_customer/collected_potential_account_data/', [CollectedCustomerDataController::class, 'formPage'])
    ->name('collected_customer_data.form_page');

Route::get('/potential_customer/collected_potential_account_data/success', [CollectedCustomerDataController::class, 'successPage'])
    ->name('collected_customer_data.successPage');

Route::post('/potential_customer/collected_potential_account_data/storeData', [CollectedCustomerDataController::class, 'storeFamilyData'])
    ->name('collected_customer_data.storeFamilyData');


//TODO:: Set Permission middleware  to accept reminder routes with potential and lead
Route::get('/lead_account/show/edit-reminder/{reminder}/{lead_account}', [LeadAccountController::class, 'editReminderPage'])->name('lead_account.editReminderPage');
Route::put('/lead_account/show/edit-reminder/{reminder}/{lead_account}', [LeadAccountController::class, 'updateCustomerReminder'])->name('lead_account.updateCustomerReminder');
Route::get('/potential_account/show/edit-reminder/{reminder}/{potential_account}', [PotentialAccountController::class, 'editReminderPage'])->name('potential_accounts.editReminderPage');
Route::put('/potential_account/show/edit-reminder/{reminder}/{potential_account}', [PotentialAccountController::class, 'updateCustomerReminder'])->name('potential_accounts.updateCustomerReminder');
Route::post('/lead_account/changeSelectedRows', [LeadAccountController::class, 'changeSelectedRows'])->name('lead_account.changeSelectedRows');
//Route::post('lead_account/filter', [LeadAccountController::class,'filter'])->name('lead_account.filter');






Route::prefix('potential_customer')->middleware(['auth', 'potentialCustomersRole', 'preventBrowserHistory'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('lead_home.index');
    /* Start Countries Routes */
    Route::post('/countries/export', [CountryController::class, 'export'])->name('countries.export');
    Route::resource('/countries', CountryController::class);
    /* End Countries Routes */

    /* Start States Routes */
    Route::post('/states/export', [StateController::class, 'export'])->name('states.export');
    Route::post('/get_states', [StateController::class, 'getStates'])->name('states.getStates');
    Route::resource('/states', StateController::class);
    /* End States Routes */

    /* Start Cities Routes */
    Route::post('/cities/export', [CityController::class, 'export'])->name('cities.export');
    Route::post('/get_cities', [CityController::class, 'getCities'])->name('cities.getCities');
    Route::resource('/cities', CityController::class);
    /* End Cities Routes */

    /* Start Leads Routes */
    Route::post('/lead_source/export', [LeadSourceController::class, 'export'])->name('lead_source.export');
    Route::resource('/lead_source', LeadSourceController::class);

    Route::post('/lead_status/export', [LeadStatusController::class, 'export'])->name('lead_status.export');
    Route::resource('/lead_status', LeadStatusController::class);

    Route::post('/lead_type/export', [LeadTypeController::class, 'export'])->name('lead_type.export');
    Route::resource('/lead_type', LeadTypeController::class);

    Route::post('/lead_value/export', [LeadValueController::class, 'export'])->name('lead_value.export');
    Route::resource('/lead_value', LeadValueController::class);
    /* End Leads Routes */

    /* Start Lead Account Routes */
    Route::put('/lead_account//potentialTransition/{lead_account}', [LeadAccountController::class, 'potentialTransition'])->name('lead_account.potentialTransition');
    Route::put('/lead_account/activate/{lead_account}', [LeadAccountController::class, 'activate'])->name('lead_account.activate');
    Route::post('/lead_account/import', [LeadAccountController::class, 'import'])->name('lead_account.import');
    Route::get('/lead_account/matchColumns', [LeadAccountController::class, 'matchColumns'])->name('lead_account.matchColumns');
    Route::post('/lead_account/matchColumnUpdate', [LeadAccountController::class, 'matchColumnUpdate'])->name('lead_account.matchColumnUpdate');
    Route::get('/lead_account/mapping_data', [LeadAccountController::class, 'getImportedData'])->name('lead_account.getImportedData');
    Route::post('/lead_account/insert_new_data', [LeadAccountController::class, 'insertNewData'])->name('lead_account.insertNewData');
    Route::get('/lead_account/exportNewData', [LeadAccountController::class, 'exportNewData'])->name('lead_account.exportNewData');
    Route::get('/lead_account/export_invalidRows', [LeadAccountController::class, 'exportInvalidRows'])->name('lead_account.exportInvalidRows');
    Route::get('/lead_account/exportCollectedDataFromImport', [LeadAccountController::class, 'exportCollectedDataFromImport'])->name('lead_account.exportCollectedDataFromImport');

    Route::resource('/lead_account', LeadAccountController::class);
    Route::post('/lead_account/export', [LeadAccountController::class, 'export'])->name('lead_account.export');

    /* End Lead Account Routes */

    /* Start Collected data  Routes */
    Route::post('/potential_account/imported_customer_data/import', [ImportedCustomerDataController::class, 'import'])->name('imported_customer_data.import');
    Route::get('/potential_account/imported_customer_data/matchColumns/{potentialAccountId}', [ImportedCustomerDataController::class, 'matchColumns'])->name('imported_customer_data.matchColumns');
    Route::post('/potential_account/imported_customer_data/matchColumnUpdate', [ImportedCustomerDataController::class, 'matchColumnUpdate'])->name('imported_customer_data.matchColumnUpdate');
    Route::get('/potential_account/imported_customer_data/mapping_data/{potential_account_id}', [ImportedCustomerDataController::class, 'getImportedData'])->name('imported_customer_data.getImportedData');
    Route::post('/potential_account/imported_customer_data/insert_new_data', [ImportedCustomerDataController::class, 'insertNewData'])->name('imported_customer_data.insertNewData');
    Route::get('/potential_account/imported_customer_data/exportNewData/{potential_account_id}', [ImportedCustomerDataController::class, 'exportNewData'])->name('imported_customer_data.exportNewData');
    Route::get('/potential_account/imported_customer_data/export_invalidRows/{potential_account_id}', [ImportedCustomerDataController::class, 'exportInvalidRows'])->name('imported_customer_data.exportInvalidRows');
    Route::get('/potential_account/imported_customer_data/exportCollectedDataFromImport/{potential_account_id}', [ImportedCustomerDataController::class, 'exportCollectedDataFromImport'])->name('imported_customer_data.exportImportedData');
    Route::post('/potential_account/imported_customer_data/exportCollectedData/{potential_account_id}', [ImportedCustomerDataController::class, 'export'])->name('imported_customer_data.export');



    Route::get('/potential_account/collected_data/{potential_account}', [CollectedCustomerDataController::class, 'showCollectedDataDetails'])->name('collected_customer_data.showCollectedDataDetails');
    Route::get('/potential_account/collected_data/potential_account/{head_member}', [CollectedCustomerDataController::class, 'showHeadMemberDetails'])->name('collected_customer_data.showHeadMemberDetails');
    Route::get('/potential_account/collected_data/Charts/{potential_account}', [CollectedCustomerDataController::class, 'chartPage'])->name('collected_customer_data.chartPage');
    Route::get('/potential_account/collected_data/exportSelectedMembers/{potential_account_id}', [CollectedCustomerDataController::class, 'exportSelectedMembers'])->name('collected_customer_data.exportSelectedMembers');
    Route::get('/potential_account/collected_data/export/{potential_account_id}', [CollectedCustomerDataController::class, 'exportCollectedData'])->name('collected_customer_data.exportCollectedData');

    /* End Collected data  Routes */

    /* Start Potential Account Routes */
    Route::put('/LeadTransition/{potential_account}', [PotentialAccountController::class, 'LeadTransition'])->name('potential_account.LeadTransition');
    Route::put('/potential_account/activate/{potential_account}', [PotentialAccountController::class, 'activate'])->name('potential_account.activate');
    Route::post('/potential_account/import', [PotentialAccountController::class, 'import'])->name('potential_account.import');
    Route::get('/potential_account/matchColumns', [PotentialAccountController::class, 'matchColumns'])->name('potential_account.matchColumns');
    Route::post('/potential_account/matchColumnUpdate', [PotentialAccountController::class, 'matchColumnUpdate'])->name('potential_account.matchColumnUpdate');
    Route::get('/potential_account/mapping_data', [PotentialAccountController::class, 'getImportedData'])->name('potential_account.getImportedData');
    Route::post('/potential_account/insert_new_data', [PotentialAccountController::class, 'insertNewData'])->name('potential_account.insertNewData');
    Route::get('/potential_account/exportNewData', [PotentialAccountController::class, 'exportNewData'])->name('potential_account.exportNewData');
    Route::get('/potential_account/export_invalidRows', [PotentialAccountController::class, 'exportInvalidRows'])->name('potential_account.exportInvalidRows');
    Route::post('/potential_account/changeSelectedRows', [PotentialAccountController::class, 'changeSelectedRows'])->name('potential_account.changeSelectedRows');
    Route::post('/potential_account/export', [PotentialAccountController::class, 'export'])->name('potential_account.export');

    Route::resource('/potential_account', PotentialAccountController::class);
    /* End Potential Account Routes */

    /* Start Potential Account Details Routes */
    Route::resource('/potential_account/{potential_account}/potential_account_details', PotentialAccountDetailsController::class);
    /* End Potential Account Details Routes */

    /* Start Links Routes */
    Route::resource('/links', LinkController::class);
    /* End Links Routes */



    /* Start Family Members Routes */
    Route::resource('/family_members', FamilyMemberController::class);
    /* End Family Members Routes */

    /* Start Target Types Routes */
    Route::post('/target_types/export',[ TargetTypeController::class,'export'])->name('target_types.export');
    Route::resource('/target_types', TargetTypeController::class);
    /* End Family Members Routes */

    /* Start Sales Targets Routes */
    Route::post('/sales_targets/validate_target_data_on_create', [SalesTargetController::class, 'checkExistingTargetOnCreate'])->name('sales_targets.checkExistingTargetOnCreate');
    Route::post('/sales_targets/validate_target_data_on_update', [SalesTargetController::class, 'checkExistingTargetOnUpdate'])->name('sales_targets.checkExistingTargetOnUpdate');
    Route::post('/sales_targets/export',[ SalesTargetController::class,'export'])->name('sales_targets.export');
    Route::resource('/sales_targets', SalesTargetController::class);
    /* End Family Members Routes */

    /* Start Target Layers Routes */
    Route::get('/sales_targets/getTargetLayersData/{sales_target_id}', [TargetLayerController::class, 'getTargetLayersData'])->name('sales_targets.getTargetLayersData');
    /* End Target Layers Routes */

    /* Start Sales Agents Routes */
    Route::post('/sales_agents/export',[ SalesAgentController::class,'export'])->name('sales_agents.export');
    Route::resource('/sales_agents', SalesAgentController::class);
    /* End Sales Agents Routes */

    /* Start Sales Commissions Routes */
    Route::post('/sales_agents/{sales_agent}/sales_commissions/export',[ SalesCommissionController::class,'export'])->name('sales_commissions.export');
    Route::resource('/sales_targets/sales_agents/{sales_agent}/sales_commissions', SalesCommissionController::class);
    /* End Sales Commissions Routes */

    /* Start Broker Type Routes */
    Route::post('/broker_types/export',[ BrokerTypeController::class,'export'])->name('broker_types.export');
    Route::resource('/broker_types', BrokerTypeController::class);
    /* End Broker Type Routes */

    /* Start Broker  Routes */
    Route::post('/brokers/export',[ BrokerController::class,'export'])->name('brokers.export');
    Route::resource('/brokers', BrokerController::class);
    /* End Broker  Routes */

    /* Start Broker Commissions  Routes */
    Route::post('/brokers/{broker}/broker_commissions/export',[ BrokerCommissionController::class,'export'])->name('broker_commissions.export');
    Route::resource('/brokers/{broker}/broker_commissions', BrokerCommissionController::class);
    /* End Broker Commissions  Routes */

    /* Start Departments  Routes */
    Route::resource('/departments', DepartmentController::class);
    /* End Broker  Routes */

    /* Start Teams  Routes */
    Route::resource('/teams', TeamController::class);
    /* End Broker  Routes */
});
