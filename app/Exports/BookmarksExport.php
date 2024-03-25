<?php

namespace App\Exports;

use App\Services\Bookmark\BookmarkService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookmarksExport implements FromCollection, WithHeadings
{
    /**
     * @var BookmarkService
     */
    private BookmarkService $bookmarkSertvice;

    /**
     * Create a new bookmarks export instance.
     *
     * @param BookmarkService $bookmarkSertvice
     */
    public function __construct(BookmarkService $bookmarkSertvice)
    {
        $this->bookmarkSertvice = $bookmarkSertvice;
    }
    /**
     * Return bookmarks collection.
     *
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->bookmarkSertvice->getExcelList();
    }

    /**
     * Get headings for table
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'ID',
            'Favicon path',
            'URL',
            'Title',
            'Meta description',
            'Meta keywords',
            'Created at'
        ];
    }
}
