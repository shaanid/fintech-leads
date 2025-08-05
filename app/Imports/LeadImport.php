<?php

namespace App\Imports;

use App\Models\Lead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;

class LeadImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation, SkipsOnFailure, SkipsOnError, ShouldQueue
{
    use SkipsFailures, SkipsErrors;

    public function model(array $row)
    {
        return new Lead([
            'merchant_name'    => $row['merchant_name'],
            'requested_amount' => $row['requested_amount'],
            'lead_score'       => $row['lead_score'],
        ]);
    }

    public function rules(): array
    {
        return [
            'merchant_name'    => 'required|string|max:255',
            'requested_amount' => 'required|numeric',
            'lead_score'       => 'required|numeric',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function onError(\Throwable $e)
    {
        Log::error('Lead import failed: ' . $e->getMessage());
    }
}
