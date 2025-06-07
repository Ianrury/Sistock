<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StockObatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    protected $obat;
    protected $tanggal_mulai;
    protected $tanggal_akhir;
    protected $tahun;

    public function __construct($obat, $tanggal_mulai = null, $tanggal_akhir = null, $tahun = null)
    {
        $this->obat = $obat;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return $this->obat;
    }

    public function headings(): array
    {
        return ['No', 'Nama Obat', 'Jenis Obat', 'Bentuk', 'Isi Kemasan', 'Satuan', 'Stock Obat', 'Tanggal Masuk', 'Tanggal Kadaluarsa', 'Status'];
    }

    public function map($obat): array
    {
        static $no = 0;
        $no++;

        // Menentukan status berdasarkan tanggal kadaluarsa
        $tanggal_kadaluarsa = \Carbon\Carbon::parse($obat->tanggal_kadaluarsa);
        $sekarang = \Carbon\Carbon::now();
        $selisih_hari = $sekarang->diffInDays($tanggal_kadaluarsa, false);

        if ($selisih_hari < 0) {
            $status = 'Kadaluarsa';
        } elseif ($selisih_hari <= 30) {
            $status = 'Segera Kadaluarsa';
        } elseif ($selisih_hari <= 90) {
            $status = 'Perhatian';
        } else {
            $status = 'Baik';
        }

        return [$no, $obat->nama_obat, $obat->jenis_obat, $obat->bentuk, number_format($obat->isi_kemasan), $obat->satuan, number_format($obat->stock_obat), \Carbon\Carbon::parse($obat->tanggal_masuk)->format('d/m/Y'), \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y'), $status];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            6 => [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFD3D3D3',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Stock Obat';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5, // No
            'B' => 25, // Nama Obat
            'C' => 20, // Jenis Obat
            'D' => 12, // Bentuk
            'E' => 12, // Isi Kemasan
            'F' => 10, // Satuan
            'G' => 12, // Stock Obat
            'H' => 15, // Tanggal Masuk
            'I' => 15, // Tanggal Kadaluarsa
            'J' => 18, // Status
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Menambahkan header informasi
                $sheet->insertNewRowBefore(1, 5);

                // Judul laporan
                $sheet->setCellValue('A1', 'PUSKESMAS RANTAU KOPAR');
                $sheet->mergeCells('A1:J1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Alamat
                $sheet->setCellValue('A2', 'Jalan Lintas Selatan Sei Tabuk Kec. Rantau Kopar');
                $sheet->mergeCells('A2:J2');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Alamat 2
                $sheet->setCellValue('A3', 'Kec. Rantau Kopar');
                $sheet->mergeCells('A3:J3');
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Judul laporan
                $sheet->setCellValue('A4', 'LAPORAN STOCK OBAT');
                $sheet->mergeCells('A4:J4');
                $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Informasi periode
                $periode = 'Periode: ';
                if ($this->tanggal_mulai && $this->tanggal_akhir) {
                    $periode .= date('d/m/Y', strtotime($this->tanggal_mulai)) . ' - ' . date('d/m/Y', strtotime($this->tanggal_akhir));
                } elseif ($this->tahun) {
                    $periode .= 'Tahun ' . $this->tahun;
                } else {
                    $periode .= 'Semua Data';
                }

                $sheet->setCellValue('A5', $periode);
                $sheet->mergeCells('A5:J5');
                $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A5')->getFont()->setBold(true);

                // Menambahkan border untuk seluruh data
                $dataRange = 'A6:J' . (6 + $this->obat->count());
                $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Alignment untuk kolom
                $lastRow = 6 + $this->obat->count();
                $sheet
                    ->getStyle('A7:A' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
                $sheet
                    ->getStyle('D7:D' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER); // Bentuk
                $sheet
                    ->getStyle('E7:E' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Isi Kemasan
                $sheet
                    ->getStyle('F7:F' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER); // Satuan
                $sheet
                    ->getStyle('G7:G' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Stock
                $sheet
                    ->getStyle('H7:I' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tanggal
                $sheet
                    ->getStyle('J7:J' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER); // Status
    
                // Conditional formatting untuk status dengan warna background
                for ($row = 7; $row <= $lastRow; $row++) {
                    $statusValue = $sheet->getCell('J' . $row)->getValue();

                    switch ($statusValue) {
                        case 'Kadaluarsa':
                            $sheet
                                ->getStyle('J' . $row)
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('FFFF9999'); // Light Red
                            break;
                        case 'Segera Kadaluarsa':
                            $sheet
                                ->getStyle('J' . $row)
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('FFFFCC99'); // Light Orange
                            break;
                        case 'Perhatian':
                            $sheet
                                ->getStyle('J' . $row)
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('FFFFFF99'); // Light Yellow
                            break;
                        case 'Baik':
                            $sheet
                                ->getStyle('J' . $row)
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('FF99FF99'); // Light Green
                            break;
                    }
                }

                // Menambahkan total di bawah
                $totalRow = $lastRow + 1;
                $sheet->setCellValue('I' . $totalRow, 'Total Item:');
                $sheet->setCellValue('J' . $totalRow, $this->obat->count());
                $sheet
                    ->getStyle('I' . $totalRow . ':J' . $totalRow)
                    ->getFont()
                    ->setBold(true);
                $sheet
                    ->getStyle('I' . $totalRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet
                    ->getStyle('J' . $totalRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Tanggal cetak
                $printDate = $totalRow + 2;
                $sheet->setCellValue('I' . $printDate, 'Dicetak pada: ' . date('d/m/Y H:i:s'));
                $sheet->mergeCells('I' . $printDate . ':J' . $printDate);
                $sheet
                    ->getStyle('I' . $printDate)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet
                    ->getStyle('I' . $printDate)
                    ->getFont()
                    ->setItalic(true)
                    ->setSize(9);
            },
        ];
    }
}
