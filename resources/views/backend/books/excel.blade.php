<?php
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell
{
    protected $filters;
    protected $serial = 0;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Book::with('category')
            ->filter($this->filters)
            ->orderBy('published_date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Sr. No.',
            'Title',
            'Author',
            'Publisher',
            'Published Date',
            'Category',
            'Status',
            'Price'
        ];
    }

    public function map($book): array
    {
        return [
            ++$this->serial,
            $book->title,
            $book->author,
            $book->publisher,
            optional($book->published_date)->format('d M Y'),
            $book->category->name ?? 'N/A',
            ucfirst($book->status),
             $book->price,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }
}
