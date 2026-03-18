<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BookExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting, WithEvents
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Book::query()
            ->search($this->filters['search'] ?? null)
            ->status($this->filters['status'] ?? null)
            ->publishedBetween($this->filters['published_from'] ?? null, $this->filters['published_to'] ?? null)
            ->orderBy('published_date', 'desc')
            ->get()
            ->map(function ($book) {
                return [
                    'Title' => $book->title,
                    'Author' => $book->author,
                    'ISBN' => $this->formatIsbn($book->isbn),
                    'Publisher' => $book->publisher,
                    'Published Date' => $book->published_date?->format('Y-m-d'),
                    'Category' => $book->category,
                    'Language' => strtoupper($book->language),
                    'Pages' => $book->pages,
                    'Status' => ucfirst($book->status),
                    'Price' => $book->price,
                ];
            });
    }

    public function headings(): array
    {
        return array_keys($this->collection()->first() ?? []);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '3490DC'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Data rows
            'A2:Z1000' => [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => Alignment::VERTICAL_TOP,
                ],
            ],
        ];
    }

   public function columnFormats(): array
{
    return [
        'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,     // Published Date
        'I' => '€#,##0.00_-',                          // Price (EUR custom format)
    ];
}

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Apply borders to all cells
                $event->sheet->getDelegate()->getStyle(
                    $event->sheet->getDelegate()->calculateWorksheetDimension()
                )->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                ]);

                // Freeze the first row
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }

    protected function formatIsbn(?string $isbn): string
    {
        if (!$isbn) return '';
        
        // Format ISBN with hyphens if it's 13 digits
        if (strlen($isbn) === 13) {
            return substr($isbn, 0, 3) . '-' . 
                   substr($isbn, 3, 1) . '-' . 
                   substr($isbn, 4, 4) . '-' . 
                   substr($isbn, 8, 4) . '-' . 
                   substr($isbn, 12);
        }

        return $isbn;
    }
}