<?php


////////////////////////////// Mohamed Gamal  ////////////////////////////////////

// Index
Route::resource('financesIndex',
    'Finances\AdminFinancesIndexController');


////////////////////////////// السندات  ////////////////////////////////////

Route::resource('billsOfExchange','Finances\AdminBillsOfExchangeController');

Route::get('billsOfExchange/print/{id}','Finances\AdminBillsOfExchangeController@print')
    ->name('billsOfExchange.print');



Route::resource('receipt','Finances\AdminReceiptController');
Route::get('receipt/print/{id}','Finances\AdminReceiptController@print')
    ->name('receipt.print');

////////////////////////////////// القيود اليومية /////////////////////////////////
Route::resource('dailyConstraints','Finances\AdminDailyConstraintsController');


Route::DELETE('dailyConstraints-bluk','Finances\AdminDailyConstraintsController@delete_all')
    ->name('dailyConstraints.delete.bulk');

Route::get('dailyConstraints/print/{id}','Finances\AdminDailyConstraintsController@print')
    ->name('dailyConstraints.print');


Route::POST('dailyConstraints-Search','Finances\AdminDailyConstraintsController@Search')
    ->name('dailyConstraints.Search');


//////////////////////////// حركة النقدية ///////////////////////////////////
Route::any('cashMovement','Finances\AdminCashMovementController@Search')
    ->name('cashMovement');


////////////////////////// كشف حساب /////////////////
Route::any('allAccountStatement','Finances\AdminAccountStatementController@Search')
    ->name('allAccountStatement');


Route::resource('accountsTree','Finances\AdminAccountTreeController');

Route::resource('openingBalances','Finances\AdminOpeningBalancesController');





//--------------------------- mariam ----------------------------------

//normal sand sarf report
Route::get('NormalSandSarfReport', 'Finances\Reports\NormalSanadSarfReport@index')->name('NormalSandSarfReport');
Route::get('convertSandSarf/{id}', 'Finances\Reports\NormalSanadSarfReport@convert')->name('convertSandSarf');
Route::get('sanadSarfConfirmedList', 'Finances\Reports\NormalSanadSarfReport@confirmedList')->name('sanadSarfConfirmedList');

//normal sand qabd report
Route::get('NormalSandQabdReport', 'Finances\Reports\NormalSanadElQabdReport@index')->name('NormalSandQabdReport');
Route::get('convertSandQabd/{id}', 'Finances\Reports\NormalSanadElQabdReport@convert')->name('convertSandQabd');
Route::get('sanadQabdConfirmedList', 'Finances\Reports\NormalSanadElQabdReport@confirmedList')->name('sanadQabdConfirmedList');


//Trial Balance Report
Route::get('TrialBalance', 'Finances\Reports\TrialBalanceController@index')->name('TrialBalance');
Route::post('TrialBalanceFilter', 'Finances\Reports\TrialBalanceController@filter')->name('TrialBalanceFilter');

//snad qabd check
Route::get('ReceivablesChecksReport', 'Finances\Reports\ReceivablesChecksController@index')->name('ReceivablesChecksReport');
Route::get('ReceivablesChecksConvert/{id}', 'Finances\Reports\ReceivablesChecksController@convert')->name('ReceivablesChecksConvert');

Route::get('ReceivablesChecksTodayConfirmedList', 'Finances\Reports\ReceivablesChecksController@ReceivablesChecksTodayConfirmedList')->name('ReceivablesChecksTodayConfirmedList');
Route::get('ReceivablesChecksAllConfirmedList', 'Finances\Reports\ReceivablesChecksController@ReceivablesChecksAllConfirmedList')->name('ReceivablesChecksAllConfirmedList');

Route::get('confirmCheck/{id}', 'Finances\Reports\ReceivablesChecksController@confirmCheck')->name('confirmCheck');


//snad sarf check
Route::get('ExchangeChecksReport', 'Finances\Reports\ExchangeVouchersController@index')->name('ExchangeChecksReport');
Route::get('ExchangeChecksConvert/{id}', 'Finances\Reports\ExchangeVouchersController@convert')->name('ExchangeChecksConvert');

Route::get('ExchangeChecksTodayConfirmedList', 'Finances\Reports\ExchangeVouchersController@ReceivablesChecksTodayConfirmedList')->name('ExchangeChecksTodayConfirmedList');
Route::get('ExchangeChecksAllConfirmedList', 'Finances\Reports\ExchangeVouchersController@ExchangeChecksAllConfirmedList')->name('ExchangeChecksAllConfirmedList');

Route::get('ExchangeconfirmCheck/{id}', 'Finances\Reports\ExchangeVouchersController@confirmCheck')->name('ExchangeconfirmCheck');


//accounts  settings
Route::resource('accountsSetting',
    'SystemSetting\AdminAccountsController');

Route::get('getAccountCode',
    'Finances\AdminAccountsController@getAccountCode')
    ->name('getAccountCode');



Route::resource('incomeList','Finances\AdminIncomeListController');


Route::resource('statementOfFinancialPosition','Finances\AdminStatementOfFinancialPositionController');


Route::any('closeReportToday','AdminCloseReportTodayController@index')->name('closeReportToday');
Route::get('loadClosePrint','AdminCloseReportTodayController@loadClosePrint')->name('loadClosePrint');


Route::any('Profit','AdminProfitController@index')->name('Profit');
Route::get('profitPrint','AdminProfitController@profitPrint')->name('profitPrint');

Route::get('Item_movement/{paginate_val}/{item_id}', 'Report\ItemMovement@index')->name('Item_movement');
