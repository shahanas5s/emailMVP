<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\CampaignLog;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function send(Request $request)
    {
        $campaign = Campaign::create([
            'subject' => $request->name,
            'body' => $request->message,
        ]);

        $leads = Lead::all();
        //return response()->json($leads);

       foreach ($leads as $lead) {
        try {
            Mail::raw($request->message, function ($msg) use ($lead, $request) {
                $msg->to($lead->email)->subject($request->name);
            });

            CampaignLog::create([
                'campaign_id' => $campaign->id,
                'lead_id'     => $lead->id,
                'status'      => 'sent',
                'email_account_used' => 'primary-account', // optional
                'sent_at'     => now(),
            ]);

        } catch (\Exception $e) {

            CampaignLog::create([
                'campaign_id' => $campaign->id,
                'lead_id'     => $lead->id,
                'status'      => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
}


        return response()->json(['status' => 'success']);
    }

}
