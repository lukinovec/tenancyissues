<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;

class JetstreamDashboard extends Controller // implements HasMiddleware
{
    public function index()
    {
        return view('dashboard');
    }

    /* public static function middleware()
    {
        return [];
    } */
}