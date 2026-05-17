<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportController extends Controller
{
    public function transactionsExcel(Request $request): StreamedResponse
    {
        $fileName = 'stock-history-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Date',
                'Item Code',
                'Item Name',
                'Category',
                'Transaction Type',
                'Quantity',
                'Stock Before',
                'Stock After',
                'Officer',
                'Notes',
            ]);

            Transaction::query()
                ->with(['item.category', 'user'])
                ->latest()
                ->chunk(200, function ($transactions) use ($handle): void {
                    foreach ($transactions as $transaction) {
                        fputcsv($handle, [
                            $transaction->created_at?->format('Y-m-d H:i:s'),
                            $transaction->item?->code,
                            $transaction->item?->name,
                            $transaction->item?->category?->name,
                            $transaction->type->label(),
                            $transaction->quantity,
                            $transaction->stock_before,
                            $transaction->stock_after,
                            $transaction->user?->name,
                            $transaction->description,
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function transactionsPdf(Request $request)
    {
        $transactions = Transaction::query()
            ->with(['item.category', 'user'])
            ->latest()
            ->limit(500)
            ->get();

        if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('exports.transactions-pdf', [
                'transactions' => $transactions,
            ])->setPaper('a4', 'landscape');

            return $pdf->download('stock-history-'.now()->format('Y-m-d-His').'.pdf');
        }

        return response()->view('exports.transactions-pdf', [
            'transactions' => $transactions,
        ]);
    }
}
