<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function fetchData()
    {
        try {
            // Ambil data dari endpoint API
            $response = Http::get('https://smart-trashbin-api.onrender.com/api/getdata');
            $data = $response->json();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
    }
}
