<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DevController extends Controller
{
    //
    public function index(){
        return Inertia::render('Table', [
            'name' => auth()->user()->name,
        ]);
    }
}
