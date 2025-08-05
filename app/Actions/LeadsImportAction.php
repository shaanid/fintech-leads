<?php

namespace App\Actions;

use App\Helpers\LeadHelper;
use App\Models\LeadImport;
use Illuminate\Http\UploadedFile;

class LeadsImportAction
{

    public function execute(UploadedFile $file): bool
    {
        try {
            $path = LeadHelper::storeFileWithOriginalName($file, 'lead_uploads');
            LeadImport::create([
                'user_id' => auth()->user()->id,
                'file_path' => $path,
                'is_processed' => LeadImport::STATUS_PENDING,
            ]);

            return true;
        } catch (\Throwable $th) {
            info($th);
            return false;
        }
    }
}
