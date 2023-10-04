<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('panel.dashboard.view', [ 'totalWhatsAppSubscribers' => 100, 'getCustomers' => 10, 'totalCoaches' => 11, 'verifiedCoach' => 42, 'totalAppointment' => 100]);
    }
}
