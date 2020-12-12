<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;

class HistoryController extends Controller
{
    //
    public function show(){
        
        $inquiries = Content::orderBy('id', 'desc')->paginate(10);
        return view('history', ['inquiries' => $inquiries]);
    }
}
