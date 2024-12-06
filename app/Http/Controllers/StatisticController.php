<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        // Kirim data yang dibutuhkan ke halaman statistic.blade.php
        return view('statistic');
    }
}
