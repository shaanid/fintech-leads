<?php

namespace App\Jobs;

use App\Helpers\LeadHelper;
use App\Imports\LeadImport as LeadImportFile;
use App\Models\LeadImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class LeadImportJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected LeadImport $leadImport;

    public function __construct(LeadImport $leadImport)
    {
        $this->leadImport = $leadImport;
    }

    public function handle(): void
    {
        $filePath = storage_path("app/public/{$this->leadImport->file_path}");
        if (!file_exists($filePath)) {
            Log::error("Leads file not found!");
        }

        try {
            $file = LeadHelper::createUploadedFileFromPath($filePath);
            Excel::import(new LeadImportFile, $file);
            $this->leadImport->update(['is_processed' => 1]);

            Log::info("Lead import completed");
        } catch (\Throwable $e) {
            Log::error("Lead import failed: " . $e->getMessage());
        }
    }
}
