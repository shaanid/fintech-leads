<?php

namespace App\Jobs;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\Investor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AssignDealsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $chunkSize;

    public function __construct($chunkSize = 1000)
    {
        $this->chunkSize = $chunkSize;
    }

    public function handle()
    {
        $investors = Investor::where('available', 1)->get();
        
        Lead::where('lead_score', '>=', Lead::SCORE_THRESHOLD)
            ->where('is_assigned', Lead::STATUS_UNASSIGNED)
            ->chunk($this->chunkSize, function ($leads) use ($investors) {
                foreach ($leads as $lead) {
                    Deal::create([
                        'lead_id' => $lead->id,
                        'investor_id' => $investors->random()->id,
                        'funded_amount' => $lead->requested_amount,
                    ]);
                    $lead->update(['is_assigned' => 1]);
                }
            });
    }
}
