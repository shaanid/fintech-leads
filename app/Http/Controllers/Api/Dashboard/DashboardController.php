<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\LeadHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardSummary\DashboardSummaryResource;
use App\Models\Deal;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    use ApiResponse;

    public function summary()
    {
        $summary = Cache::remember('dashboard_summary', 60, function () {
            $totalLeads     = Lead::distinct()->count('id');
            $totalRequested = Lead::sum('requested_amount');
            $totalDeals     = Deal::count();
            $totalFunded    = Deal::sum('funded_amount');

            return [
                'total_leads'         => $totalLeads,
                'total_deals'         => $totalDeals,
                'total_requested'     => $totalRequested,
                'total_funded_amount' => $totalFunded,
                'funding_ratio'       => LeadHelper::calculateFundingRatio($totalRequested, $totalFunded),
            ];
        });

        return $this->successResponse('Dashboard Summary', $summary);
    }
}
