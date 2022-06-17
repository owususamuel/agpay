<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Datatables;
use Illuminate\Http\Request;

class DisplayCountryController extends Controller
{  

public function index()
    {
        return Datatables::of(Country::query())->make(true);

    }

}
