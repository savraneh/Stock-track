<?php

use App\Http\Controllers\ReportExportController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin')->name('home');

Route::middleware(['auth'])->group(function (): void {
    Route::get('reports/transactions/excel', [ReportExportController::class, 'transactionsExcel'])
        ->name('reports.transactions.excel');

    Route::get('reports/transactions/pdf', [ReportExportController::class, 'transactionsPdf'])
        ->name('reports.transactions.pdf');
});
