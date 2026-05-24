<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan AksesPro</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #0A2540;
            padding-bottom: 15px;
        }

        .logo-container {
            float: left;
            width: 50%;
        }

        .title-container {
            float: right;
            width: 50%;
            text-align: right;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            color: #0A2540;
            margin: 0 0 5px 0;
        }

        .subtitle {
            font-size: 12px;
            color: #555;
            margin: 0;
        }

        .clear {
            clear: both;
        }

        .stats-grid {
            margin-bottom: 30px;
        }

        .stat-card {
            float: left;
            width: 145px;
            margin-right: 12px;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            padding: 10px;
            background-color: #fff;
            text-align: center;
        }

        .stat-card.last {
            margin-right: 0;
        }

        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #858796;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .stat-value {
            font-size: 15px;
            font-weight: bold;
            color: #0A2540;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #0A2540;
            margin: 0 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #e3e6f0;
        }

        .trx-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .trx-table th {
            background-color: #0A2540;
            color: #fff;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px;
            font-size: 10px;
            text-transform: uppercase;
        }

        .trx-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e3e6f0;
            font-size: 11px;
        }

        .trx-table tr:nth-child(even) {
            background-color: #f8f9fc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #858796;
            border-top: 1px solid #e3e6f0;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <h2 style="color: #0A2540; margin: 0; font-size: 24px;">AksesPro</h2>
            <p style="margin: 5px 0 0 0; color: #858796; font-size: 10px;">Vending Machine Lisensi Digital</p>
        </div>
        <div class="title-container">
            <h1 class="title">LAPORAN KEUANGAN</h1>
            <p class="subtitle">Periode: {{ $periodeText }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Pendapatan Kotor</div>
            <div class="stat-value">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Keuntungan Bersih</div>
            <div class="stat-value" style="color: #1cc88a;">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $totalTransactions }}</div>
        </div>
        <div class="stat-card last">
            <div class="stat-label">Transaksi Gagal</div>
            <div class="stat-value" style="color: #e74a3b;">{{ $failedTransactions }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="section-title">Rincian Transaksi Sukses</div>
    <table class="trx-table">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Waktu</th>
                <th>Pengguna</th>
                <th>Produk</th>
                <th>Metode Bayar</th>
                <th class="text-right">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
                <tr>
                    <td style="font-family: monospace;">{{ $trx->invoice_id }}</td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $trx->user ? $trx->user->name : 'N/A' }}</td>
                    <td>{{ $trx->product ? $trx->product->name : 'N/A' }}</td>
                    <td>{{ $trx->payment_method }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp
                        {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #858796;">Tidak ada transaksi sukses pada
                        periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan Keuangan Otomatis AksesPro &bull; Diunduh pada {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>

</html>
