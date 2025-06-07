<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stock Obat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header .subtitle {
            font-size: 14px;
            margin: 5px 0;
        }

        .date-info {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .separator {
            border-top: 2px solid #000;
            margin: 20px 0;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .no-wrap {
            white-space: nowrap;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            margin-right: 50px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>PUSKESMAS RANTAU KOPAR</h1>
        <div class="subtitle">Jalan Lintas Selatan Sei Tabuk Kec. Rantau Kopar</div>
        <div class="subtitle">Kec. Rantau Kopar</div>
    </div>

    <div class="separator"></div>

    <div class="date-info">
        <strong>Periode: {{ $tanggal_mulai ?? 'Semua Data' }} - {{ $tanggal_akhir ?? date('Y-m-d') }}</strong>
    </div>

    <div class="report-title">LAPORAN STOCK OBAT</div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Obat</th>
                <th style="width: 15%;">Jenis Obat</th>
                <th style="width: 10%;">Bentuk</th>
                <th style="width: 10%;">Isi Kemasan</th>
                <th style="width: 8%;">Satuan</th>
                <th style="width: 10%;">Stock</th>
                <th style="width: 12%;">Tanggal Masuk</th>
                <th style="width: 12%;">Tanggal Kadaluarsa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($obat as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_obat }}</td>
                    <td>{{ $item->jenis_obat }}</td>
                    <td class="text-center">{{ $item->bentuk }}</td>
                    <td class="text-right">{{ number_format($item->isi_kemasan) }}</td>
                    <td class="text-center">{{ $item->satuan }}</td>
                    <td class="text-right">{{ number_format($item->stock_obat) }}</td>
                    <td class="text-center no-wrap">{{ date('d/m/Y', strtotime($item->tanggal_masuk)) }}</td>
                    <td class="text-center no-wrap">{{ date('d/m/Y', strtotime($item->tanggal_kadaluarsa)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data obat</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div style="margin-top: 30px;">
            <strong>Total Data: {{ $obat->count() }} item</strong>
        </div>

        <div class="signature">
            <div>Rantau Kopar, {{ date('d F Y') }}</div>
            <div style="margin-top: 10px;">Penanggung Jawab</div>
            <div style="margin-top: 70px;">
                <div style="margin-top: 5px;">Nama & Jabatan</div>
            </div>
        </div>
    </div>
</body>

</html>
