<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Feature;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
    public function dashboard()
    {
        $features = Feature::latest()->get();
        $clients = Customer::latest()->get();

        return Inertia::render('Dashboard', ['features' => $features, 'clients' => $clients]);
    }
}
