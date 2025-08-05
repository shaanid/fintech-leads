<?php

namespace App\Actions;

use App\Helpers\LeadHelper;
use App\Models\BankStatement;

class BankStatementAction
{

    public function execute(array $files, int $leadId): void
    {
        foreach ($files as $file) {
            $path = LeadHelper::storeFileWithOriginalName($file, "bank_statements/{$leadId}");
            BankStatement::create([
                'lead_id' => $leadId,
                'file_path' => $path,
            ]);
        }
    }
}
