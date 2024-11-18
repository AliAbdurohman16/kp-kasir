<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Helpers\StringHelper;
use Carbon\Carbon;

class ExportReport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $data;
    protected $totalSum = 0;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->data = collect();
    }
    
    public function collection()
    {
        $this->data = Transaction::when($this->startDate, function ($query) {
                            $query->where('created_at', '>=', $this->startDate);
                        })
                        ->when($this->endDate, function ($query) {
                            $query->where('created_at', '<=', $this->endDate);
                        })
                        ->get();
        
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['Laporan Data'],
            ['Tanggal Export : ' . Carbon::now()->locale('id')->format('d-m-Y H:i:s')],
            [],
            ['NO', 'Tanggal Transaksi', 'Produk', 'Qty', 'Total']
        ];
    }

    public function map($row): array
    {
        static $no = 1;

        $this->totalSum += $row->total;

        $data = [];

        $date = Carbon::parse($row->created_at)->translatedFormat('d/m/Y H:i');

        foreach ($row->Cart->CartDetails as $detail) {
            $data[] = [
                'no'          => $no++,
                'date'        => $date,
                'product'     => $detail->Product->name,
                'qty'         => $detail->qty,
                'price'       => 'Rp ' . number_format($detail->amount, 0, ',', '.'),
            ];
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A4:E4')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'D9EAD3'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);

        $highestRow = $sheet->getHighestRow();

        $sheet->setCellValue('D' . ($highestRow + 1), 'Total Keseluruhan');
        $sheet->setCellValue('E' . ($highestRow + 1), 'Rp ' . number_format($this->totalSum, 0, ',', '.'));

        $sheet->getStyle('D' . ($highestRow + 1) . ':E' . ($highestRow + 1))->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // NO Text Center
        $sheet->getStyle('A5:A' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        
        // QTY Text Center
        $sheet->getStyle('D5:D' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        $sheet->getStyle('A5:E' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Format Total Text Right
        $sheet->getStyle('E5:E' . ($highestRow + 1))->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
