<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Mahasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .info {
            margin-bottom: 15px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table thead {
            background-color: #f0f0f0;
        }
        table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }
        .badge-pending {
            background-color: #fbbf24;
        }
        .badge-in_review {
            background-color: #60a5fa;
        }
        .badge-in_progress {
            background-color: #8b5cf6;
        }
        .badge-resolved {
            background-color: #10b981;
        }
        .badge-rejected {
            background-color: #ef4444;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #999;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Laporan Mahasiswa</h1>
            <p>Laporan Keluhan dan Saran Mahasiswa</p>
        </div>

        <div class="info">
            <p><strong>Total Laporan:</strong> {{ $totalReports }}</p>
            <p><strong>Tanggal Export:</strong> {{ $exportDate }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 12%">No. Referensi</th>
                    <th style="width: 18%">Judul</th>
                    <th style="width: 12%">Kategori</th>
                    <th style="width: 12%">Pelapor</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 10%">Prioritas</th>
                    <th style="width: 12%">Gedung</th>
                    <th style="width: 12%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr>
                    <td>{{ $report->reference_number }}</td>
                    <td>{{ Str::limit($report->title, 50) }}</td>
                    <td>{{ $report->category->name ?? '-' }}</td>
                    <td>{{ $report->user->name ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $report->status }}">
                            {{ $report->status_label }}
                        </span>
                    </td>
                    <td>{{ $report->priority_label }}</td>
                    <td>{{ $report->building->name ?? '-' }}</td>
                    <td>{{ $report->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Generated on {{ now()->format('d-m-Y H:i:s') }} | Lapor Mahasiswa System</p>
        </div>
    </div>
</body>
</html>
