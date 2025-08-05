<?php

namespace App\Http\Controllers\Api\BankStatement;

use App\Actions\BankStatementAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankStatementRequest;
use App\Models\BankStatement;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class BankStatementController extends Controller
{
    use ApiResponse;

    public function uploadStatement(BankStatementRequest $request, $id)
    {
        (new BankStatementAction())->execute($request->file('statements'), $id);

        return $this->successResponse('Bank statement has been uploaded successfully.');
    }
}
