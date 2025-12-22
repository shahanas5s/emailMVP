<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScraperController extends Controller
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

    public function scrape(Request $request)
    {
        $url = $request->input('url');

        // CURL fetch
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return response()->json([
                'error' => 'Cannot fetch URL content'
            ], 400);
        }

         preg_match_all('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $html, $emails);

        // Extract phone numbers
        $phonePattern = '/(?:(?:\+?\d{1,3}[-.\s]?)?(?:\(?\d{3,5}\)?[-.\s]?)?\d{5,10})/';

        preg_match_all($phonePattern, $html, $phoneMatches);

        // Filter phones
        $phones = array_filter($phoneMatches[0], function($phone) {
            $digits = preg_replace('/\D/', '', $phone);
            return strlen($digits) >= 10 && strlen($digits) <= 13;
        });

        // Convert to normal indexed array
        $phonesArray = array_values($phones ?? []);

        return response()->json([
            'emails' => array_values(array_unique($emails[0] ?? [])),
            'phones' => $phonesArray
        ]);
    }

}
