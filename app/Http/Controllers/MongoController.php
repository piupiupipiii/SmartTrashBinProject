<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MongoController extends Controller
{
    public function getMongoData()
    {
        $response = Http::get('https://smart-trashbin-api.onrender.com/api/getdata'); // Ganti dengan URL API kamu

        if ($response->successful()) {
            $data = $response->json();

            return view('home', ['data' => $data]);
        } else {

            return response()->json(['error' => 'Unable to fetch data from API'], 500);
        }
    }
}
