<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware(['auth'])->except(''); 
    }
    // Return Response : view , json , redirect , File
    public function index(){
        return view('index');
    }
}
