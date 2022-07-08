<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the dashboard view.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
