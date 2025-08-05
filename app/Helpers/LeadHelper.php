<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class LeadHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function calculateFundingRatio($requested, $funded): float
    {
        if ($requested == 0) return 0;
        return round(($funded / $requested) * 100, 2);
    }

    public static function parseCSV(string $path): array
    {
        $data = [];
        if (!file_exists($path) || !($handle = fopen($path, 'r'))) {
            return $data;
        }
        $header = fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = array_combine($header, $row);
        }
        fclose($handle);

        return $data;
    }

    public static function createUploadedFileFromPath(string $path): ?UploadedFile
    {
        if (!file_exists($path)) {
            return null;
        }

        return new UploadedFile(
            $path,
            basename($path),
            mime_content_type($path),
            null,
            true
        );
    }

    public static function storeFileWithOriginalName(UploadedFile $file, string $folderPath): string
    {
        $filename = $file->getClientOriginalName();

        return $file->storeAs(
            $folderPath,
            $filename,
            'public'
        );
    }
}
