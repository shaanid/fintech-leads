<?php

namespace App\Http\Controllers\Api\Leads;

use App\Actions\LeadsImportAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeadImportRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class LeadsController extends Controller
{
    use ApiResponse;

    public function importLeads(LeadImportRequest $request, LeadsImportAction $leadsImportAction)
    {
        try {
            if ($leadsImportAction->execute($request->file('file'))) {
                return $this->successResponse('Leads file imported successfully.');
            }

            return $this->successResponse('Lead file import failed.');
        } catch (\Throwable $th) {
            info($th);
            return $this->errorResponse('Something went wrong during import.');
        }
    }
}
