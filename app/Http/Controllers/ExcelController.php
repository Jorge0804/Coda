<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Input;

class ExcelController extends Controller
{
    public static function importar(Request $r)
    {
    	return Input::file('file');
    	return Excel::load(storage_path($r->file), function($archivo){

    	})->get();
    }
}
