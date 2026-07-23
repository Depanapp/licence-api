<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Licence;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $licences = Licence::with(['entreprise', 'appareils'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact('licences'));
    }
}