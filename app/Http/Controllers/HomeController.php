<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $totalBulanan = 45;
        $data = [
            'organik' => [
                'jarak' => 11,
                'status' => 'Terisi sebagian',
                'capacity' => 45,
            ],
            'anorganik' => [
                'jarak' => 27,
                'status' => 'Hampir penuh',
                'capacity' => 85,
            ],
            'b3' => [
                'jarak' => 14,
                'status' => 'Masih kosong',
                'capacity' => 10,
            ],
        ];

        return view('home', compact('totalBulanan', 'data'));
    }
}