<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Datatables;
use Illuminate\Http\Request;

class DisplayCurrencyController extends Controller
{  

public function index()
    {
        return Datatables::of(Currency::query())->make(true);

    }

}
