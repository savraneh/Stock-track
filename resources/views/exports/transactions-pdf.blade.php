<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Histori Stok</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #0f172a; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        p { margin-top: 0; color: #475569; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th { background: #eff6ff; color: #1e3a8a; }
        th, td { border: 1px solid #cbd5e1; padding: 7px; text-align: left; vertical-align: top; }
        .badge { border-radius: 999px; padding: 2px 8px; background: #dbeafe; color: #1d4ed8; font-size: 10px; }
    </style>
</head>
<body>
    <h1>Laporan Histori Stok STOCK-TRACK</h1>
    <p>Dicetak pada {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Barang</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Sebelum</th>
                <th>Sesudah</th>
                <th>Petugas</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at?->format('Y-m-d H:i') }}</td>
                    <td>{{ $transaction->item?->code }}</td>
                    <td>{{ $transaction->item?->name }}</td>
                    <td>{{ $transaction->item?->category?->name }}</td>
                    <td><span class="badge">{{ $transaction->type->label() }}</span></td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->stock_before }}</td>
                    <td>{{ $transaction->stock_after }}</td>
                    <td>{{ $transaction->user?->name }}</td>
                    <td>{{ $transaction->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (! class_exists('Barryvdh\\DomPDF\\Facade\\Pdf'))
        <script>window.print()</script>
    @endif
</body>
</html>
