<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tejuino\Adminbase\Controllers\AdminController;

class DashboardController extends AdminController
{

    public function __construct()
    {
        $this->middleware('admin');
        $this->section = "Dashboard";
    }

    public function index(Request $request)
    {
        return $this->view('dashboard.dashboard', []);
    }

}
