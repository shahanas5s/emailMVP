<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignLog;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::withCount([
            'logs as sent_count' => function ($q) {
                $q->where('status', 'sent');
            },
            'logs as failed_count' => function ($q) {
                $q->where('status', 'failed');
            },
        ])->get();

        return response()->json($campaigns);
    }
}
?>