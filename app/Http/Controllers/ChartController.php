<?php

namespace App\Http\Controllers;

use App\Chart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Render task chart
     */
    public function taskChart()
    {
        
    }
}
