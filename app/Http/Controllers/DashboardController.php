<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Band;

class DashboardController extends Controller
{
    public function index()
    {
        $bandsCount = Band::count();
        $albumsCount = Album::count();

        return view('auth.dashboard', compact('bandsCount', 'albumsCount'));
    }
}
