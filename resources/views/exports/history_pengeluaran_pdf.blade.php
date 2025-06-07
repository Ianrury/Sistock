<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kartu Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header .subtitle {
            font-size: 11px;
            margin: 5px 0;
        }

        .card-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
            display: inline-block;
            flex-shrink: 0;
        }

        .info-colon {
            width: 20px;
            text-align: left;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
            /* border-bottom: 1px solid #000; */
            min-height: 20px;
            padding-left: 10px;
            padding-bottom: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px 4px;
            text-align: center;
            font-size: 11px;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .col-no {
            width: 8%;
        }

        .col-tgl {
            width: 12%;
        }

        .col-dari {
            width: 20%;
        }

        .col-penerimaan {
            width: 15%;
        }

        .col-pengeluaran {
            width: 15%;
        }

        .col-sisa {
            width: 12%;
        }

        .col-paraf {
            width: 8%;
        }

        .col-kadaluarsa {
            width: 15%;
        }

        .row-height {
            height: 25px;
        }

        /* Untuk membuat baris kosong */
        .empty-rows td {
            height: 25px;
            border-right: 1px solid #000;
        }

        @media print {
            body {
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>PUSKESMAS RANTAU KOPAR</h1>
        <div class="subtitle">Jalan Lintas Selatan Sei Tabuk Kec. Rantau Kopar</div>
        <div class="subtitle">Kec. Rantau Kopar</div>
    </div>

    <!-- Card Title -->
    <div class="card-title">KARTU STOCK</div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Jenis Obat </span>
            <span class="info-value">: {{ $obat->nama_obat ?? '' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kemasan </span>
            <span class="info-value">: {{ $obat->bentuk ?? '' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Isi Kemasan </span>
            <span class="info-value">: {{ $obat->isi_kemasan ?? '' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Satuan </span>
            <span class="info-value">: {{ $obat->satuan ?? '' }}</span>
        </div>
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th class="col-no">No.</th>
                <th class="col-tgl">Tgl</th>
                <th class="col-dari">Dari/Kepada</th>
                <th class="col-penerimaan">Penerimaan</th>
                <th class="col-pengeluaran">Pengeluaran</th>
                <th class="col-sisa">Sisa Stok</th>
                <th class="col-paraf">Paraf</th>
                <th class="col-kadaluarsa">Kadaluarsa</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($history as $item)
                <tr class="row-height">
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d/m/Y') }}</td>
                    <td style="text-align: left;">{{ $item->dari ?? 'Tidak diketahui' }} /
                        {{ $item->kepada ?? 'Tidak diketahui' }}</td>
                    <td>{{ $item->penerima ?? '-' }}</td>
                    <td>{{ $item->pengeluaran ?? '-' }}</td>
                    <td>{{ $item->sisa_stock ?? '-' }}</td>
                    <td></td>
                    <td>
                        @if ($item->tanggal_kadaluarsa)
                            {{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach

            <!-- Empty rows untuk membuat form yang sama seperti aslinya -->
            @for ($i = count($history); $i < 20; $i++)
                <tr class="empty-rows row-height">
                    <td>{{ $i + 1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>

</html>
