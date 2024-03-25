<?php

namespace App\Http\Controllers\API\Bookmark;

use App\Exports\BookmarksExport;
use App\Http\Controllers\Controller;
use App\Services\Bookmark\BookmarkService;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelController extends Controller
{
    /**
     * @return BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(BookmarkService $service): BinaryFileResponse
    {
        return Excel::download(new BookmarksExport($service), 'bookmarks.xlsx');
    }
}
