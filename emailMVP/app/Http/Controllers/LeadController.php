<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * List all leads
     */
    public function index()
    {
        return Lead::all();
    }

    /**
     * Store new leads
     */
    public function store(Request $request)
    {
        // If saving single lead:
       if ($request->has('email') && !is_array($request->email)) {

            $lead = Lead::updateOrCreate(
                ['email' => $request->input('email')],
                [
                    'name'    => $request->input('name'),
                    'company' => $request->input('company'),
                    'website' => $request->input('website'),
                    'phone'   => $request->input('phone'),
                ]
            );

            return response()->json($lead, 200);
        }

        // If saving multiple scraped leads:
        $emails = $request->input('emails', []);
        $phones = $request->input('phones', []);

        $saved = [];

        foreach ($emails as $index => $email) {
            $saved[] = Lead::create([
                'email' => $email,
                'phone' => $phones[$index] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Leads saved successfully!',
            'data' => $saved
        ], 201);
    }

    /**
     * Show a single lead
     */
    public function show($id)
    {
        return Lead::findOrFail($id);
    }

    /**
     * Update a lead
     */
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $lead->update($request->all());

        return response()->json($lead);
    }

    /**
     * Delete a lead
     */
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json(['message' => 'Lead deleted successfully!']);
    }
}
