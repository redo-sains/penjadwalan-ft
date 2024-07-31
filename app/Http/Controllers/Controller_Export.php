<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Controller_Export extends Controller
{
    //
    public function show()
    {

        return view('admin.generate.exportExcel');
    }
}
